<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Colonia;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class AutocompleteController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $results = [];

        // Propiedades por titulo
        $propiedades = Propiedad::aprobadas()
            ->where('titulo', 'like', "%{$q}%")
            ->with(['imagenPrincipal', 'colonia.municipio'])
            ->limit(5)
            ->get();

        foreach ($propiedades as $p) {
            $results[] = [
                'type'      => 'propiedad',
                'icon'      => 'fa-home',
                'title'     => $p->titulo,
                'subtitle'  => $p->colonia->nombre . ', ' . $p->colonia->municipio->nombre,
                'price'     => '$' . number_format($p->precio, 0),
                'image'     => $p->imagenPrincipal->url_imagen ?? null,
                'url'       => route('propiedades.show', $p),
            ];
        }

        // Colonias — withCount evita N+1 queries
        $colonias = Colonia::where('nombre', 'like', "%{$q}%")
            ->with('municipio')
            ->withCount(['propiedades' => fn($q) => $q->where('aprobada', true)])
            ->limit(4)
            ->get();

        foreach ($colonias as $c) {
            $results[] = [
                'type'      => 'colonia',
                'icon'      => 'fa-map-marker-alt',
                'title'     => $c->nombre,
                'subtitle'  => $c->municipio->nombre,
                'price'     => $c->propiedades_count . ' props',
                'image'     => null,
                'url'       => route('propiedades.buscar', ['colonia_id' => $c->id]),
            ];
        }

        // Municipios — withCount evita N+1 queries
        $municipios = \App\Models\Municipio::where('nombre', 'like', "%{$q}%")
            ->withCount(['propiedades as propiedades_count' => fn($q) => $q->where('aprobada', true)])
            ->limit(3)
            ->get();

        foreach ($municipios as $m) {
            $results[] = [
                'type'      => 'municipio',
                'icon'      => 'fa-city',
                'title'     => $m->nombre,
                'subtitle'  => 'Municipio',
                'price'     => $m->propiedades_count . ' props',
                'image'     => null,
                'url'       => route('propiedades.buscar', ['busqueda' => $m->nombre]),
            ];
        }

        return response()->json(['results' => $results, 'query' => $q]);
    }
}
