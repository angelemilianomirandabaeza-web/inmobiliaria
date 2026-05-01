<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;

class PropiedadPublicaController extends Controller
{
    public function show(Propiedad $propiedad)
    {
        if (!$propiedad->aprobada) {
            abort(404);
        }

        $propiedad->increment('visitas_contador');
        $propiedad->load([
            'imagenes', 'amenidades', 'colonia.municipio.estado',
            'tipoPropiedad', 'tipoOperacion', 'estadoPropiedad',
            'agente.usuario', 'historialPrecios'
        ]);

        // Propiedades similares
        $similares = Propiedad::aprobadas()
            ->where('id', '!=', $propiedad->id)
            ->where('tipo_propiedad_id', $propiedad->tipo_propiedad_id)
            ->where('tipo_operacion_id', $propiedad->tipo_operacion_id)
            ->whereBetween('precio', [
                $propiedad->precio * 0.7,
                $propiedad->precio * 1.3
            ])
            ->with(['imagenPrincipal', 'colonia'])
            ->limit(4)
            ->get();

        return view('public.propiedad_show', compact('propiedad', 'similares'));
    }
}
