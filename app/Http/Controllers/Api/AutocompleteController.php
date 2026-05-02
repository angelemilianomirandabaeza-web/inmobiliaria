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

        // Colonias
        $colonias = Colonia::where('nombre', 'like', "%{$q}%")
            ->with('municipio')
            ->limit(4)
            ->get();

        foreach ($colonias as $c) {
            $count = Propiedad::aprobadas()->where('colonia_id', $c->id)->count();
            $results[] = [
                'type'      => 'colonia',
                'icon'      => 'fa-map-marker-alt',
                'title'     => $c->nombre,
                'subtitle'  => $c->municipio->nombre,
                'price'     => $count . ' props',
                'image'     => null,
                'url'       => route('propiedades.buscar', ['colonia_id' => $c->id]),
            ];
        }

        // Municipios
        $municipios = \App\Models\Municipio::where('nombre', 'like', "%{$q}%")
            ->limit(3)
            ->get();

        foreach ($municipios as $m) {
            $count = Propiedad::aprobadas()->whereHas('colonia', fn($q) => $q->where('municipio_id', $m->id))->count();
            $results[] = [
                'type'      => 'municipio',
                'icon'      => 'fa-city',
                'title'     => $m->nombre,
                'subtitle'  => 'Municipio',
                'price'     => $count . ' props',
                'image'     => null,
                'url'       => route('propiedades.buscar', ['busqueda' => $m->nombre]),
            ];
        }

        return response()->json(['results' => $results, 'query' => $q]);
    }
}
