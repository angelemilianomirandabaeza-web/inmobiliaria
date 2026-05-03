<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\ReseniaAgente;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    public function store(Request $request, Agente $agente)
    {
        $data = $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario'   => 'nullable|string|max:500',
        ]);

        ReseniaAgente::updateOrCreate(
            ['agente_id' => $agente->id, 'cliente_id' => auth()->id()],
            ['calificacion' => $data['calificacion'], 'comentario' => $data['comentario'] ?? null]
        );

        // Recalcular promedio del agente
        $promedio = ReseniaAgente::where('agente_id', $agente->id)->avg('calificacion');
        $agente->update(['calificacion_promedio' => round($promedio, 2)]);

        return back()->with('success', '¡Gracias por tu reseña!');
    }
}
