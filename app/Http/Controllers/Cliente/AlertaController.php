<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Alerta;
use App\Models\Colonia;
use App\Models\Propiedad;
use App\Models\TipoOperacion;
use App\Models\TipoPropiedad;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        $alertas = Alerta::where('cliente_id', auth()->id())
            ->with(['tipoPropiedad', 'tipoOperacion', 'colonia.municipio'])
            ->latest()
            ->get();

        // Match: propiedades que cumplen cada alerta
        foreach ($alertas as $alerta) {
            $alerta->matches = $this->matchProperties($alerta);
        }

        $tiposPropiedad = TipoPropiedad::all();
        $tiposOperacion = TipoOperacion::all();
        $colonias = Colonia::with('municipio')->orderBy('nombre')->get();

        return view('cliente.alertas', compact('alertas', 'tiposPropiedad', 'tiposOperacion', 'colonias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tipo_propiedad_id' => 'nullable|exists:tipos_propiedad,id',
            'tipo_operacion_id' => 'nullable|exists:tipos_operacion,id',
            'colonia_id'        => 'nullable|exists:colonias,id',
            'precio_min'        => 'nullable|numeric',
            'precio_max'        => 'nullable|numeric',
            'habitaciones_min'  => 'nullable|integer',
            'metros_min'        => 'nullable|numeric',
        ]);

        $data['cliente_id'] = auth()->id();
        $data['activa'] = true;

        Alerta::create($data);

        return back()->with('success', 'Alerta creada. Te avisaremos cuando haya nuevas propiedades que coincidan.');
    }

    public function destroy(Alerta $alerta)
    {
        if ($alerta->cliente_id !== auth()->id()) {
            abort(403);
        }
        $alerta->delete();
        return back()->with('success', 'Alerta eliminada.');
    }

    private function matchProperties(Alerta $alerta)
    {
        $q = Propiedad::aprobadas();

        if ($alerta->tipo_propiedad_id) $q->where('tipo_propiedad_id', $alerta->tipo_propiedad_id);
        if ($alerta->tipo_operacion_id) $q->where('tipo_operacion_id', $alerta->tipo_operacion_id);
        if ($alerta->colonia_id)        $q->where('colonia_id', $alerta->colonia_id);
        if ($alerta->precio_min)        $q->where('precio', '>=', $alerta->precio_min);
        if ($alerta->precio_max)        $q->where('precio', '<=', $alerta->precio_max);
        if ($alerta->habitaciones_min)  $q->where('habitaciones', '>=', $alerta->habitaciones_min);
        if ($alerta->metros_min)        $q->where('metros_construccion', '>=', $alerta->metros_min);

        return $q->count();
    }
}
