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
        $stats = $this->buildStats();

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

    public function reporte()
    {
        $stats = $this->buildStats();

        $propiedadesPorTipo = Propiedad::selectRaw('tipo_propiedad_id, COUNT(*) as total, AVG(precio) as precio_promedio')
            ->groupBy('tipo_propiedad_id')->with('tipoPropiedad:id,nombre')->get();

        $propiedadesPorOperacion = Propiedad::selectRaw('tipo_operacion_id, COUNT(*) as total')
            ->groupBy('tipo_operacion_id')->with('tipoOperacion:id,nombre')->get();

        $topAgentes = Agente::with('usuario')
            ->withCount('propiedades')
            ->orderByDesc('propiedades_count')
            ->limit(10)
            ->get();

        $topColonias = \App\Models\Colonia::withCount('propiedades')
            ->orderByDesc('propiedades_count')
            ->limit(10)
            ->get();

        return view('admin.reporte', compact('stats', 'propiedadesPorTipo', 'propiedadesPorOperacion', 'topAgentes', 'topColonias'));
    }

    private function buildStats(): array
    {
        return [
            'total_propiedades'      => Propiedad::count(),
            'propiedades_aprobadas'  => Propiedad::where('aprobada', true)->count(),
            'propiedades_pendientes' => Propiedad::where('aprobada', false)->count(),
            'total_usuarios'         => User::count(),
            'total_agentes'          => Agente::count(),
            'visitas_mes'            => Visita::whereMonth('created_at', now()->month)->count(),
            'precio_promedio'        => Propiedad::where('aprobada', true)->avg('precio') ?? 0,
            'precio_max'             => Propiedad::where('aprobada', true)->max('precio') ?? 0,
        ];
    }
}
