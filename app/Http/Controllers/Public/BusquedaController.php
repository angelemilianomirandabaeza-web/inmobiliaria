<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Colonia;
use App\Models\Propiedad;
use App\Models\TipoOperacion;
use App\Models\TipoPropiedad;
use Illuminate\Http\Request;

class BusquedaController extends Controller
{
    public function index(Request $request)
    {
        $query = Propiedad::aprobadas()
            ->with(['imagenPrincipal', 'colonia.municipio', 'tipoPropiedad', 'tipoOperacion', 'estadoPropiedad']);

        // Filtros
        if ($request->filled('tipo_operacion_id')) {
            $query->where('tipo_operacion_id', $request->tipo_operacion_id);
        }
        if ($request->filled('tipo_propiedad_id')) {
            $query->where('tipo_propiedad_id', $request->tipo_propiedad_id);
        }
        if ($request->filled('colonia_id')) {
            $query->where('colonia_id', $request->colonia_id);
        }
        if ($request->filled('precio_min')) {
            $query->where('precio', '>=', $request->precio_min);
        }
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->precio_max);
        }
        if ($request->filled('habitaciones')) {
            $query->where('habitaciones', '>=', $request->habitaciones);
        }
        if ($request->filled('banios')) {
            $query->where('banios', '>=', $request->banios);
        }
        if ($request->filled('metros_min')) {
            $query->where('metros_construccion', '>=', $request->metros_min);
        }
        if ($request->filled('busqueda')) {
            $busqueda = $request->busqueda;
            $query->where(function ($q) use ($busqueda) {
                $q->where('titulo', 'like', "%{$busqueda}%")
                  ->orWhere('descripcion', 'like', "%{$busqueda}%");
            });
        }

        // Ordenamiento
        $orden = $request->get('orden', 'recientes');
        match ($orden) {
            'precio_asc'  => $query->orderBy('precio', 'asc'),
            'precio_desc' => $query->orderBy('precio', 'desc'),
            'destacadas'  => $query->orderByDesc('destacada')->orderByDesc('created_at'),
            default       => $query->latest(),
        };

        $propiedades = $query->paginate(12)->withQueryString();

        $tiposPropiedad = TipoPropiedad::all();
        $tiposOperacion = TipoOperacion::all();
        $colonias = Colonia::with('municipio')->orderBy('nombre')->get();

        return view('public.busqueda', compact(
            'propiedades', 'tiposPropiedad', 'tiposOperacion', 'colonias'
        ));
    }
}
