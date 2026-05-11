<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalSearchController extends Controller
{
    // Categoria de Inmuebles en Mercado Libre Mexico
    private const ML_CATEGORY = 'MLM1459';
    private const ML_SEARCH_URL = 'https://api.mercadolibre.com/sites/MLM/search';

    public function search(Request $request): JsonResponse
    {
        $params = $this->buildParams($request);

        try {
            $response = Http::timeout(8)
                ->get(self::ML_SEARCH_URL, $params);

            if (!$response->successful()) {
                return response()->json(['resultados' => [], 'total' => 0, 'fuente' => 'mercadolibre']);
            }

            $data     = $response->json();
            $items    = $data['results'] ?? [];
            $total    = $data['paging']['total'] ?? 0;
            $sanitized = array_map(fn($item) => $this->sanitizeItem($item), array_slice($items, 0, 12));

            return response()->json([
                'resultados' => $sanitized,
                'total'      => $total,
                'fuente'     => 'mercadolibre',
            ]);

        } catch (\Throwable $e) {
            Log::warning('ExternalSearch error: ' . $e->getMessage());
            return response()->json(['resultados' => [], 'total' => 0, 'fuente' => 'mercadolibre', 'error' => true]);
        }
    }

    private function buildParams(Request $request): array
    {
        $params = [
            'category' => self::ML_CATEGORY,
            'limit'    => 12,
            'offset'   => 0,
        ];

        // Texto de busqueda
        if ($request->filled('busqueda')) {
            $params['q'] = $request->busqueda;
        }

        // Rango de precio
        $min = $request->input('precio_min');
        $max = $request->input('precio_max');
        if ($min || $max) {
            $params['price'] = ($min ?: '*') . '-' . ($max ?: '*');
        }

        // Habitaciones — ML usa atributo BEDROOMS
        if ($request->filled('habitaciones')) {
            $params['BEDROOMS'] = $request->habitaciones . '-*';
        }

        // Tipo de operacion: 1=Venta, 2=Renta — aproximado
        if ($request->filled('tipo_operacion_id')) {
            // ML: OPERATION = sale | rent
            $params['OPERATION'] = $request->tipo_operacion_id == 1 ? 'sale' : 'rent';
        }

        // Ubicacion: si hay colonia o busqueda en Mexico incluir CDMX por defecto
        if (!$request->filled('busqueda')) {
            $params['q'] = 'casa';
        }

        return $params;
    }

    private function sanitizeItem(array $item): array
    {
        $thumbnail = $item['thumbnail'] ?? null;
        // ML devuelve http:// — forzar https://
        if ($thumbnail) {
            $thumbnail = str_replace('http://', 'https://', $thumbnail);
            // Pedir imagen de mayor resolucion
            $thumbnail = str_replace('-I.jpg', '-O.jpg', $thumbnail);
        }

        $attrs = collect($item['attributes'] ?? []);
        $bedrooms   = $attrs->firstWhere('id', 'BEDROOMS')['value_name'] ?? null;
        $bathrooms  = $attrs->firstWhere('id', 'FULL_BATHROOMS')['value_name'] ?? null;
        $area        = $attrs->firstWhere('id', 'COVERED_AREA')['value_name'] ?? null;
        $propertyType = $attrs->firstWhere('id', 'PROPERTY_TYPE')['value_name'] ?? null;

        return [
            'id'            => $item['id'] ?? null,
            'titulo'        => $item['title'] ?? 'Propiedad',
            'precio'        => $item['price'] ?? 0,
            'moneda'        => $item['currency_id'] ?? 'MXN',
            'imagen'        => $thumbnail,
            'url'           => $item['permalink'] ?? '#',
            'ubicacion'     => ($item['location']['city']['name'] ?? '') . ', ' . ($item['location']['state']['name'] ?? 'Mexico'),
            'habitaciones'  => $bedrooms,
            'banios'        => $bathrooms,
            'metros'        => $area,
            'tipo'          => $propertyType ?? 'Inmueble',
            'condicion'     => $item['condition'] ?? null,
        ];
    }
}
