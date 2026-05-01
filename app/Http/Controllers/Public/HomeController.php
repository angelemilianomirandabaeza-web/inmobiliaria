<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use App\Models\TipoOperacion;
use App\Models\TipoPropiedad;

class HomeController extends Controller
{
    public function index()
    {
        $destacadas = Propiedad::aprobadas()
            ->destacadas()
            ->with(['imagenPrincipal', 'colonia.municipio', 'tipoPropiedad', 'tipoOperacion'])
            ->limit(6)
            ->get();

        $recientes = Propiedad::aprobadas()
            ->with(['imagenPrincipal', 'colonia.municipio', 'tipoPropiedad', 'tipoOperacion'])
            ->latest()
            ->limit(8)
            ->get();

        $tiposPropiedad = TipoPropiedad::all();
        $tiposOperacion = TipoOperacion::all();

        $totalPropiedades = Propiedad::aprobadas()->count();

        return view('public.home', compact(
            'destacadas', 'recientes', 'tiposPropiedad',
            'tiposOperacion', 'totalPropiedades'
        ));
    }
}
