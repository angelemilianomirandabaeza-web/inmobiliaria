<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use App\Models\Visita;

class AgenteDashboardController extends Controller
{
    public function index()
    {
        $agente = auth()->user()->agente;

        if (!$agente) {
            abort(403, 'Tu cuenta de agente no esta configurada.');
        }

        $stats = [
            'mis_propiedades'    => Propiedad::where('agente_id', $agente->id)->count(),
            'propiedades_activas'=> Propiedad::where('agente_id', $agente->id)->where('estado_propiedad_id', 1)->count(),
            'visitas_pendientes' => Visita::where('agente_id', $agente->id)->whereDate('fecha_visita', '>=', now())->count(),
            'total_ventas'       => $agente->total_ventas,
        ];

        $proximasVisitas = Visita::where('agente_id', $agente->id)
            ->whereDate('fecha_visita', '>=', now())
            ->with(['propiedad', 'cliente', 'estadoVisita'])
            ->orderBy('fecha_visita')
            ->limit(5)
            ->get();

        $misPropiedadesRecientes = Propiedad::where('agente_id', $agente->id)
            ->with(['imagenPrincipal', 'estadoPropiedad'])
            ->latest()
            ->limit(5)
            ->get();

        return view('agente.dashboard', compact('stats', 'proximasVisitas', 'misPropiedadesRecientes'));
    }
}
