<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BusquedaExteriorController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->get('q', ''));
        $resultados = [];
        $errores = [];

        if ($query === '') {
            return view('public.busqueda_exterior', compact('resultados', 'errores', 'query'));
        }

        // En desarrollo local (WAMP/XAMPP Windows) cURL a veces falla por SSL
        // si php.ini no tiene curl.cainfo configurado. Permitimos saltarlo en local.
        $sslVerify = !app()->environment('local') || env('CURL_VERIFY_SSL', true);

        $googleCseEnabled = config('services.google_cse.key') && config('services.google_cse.id');

        try {
            $responses = Http::pool(function ($pool) use ($query, $sslVerify, $googleCseEnabled) {
                $requests = [
                    $pool->as('mercadolibre')
                        ->timeout(12)
                        ->withOptions(['verify' => $sslVerify])
                        ->withHeaders(['Accept' => 'application/json', 'User-Agent' => 'InmoTech/1.0'])
                        ->get('https://api.mercadolibre.com/sites/MLM/search', [
                            'category' => 'MLM1459',
                            'q'        => $query,
                            'limit'    => 20,
                        ]),
                ];

                if ($googleCseEnabled) {
                    $requests[] = $pool->as('google')
                        ->timeout(12)
                        ->withOptions(['verify' => $sslVerify])
                        ->withHeaders(['Accept' => 'application/json', 'User-Agent' => 'InmoTech/1.0'])
                        ->get('https://www.googleapis.com/customsearch/v1', [
                            'key' => config('services.google_cse.key'),
                            'cx'  => config('services.google_cse.id'),
                            'q'   => $query . ' inmuebles',
                            'num' => 10,
                        ]);
                }

                return $requests;
            });
        } catch (\Throwable $e) {
            Log::error('Búsqueda exterior — falla global del pool', ['error' => $e->getMessage()]);
            $errores['general'] = 'Error general al consultar portales: ' . $e->getMessage();
            return view('public.busqueda_exterior', compact('resultados', 'errores', 'query'));
        }

        // ── MERCADO LIBRE ────────────────────────────────────────────
        try {
            $ml = $responses['mercadolibre'];

            // Si la respuesta es una excepción del pool (timeout, DNS, SSL)
            if ($ml instanceof \Throwable) {
                throw $ml;
            }

            if ($ml->successful()) {
                $data = $ml->json();
                $resultados['mercadolibre'] = [
                    'nombre' => 'Mercado Libre',
                    'color'  => '#FFE600',
                    'icon'   => 'fas fa-store',
                    'items'  => collect($data['results'] ?? [])->map(fn ($item) => [
                        'titulo'    => $item['title'],
                        'precio'    => $item['price'],
                        'moneda'    => $item['currency_id'] ?? 'MXN',
                        'imagen'    => isset($item['thumbnail'])
                            ? str_replace('-I.jpg', '-O.jpg', $item['thumbnail'])
                            : null,
                        'url'       => $item['permalink'],
                        'ubicacion' => $item['address']['city_name'] ?? null,
                        'atributos' => collect($item['attributes'] ?? [])
                            ->whereIn('id', ['BEDROOMS', 'BATHROOMS', 'TOTAL_AREA'])
                            ->mapWithKeys(fn ($a) => [$a['id'] => $a['value_name']])
                            ->all(),
                    ])->all(),
                ];
            } else {
                $errores['mercadolibre'] = "Mercado Libre devolvió HTTP {$ml->status()}";
                Log::warning('ML error', ['status' => $ml->status(), 'body' => substr($ml->body(), 0, 300)]);
            }
        } catch (\Throwable $e) {
            $errores['mercadolibre'] = 'No se pudo conectar con Mercado Libre: ' . $this->shortError($e);
            Log::warning('ML exception', ['error' => $e->getMessage()]);
        }

        // ── GOOGLE CSE ───────────────────────────────────────────────
        if ($googleCseEnabled && isset($responses['google'])) {
            try {
                $g = $responses['google'];

                if ($g instanceof \Throwable) {
                    throw $g;
                }

                if ($g->successful()) {
                    $data = $g->json();
                    $resultados['google'] = [
                        'nombre' => 'Google (multi-portal)',
                        'color'  => '#4285F4',
                        'icon'   => 'fab fa-google',
                        'items'  => collect($data['items'] ?? [])->map(fn ($item) => [
                            'titulo'      => $item['title'],
                            'precio'      => null,
                            'imagen'      => $item['pagemap']['cse_image'][0]['src']
                                ?? $item['pagemap']['og:image'][0]['content']
                                ?? null,
                            'url'         => $item['link'],
                            'descripcion' => $item['snippet'] ?? null,
                            'fuente'      => parse_url($item['link'], PHP_URL_HOST),
                        ])->all(),
                    ];
                } elseif ($g->status() === 429) {
                    $errores['google'] = 'Cuota diaria de Google CSE agotada (100 búsquedas/día gratuitas). Vuelve mañana.';
                } elseif ($g->status() === 403) {
                    $errores['google'] = 'Google CSE: API key inválida o restringida (HTTP 403). Revisa GOOGLE_CSE_KEY en .env';
                } elseif ($g->status() === 400) {
                    $errores['google'] = 'Google CSE: configuración inválida (HTTP 400). Revisa GOOGLE_CSE_ID en .env';
                } else {
                    $errores['google'] = "Google CSE devolvió HTTP {$g->status()}";
                    Log::warning('Google CSE error', ['status' => $g->status(), 'body' => substr($g->body(), 0, 300)]);
                }
            } catch (\Throwable $e) {
                $errores['google'] = 'No se pudo conectar con Google: ' . $this->shortError($e);
                Log::warning('Google exception', ['error' => $e->getMessage()]);
            }
        }

        return view('public.busqueda_exterior', compact('resultados', 'errores', 'query'));
    }

    /**
     * Mensaje corto y amigable para el usuario a partir de una excepción de cURL/Guzzle.
     */
    private function shortError(\Throwable $e): string
    {
        $msg = $e->getMessage();

        if (str_contains($msg, 'SSL certificate') || str_contains($msg, 'certificate verify')) {
            return 'problema SSL en el servidor (en Windows agrega CURL_VERIFY_SSL=false al .env como workaround temporal)';
        }
        if (str_contains($msg, 'Could not resolve host') || str_contains($msg, 'DNS')) {
            return 'sin conexión a internet';
        }
        if (str_contains($msg, 'timed out') || str_contains($msg, 'Timeout')) {
            return 'el portal no respondió a tiempo';
        }
        return 'error de red';
    }
}
