<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;

class QuickViewController extends Controller
{
    public function show(Propiedad $propiedad)
    {
        if (!$propiedad->aprobada) {
            abort(404);
        }

        $propiedad->load(['imagenes', 'amenidades', 'colonia.municipio', 'tipoPropiedad', 'tipoOperacion', 'estadoPropiedad', 'agente.usuario']);

        return view('public.partials.quick_view', compact('propiedad'))->render();
    }

    public function mapData()
    {
        // Devuelve todas las propiedades aprobadas con coordenadas para el mapa
        return Propiedad::aprobadas()
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->with(['imagenPrincipal:id,propiedad_id,url_imagen', 'colonia:id,nombre,municipio_id', 'colonia.municipio:id,nombre', 'tipoPropiedad:id,nombre', 'tipoOperacion:id,nombre'])
            ->get()
            ->map(fn($p) => [
                'id'        => $p->id,
                'titulo'    => $p->titulo,
                'precio'    => $p->precio,
                'lat'       => (float)$p->latitud,
                'lng'       => (float)$p->longitud,
                'imagen'    => $p->imagenPrincipal->url_imagen ?? null,
                'colonia'   => $p->colonia->nombre,
                'municipio' => $p->colonia->municipio->nombre,
                'tipo'      => $p->tipoPropiedad->nombre,
                'operacion' => $p->tipoOperacion->nombre,
                'destacada' => $p->destacada,
                'url'       => route('propiedades.show', $p),
            ]);
    }
}
