<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\EtapaVenta;
use App\Models\PipelineVenta;
use App\Models\Propiedad;
use App\Models\User;
use Illuminate\Http\Request;

class PipelineController extends Controller
{
    public function index()
    {
        $agente = auth()->user()->agente;
        $etapas = EtapaVenta::orderBy('orden')->get();

        $pipelineByEtapa = [];
        foreach ($etapas as $etapa) {
            $pipelineByEtapa[$etapa->id] = PipelineVenta::where('agente_id', $agente->id)
                ->where('etapa_id', $etapa->id)
                ->with(['propiedad.imagenPrincipal', 'cliente'])
                ->orderByDesc('updated_at')
                ->get();
        }

        // Para crear nuevos
        $misPropiedades = Propiedad::where('agente_id', $agente->id)->get();
        $clientes = User::whereHas('rol', fn($q) => $q->where('nombre', 'cliente'))->get();

        return view('agente.pipeline.index', compact('etapas', 'pipelineByEtapa', 'misPropiedades', 'clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'propiedad_id' => 'required|exists:propiedades,id',
            'cliente_id'   => 'required|exists:users,id',
            'notas'        => 'nullable|string|max:500',
        ]);

        $data['agente_id'] = auth()->user()->agente->id;
        $data['etapa_id']  = 1; // Prospecto

        PipelineVenta::create($data);

        return back()->with('success', 'Lead agregado al pipeline.');
    }

    public function updateEtapa(Request $request, PipelineVenta $pipeline)
    {
        if ($pipeline->agente_id !== auth()->user()->agente->id) {
            return response()->json(['error' => 'No autorizado'], 403);
        }

        $request->validate(['etapa_id' => 'required|exists:etapas_venta,id']);
        $pipeline->update(['etapa_id' => $request->etapa_id]);

        return response()->json(['ok' => true]);
    }

    public function destroy(PipelineVenta $pipeline)
    {
        if ($pipeline->agente_id !== auth()->user()->agente->id) abort(403);
        $pipeline->delete();
        return back()->with('success', 'Lead eliminado del pipeline.');
    }
}
