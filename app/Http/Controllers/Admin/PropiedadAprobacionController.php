<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;

class PropiedadAprobacionController extends Controller
{
    public function index()
    {
        $pendientes = Propiedad::where('aprobada', false)
            ->with(['agente.usuario', 'tipoPropiedad', 'colonia', 'imagenPrincipal'])
            ->latest()
            ->paginate(10);

        return view('admin.propiedades.index', compact('pendientes'));
    }

    public function aprobar(Propiedad $propiedad)
    {
        $propiedad->update(['aprobada' => true]);
        return back()->with('success', 'Propiedad aprobada correctamente.');
    }

    public function rechazar(Propiedad $propiedad)
    {
        $propiedad->delete();
        return back()->with('success', 'Propiedad rechazada y eliminada.');
    }
}
