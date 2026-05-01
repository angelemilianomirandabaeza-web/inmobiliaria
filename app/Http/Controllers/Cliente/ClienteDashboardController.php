<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Alerta;
use App\Models\Favorito;
use App\Models\Visita;

class ClienteDashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $stats = [
            'favoritos'        => Favorito::where('cliente_id', $userId)->count(),
            'visitas_proximas' => Visita::where('cliente_id', $userId)->whereDate('fecha_visita', '>=', now())->count(),
            'alertas_activas'  => Alerta::where('cliente_id', $userId)->where('activa', true)->count(),
        ];

        $favoritosRecientes = Favorito::where('cliente_id', $userId)
            ->with(['propiedad.imagenPrincipal', 'propiedad.colonia'])
            ->latest()
            ->limit(4)
            ->get();

        $proximasVisitas = Visita::where('cliente_id', $userId)
            ->whereDate('fecha_visita', '>=', now())
            ->with(['propiedad', 'agente.usuario', 'estadoVisita'])
            ->orderBy('fecha_visita')
            ->limit(3)
            ->get();

        return view('cliente.dashboard', compact('stats', 'favoritosRecientes', 'proximasVisitas'));
    }
}
