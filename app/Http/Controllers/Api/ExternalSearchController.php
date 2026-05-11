<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalSearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $fuentes = [];
        $sslVerify = !app()->environment('local') || env('CURL_VERIFY_SSL', true);

        // Ejecutar todas las busquedas en paralelo
        try {
            $responses = Http::pool(fn($pool) => [
                $pool->as('mercadolibre')->timeout(8)->withOptions(['verify' => $sslVerify])->get(
                    'https://api.mercadolibre.com/sites/MLM/search',
                    $this->paramsML($request)
                ),
                $pool->as('lamudi')->timeout(8)->withOptions(['verify' => $sslVerify])
                    ->withHeaders(['Accept' => 'application/json', 'X-Requested-With' => 'XMLHttpRequest'])
                    ->get('https://www.lamudi.com.mx/api/1.0.0/listings/', $this->paramsLamudi($request)),
                $pool->as('vivanuncios')->timeout(8)->withOptions(['verify' => $sslVerify])
                    ->withHeaders(['Accept' => 'application/json'])
                    ->get('https://api.vivanuncios.com.mx/v2/private/items', $this->paramsVivanuncios($request)),
                $pool->as('google')->timeout(8)->withOptions(['verify' => $sslVerify])->get(
                    'https://www.googleapis.com/customsearch/v1',
                    $this->paramsGoogle($request)
                ),
            ]);

            // Log de diagnostico por fuente
            foreach (['mercadolibre', 'lamudi', 'vivanuncios', 'google'] as $src) {
                $r = $responses[$src] ?? null;
                if ($r instanceof \Throwable) {
                    Log::info("ExternalSearch [$src] EXCEPTION: " . get_class($r) . ' - ' . $r->getMessage());
                } elseif ($r) {
                    Log::info("ExternalSearch [$src] HTTP " . $r->status() . ' body=' . substr($r->body(), 0, 200));
                } else {
                    Log::info("ExternalSearch [$src] NULL response");
                }
            }

            $fuentes[] = $this->parseMercadoLibre($responses['mercadolibre'] ?? null);
            $fuentes[] = $this->parseLamudi($responses['lamudi'] ?? null);
            $fuentes[] = $this->parseVivanuncios($responses['vivanuncios'] ?? null);
            $fuentes[] = $this->parseGoogle($responses['google'] ?? null);

        } catch (\Throwable $e) {
            Log::warning('ExternalSearch pool error: ' . $e->getMessage());
        }

        // Filtrar fuentes vacias / fallidas
        $fuentes = array_values(array_filter($fuentes, fn($f) => $f !== null && !empty($f['resultados'])));

        return response()->json(['fuentes' => $fuentes]);
    }

    // ── MERCADO LIBRE ──────────────────────────────────────────────

    private function paramsML(Request $request): array
    {
        $p = ['category' => 'MLM1459', 'limit' => 9];
        $p['q'] = $request->input('busqueda', 'casa');
        $min = $request->input('precio_min');
        $max = $request->input('precio_max');
        if ($min || $max) $p['price'] = ($min ?: '*') . '-' . ($max ?: '*');
        if ($request->filled('habitaciones')) $p['BEDROOMS'] = $request->habitaciones . '-*';
        if ($request->filled('tipo_operacion_id')) $p['OPERATION'] = $request->tipo_operacion_id == 1 ? 'sale' : 'rent';
        return $p;
    }

    private function parseMercadoLibre($response): ?array
    {
        try {
            if (!$response || $response instanceof \Throwable || !$response->successful()) return null;
            $data  = $response->json();
            $items = array_slice($data['results'] ?? [], 0, 9);
            if (empty($items)) return null;

            return [
                'fuente'     => 'mercadolibre',
                'nombre'     => 'Mercado Libre',
                'color'      => '#ffe600',
                'text_color' => '#333333',
                'logo'       => 'https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/5.19.5/mercadolibre/logo__small.png',
                'total'      => $data['paging']['total'] ?? count($items),
                'resultados' => array_map(function ($item) {
                    $attrs = collect($item['attributes'] ?? []);
                    $img   = $item['thumbnail'] ?? null;
                    if ($img) $img = str_replace(['http://', '-I.jpg'], ['https://', '-O.jpg'], $img);
                    return [
                        'titulo'       => $item['title'] ?? 'Propiedad',
                        'precio'       => $item['price'] ?? 0,
                        'moneda'       => $item['currency_id'] ?? 'MXN',
                        'imagen'       => $img,
                        'url'          => $item['permalink'] ?? '#',
                        'ubicacion'    => trim(($item['location']['city']['name'] ?? '') . ', ' . ($item['location']['state']['name'] ?? 'Mexico'), ', '),
                        'habitaciones' => $attrs->firstWhere('id', 'BEDROOMS')['value_name'] ?? null,
                        'banios'       => $attrs->firstWhere('id', 'FULL_BATHROOMS')['value_name'] ?? null,
                        'metros'       => $attrs->firstWhere('id', 'COVERED_AREA')['value_name'] ?? null,
                        'tipo'         => $attrs->firstWhere('id', 'PROPERTY_TYPE')['value_name'] ?? 'Inmueble',
                    ];
                }, $items),
            ];
        } catch (\Throwable $e) {
            Log::warning('ML parse error: ' . $e->getMessage());
            return null;
        }
    }

    // ── LAMUDI ─────────────────────────────────────────────────────

    private function paramsLamudi(Request $request): array
    {
        $p = ['page[size]' => 9, 'search[location_name]' => 'Mexico'];
        $p['search[q]'] = $request->input('busqueda', 'casa');
        if ($request->filled('precio_min')) $p['filters[price][min]'] = $request->precio_min;
        if ($request->filled('precio_max')) $p['filters[price][max]'] = $request->precio_max;
        if ($request->filled('habitaciones')) $p['filters[bedrooms][min]'] = $request->habitaciones;
        return $p;
    }

    private function parseLamudi($response): ?array
    {
        try {
            if (!$response || $response instanceof \Throwable || !$response->successful()) return null;
            $data  = $response->json();
            $items = $data['results'] ?? ($data['data'] ?? []);
            if (empty($items)) return null;

            return [
                'fuente'     => 'lamudi',
                'nombre'     => 'Lamudi',
                'color'      => '#e31837',
                'text_color' => '#ffffff',
                'logo'       => null,
                'total'      => $data['meta']['total'] ?? count($items),
                'resultados' => array_map(fn($item) => [
                    'titulo'       => $item['title'] ?? ($item['headline'] ?? 'Propiedad'),
                    'precio'       => $item['price'] ?? ($item['attributes']['price'] ?? 0),
                    'moneda'       => 'MXN',
                    'imagen'       => $item['image']['url'] ?? ($item['thumbnail'] ?? null),
                    'url'          => 'https://www.lamudi.com.mx' . ($item['url'] ?? ''),
                    'ubicacion'    => $item['location']['name'] ?? ($item['address'] ?? 'Mexico'),
                    'habitaciones' => $item['attributes']['bedrooms'] ?? null,
                    'banios'       => $item['attributes']['bathrooms'] ?? null,
                    'metros'       => $item['attributes']['floor_size'] ?? null,
                    'tipo'         => $item['property_type'] ?? 'Inmueble',
                ], array_slice($items, 0, 9)),
            ];
        } catch (\Throwable $e) {
            Log::warning('Lamudi parse error: ' . $e->getMessage());
            return null;
        }
    }

    // ── VIVANUNCIOS ────────────────────────────────────────────────

    private function paramsVivanuncios(Request $request): array
    {
        $p = ['limit' => 9, 'category_ids' => '8000'];
        $p['q'] = $request->input('busqueda', 'casa');
        if ($request->filled('precio_min')) $p['price_min'] = $request->precio_min;
        if ($request->filled('precio_max')) $p['price_max'] = $request->precio_max;
        if ($request->filled('habitaciones')) $p['rooms_min'] = $request->habitaciones;
        return $p;
    }

    private function parseVivanuncios($response): ?array
    {
        try {
            if (!$response || $response instanceof \Throwable || !$response->successful()) return null;
            $data  = $response->json();
            $items = $data['items'] ?? ($data['results'] ?? ($data['data'] ?? []));
            if (empty($items)) return null;

            return [
                'fuente'     => 'vivanuncios',
                'nombre'     => 'Vivanuncios',
                'color'      => '#7c3aed',
                'text_color' => '#ffffff',
                'logo'       => null,
                'total'      => $data['total'] ?? count($items),
                'resultados' => array_map(fn($item) => [
                    'titulo'       => $item['title'] ?? ($item['subject'] ?? 'Propiedad'),
                    'precio'       => $item['price']['value'] ?? ($item['price'] ?? 0),
                    'moneda'       => $item['price']['currency'] ?? 'MXN',
                    'imagen'       => $item['images'][0]['url'] ?? ($item['thumbnail'] ?? null),
                    'url'          => $item['url'] ?? ($item['link'] ?? '#'),
                    'ubicacion'    => $item['location']['name'] ?? ($item['city'] ?? 'Mexico'),
                    'habitaciones' => $item['params']['rooms'] ?? null,
                    'banios'       => $item['params']['bathrooms'] ?? null,
                    'metros'       => $item['params']['m2'] ?? null,
                    'tipo'         => $item['category']['name'] ?? 'Inmueble',
                ], array_slice($items, 0, 9)),
            ];
        } catch (\Throwable $e) {
            Log::warning('Vivanuncios parse error: ' . $e->getMessage());
            return null;
        }
    }

    // ── GOOGLE CUSTOM SEARCH ──────────────────────────────────────

    private function paramsGoogle(Request $request): array
    {
        $key = config('services.google_cse.key');
        $cx  = config('services.google_cse.id');

        if (!$key || !$cx) return ['_skip' => true];

        $query = $request->input('busqueda', 'casas en venta Mexico');
        if ($request->filled('precio_min') || $request->filled('precio_max')) {
            $query .= ' precio';
        }

        return [
            'key'  => $key,
            'cx'   => $cx,
            'q'    => $query . ' inmuebles',
            'num'  => 9,
            'gl'   => 'mx',
            'lr'   => 'lang_es',
        ];
    }

    private function parseGoogle($response): ?array
    {
        // No configurado o no se solicito
        if (!$response || $response instanceof \Throwable || isset($this->paramsGoogle(request())['_skip'])) return null;

        try {
            if (!$response->successful()) return null;
            $data  = $response->json();
            $items = $data['items'] ?? [];
            if (empty($items)) return null;

            return [
                'fuente'     => 'google',
                'nombre'     => 'Web (Google)',
                'color'      => '#4285f4',
                'text_color' => '#ffffff',
                'logo'       => null,
                'total'      => (int) ($data['searchInformation']['totalResults'] ?? count($items)),
                'resultados' => array_map(function ($item) {
                    $pagemap = $item['pagemap'] ?? [];
                    $og      = $pagemap['og_title'][0] ?? [];
                    $meta    = $pagemap['metatags'][0] ?? [];
                    $img     = $pagemap['cse_image'][0]['src'] ?? ($pagemap['og:image'][0] ?? null);
                    $precio  = null;
                    if (preg_match('/\$[\d,]+/', $item['snippet'] ?? '', $m)) {
                        $precio = (int) str_replace([',', '$'], '', $m[0]);
                    }
                    return [
                        'titulo'       => $item['title'] ?? 'Propiedad',
                        'precio'       => $precio,
                        'moneda'       => 'MXN',
                        'imagen'       => $img,
                        'url'          => $item['link'] ?? '#',
                        'ubicacion'    => $meta['og:site_name'] ?? parse_url($item['link'] ?? '', PHP_URL_HOST) ?: 'Mexico',
                        'habitaciones' => null,
                        'banios'       => null,
                        'metros'       => null,
                        'tipo'         => $item['displayLink'] ?? 'Inmueble',
                        'snippet'      => $item['snippet'] ?? null,
                    ];
                }, $items),
            ];
        } catch (\Throwable $e) {
            Log::warning('Google CSE parse error: ' . $e->getMessage());
            return null;
        }
    }
}
