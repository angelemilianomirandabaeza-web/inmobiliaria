<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Contrato;
use App\Models\Propiedad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContratoController extends Controller
{
    public function index(Request $request)
    {
        $query = Contrato::with(['propiedad', 'cliente', 'agente.usuario'])
            ->latest();

        if ($request->filled('tipo')) {
            $query->where('tipo_contrato', $request->tipo);
        }
        if ($request->filled('agente_id')) {
            $query->where('agente_id', $request->agente_id);
        }
        if ($request->filled('busqueda')) {
            $b = $request->busqueda;
            $query->whereHas('propiedad', fn($q) => $q->where('titulo', 'like', "%$b%"))
                  ->orWhereHas('cliente', fn($q) => $q->where('name', 'like', "%$b%"));
        }

        $contratos = $query->paginate(15)->withQueryString();
        $agentes   = Agente::with('usuario')->get();
        $stats = [
            'total'         => Contrato::count(),
            'compraventa'   => Contrato::where('tipo_contrato', 'compraventa')->count(),
            'arrendamiento' => Contrato::where('tipo_contrato', 'arrendamiento')->count(),
            'monto_total'   => Contrato::sum('precio_acordado'),
        ];

        return view('admin.contratos.index', compact('contratos', 'agentes', 'stats'));
    }

    public function create()
    {
        $propiedades = Propiedad::aprobadas()->with('colonia')->get();
        $clientes    = User::whereHas('rol', fn($q) => $q->where('nombre', 'cliente'))->get();
        $agentes     = Agente::with('usuario')->get();

        return view('admin.contratos.create', compact('propiedades', 'clientes', 'agentes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'propiedad_id'   => 'required|exists:propiedades,id',
            'cliente_id'     => 'required|exists:users,id',
            'agente_id'      => 'required|exists:agentes,id',
            'tipo_contrato'  => 'required|in:compraventa,arrendamiento',
            'precio_acordado'=> 'required|numeric|min:0',
            'fecha_firma'    => 'required|date',
            'fecha_entrega'  => 'nullable|date|after_or_equal:fecha_firma',
            'comision_agente'=> 'nullable|numeric|min:0',
            'archivo_pdf'    => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('archivo_pdf')) {
            $data['archivo_pdf'] = $request->file('archivo_pdf')->store('contratos', 'public');
        }

        Contrato::create($data);

        return redirect()->route('admin.contratos.index')
            ->with('success', 'Contrato registrado correctamente.');
    }

    public function show(Contrato $contrato)
    {
        $contrato->load(['propiedad.imagenPrincipal', 'propiedad.colonia.municipio', 'cliente', 'agente.usuario']);
        return view('admin.contratos.show', compact('contrato'));
    }

    public function destroy(Contrato $contrato)
    {
        if ($contrato->archivo_pdf) {
            Storage::disk('public')->delete($contrato->archivo_pdf);
        }
        $contrato->delete();
        return back()->with('success', 'Contrato eliminado.');
    }
}
