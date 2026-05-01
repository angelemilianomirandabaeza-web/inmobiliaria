<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class ComparadorController extends Controller
{
    public function index(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        $ids = array_slice(array_filter($ids), 0, 3);

        $propiedades = collect();
        if (!empty($ids)) {
            $propiedades = Propiedad::aprobadas()
                ->whereIn('id', $ids)
                ->with(['imagenPrincipal', 'amenidades', 'colonia.municipio', 'tipoPropiedad', 'tipoOperacion'])
                ->get();
        }

        return view('public.comparar', compact('propiedades'));
    }
}
