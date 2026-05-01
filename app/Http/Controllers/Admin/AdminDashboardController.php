<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Propiedad;
use App\Models\User;
use App\Models\Visita;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_propiedades'    => Propiedad::count(),
            'propiedades_aprobadas'=> Propiedad::where('aprobada', true)->count(),
            'propiedades_pendientes'=> Propiedad::where('aprobada', false)->count(),
            'total_usuarios'       => User::count(),
            'total_agentes'        => Agente::count(),
            'visitas_mes'          => Visita::whereMonth('created_at', now()->month)->count(),
        ];

        $propiedadesPorTipo = Propiedad::selectRaw('tipo_propiedad_id, COUNT(*) as total')
            ->groupBy('tipo_propiedad_id')
            ->with('tipoPropiedad:id,nombre')
            ->get();

        $propiedadesRecientes = Propiedad::with(['agente.usuario', 'tipoPropiedad'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'propiedadesPorTipo', 'propiedadesRecientes'));
    }
}
