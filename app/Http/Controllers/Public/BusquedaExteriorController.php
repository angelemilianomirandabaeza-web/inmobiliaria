<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        $responses = Http::pool(function ($pool) use ($query) {
            $requests = [
                $pool->as('mercadolibre')
                    ->timeout(10)
                    ->get('https://api.mercadolibre.com/sites/MLM/search', [
                        'category' => 'MLM1459',
                        'q'        => $query,
                        'limit'    => 20,
                    ]),
            ];

            if (config('services.google_cse.key') && config('services.google_cse.id')) {
                $requests[] = $pool->as('google')
                    ->timeout(10)
                    ->get('https://www.googleapis.com/customsearch/v1', [
                        'key' => config('services.google_cse.key'),
                        'cx'  => config('services.google_cse.id'),
                        'q'   => $query . ' inmuebles',
                        'num' => 10,
                    ]);
            }

            return $requests;
        });

        // MercadoLibre
        try {
            $ml = $responses['mercadolibre'];
            if ($ml->successful()) {
                $data = $ml->json();
                $resultados['mercadolibre'] = [
                    'nombre' => 'Mercado Libre',
                    'logo'   => 'https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/6.6.92/mercadolibre/logo__large_plus.png',
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
                $errores['mercadolibre'] = 'No se pudo conectar con Mercado Libre';
            }
        } catch (\Throwable $e) {
            $errores['mercadolibre'] = 'Error al consultar Mercado Libre';
        }

        // Google CSE
        if (isset($responses['google'])) {
            try {
                $g = $responses['google'];
                if ($g->successful()) {
                    $data = $g->json();
                    $resultados['google'] = [
                        'nombre' => 'Google (multi-portal)',
                        'logo'   => null,
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
                    $errores['google'] = 'Cuota diaria de Google CSE agotada (100 búsquedas/día gratuitas)';
                } else {
                    $errores['google'] = 'Error al consultar Google CSE';
                }
            } catch (\Throwable $e) {
                $errores['google'] = 'Error al consultar Google CSE';
            }
        }

        return view('public.busqueda_exterior', compact('resultados', 'errores', 'query'));
    }
}
