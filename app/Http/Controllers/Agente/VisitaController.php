<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function updateEstado(Request $request, Visita $visita)
    {
        // 1. Validar que la visita sí le pertenezca a este agente
        if ($visita->agente_id != auth()->user()->agente->id) {
            abort(403, 'No tienes permiso para modificar esta visita.');
        }

        // 2. Buscar el ID real del estado en la base de datos
        $estadoNombre = $request->input('estado'); // Recibimos 'Confirmada' o 'Cancelada'
        $estadoId = \App\Models\EstadoVisita::where('nombre', $estadoNombre)->value('id');

        // 3. Actualizar la visita
        $visita->update(['estado_visita_id' => $estadoId]);

        return back()->with('success', 'La visita ha sido marcada como ' . $estadoNombre . '.');
    }
}