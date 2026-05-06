<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function index()
    {
        $visitas = Visita::where('cliente_id', auth()->id())
            ->with(['propiedad.imagenPrincipal', 'propiedad.colonia', 'agente.usuario', 'estadoVisita'])
            ->orderByDesc('fecha_visita')
            ->paginate(10);

        return view('cliente.visitas', compact('visitas'));
    }

    public function store(Request $request, Propiedad $propiedad)
    {
        $data = $request->validate([
            'fecha_visita' => 'required|date|after_or_equal:today',
            'hora_inicio'  => 'required',
            'notas_cliente'=> 'nullable|string|max:500',
        ]);

        Visita::create([
            'propiedad_id'      => $propiedad->id,
            'cliente_id'        => auth()->id(),
            'agente_id'         => $propiedad->agente_id,
            'fecha_visita'      => $data['fecha_visita'],
            'hora_inicio'       => $data['hora_inicio'],
            'estado_visita_id'  => \App\Models\EstadoVisita::where('nombre', 'Pendiente')->value('id'),
            'notas_cliente'     => $data['notas_cliente'] ?? null,
        ]);

        return back()->with('success', 'Visita agendada para el ' . \Carbon\Carbon::parse($data['fecha_visita'])->format('d/m/Y') . '. El agente confirmara pronto.');
    }

    public function destroy(Visita $visita)
    {
        if ($visita->cliente_id !== auth()->id()) {
            abort(403);
        }

        $estadoCancelada = \App\Models\EstadoVisita::where('nombre', 'Cancelada')->value('id');
        $visita->update(['estado_visita_id' => $estadoCancelada]);

        return back()->with('success', 'Visita cancelada correctamente.');
    }
}
