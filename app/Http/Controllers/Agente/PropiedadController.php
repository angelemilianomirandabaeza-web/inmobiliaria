<?php

namespace App\Http\Controllers\Agente;

use App\Http\Controllers\Controller;
use App\Models\Amenidad;
use App\Models\Colonia;
use App\Models\EstadoPropiedad;
use App\Models\ImagenPropiedad;
use App\Models\Propiedad;
use App\Models\TipoOperacion;
use App\Models\TipoPropiedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropiedadController extends Controller
{
    public function index()
    {
        $agente = auth()->user()->agente;
        $propiedades = Propiedad::where('agente_id', $agente->id)
            ->with(['imagenPrincipal', 'tipoPropiedad', 'estadoPropiedad', 'colonia'])
            ->latest()
            ->paginate(10);

        return view('agente.propiedades.index', compact('propiedades'));
    }

    public function create()
    {
        $tiposPropiedad = TipoPropiedad::all();
        $tiposOperacion = TipoOperacion::all();
        $estadosPropiedad = EstadoPropiedad::all();
        $colonias = Colonia::with('municipio')->orderBy('nombre')->get();
        $amenidades = Amenidad::all();

        return view('agente.propiedades.create', compact(
            'tiposPropiedad', 'tiposOperacion', 'estadosPropiedad', 'colonias', 'amenidades'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'               => 'required|string|max:255',
            'descripcion'          => 'required|string',
            'precio'               => 'required|numeric|min:0',
            'tipo_operacion_id'    => 'required|exists:tipos_operacion,id',
            'tipo_propiedad_id'    => 'required|exists:tipos_propiedad,id',
            'estado_propiedad_id'  => 'required|exists:estados_propiedad,id',
            'colonia_id'           => 'required|exists:colonias,id',
            'direccion'            => 'required|string',
            'metros_construccion'  => 'nullable|numeric',
            'metros_terreno'       => 'nullable|numeric',
            'habitaciones'         => 'nullable|integer|min:0',
            'banios'               => 'nullable|integer|min:0',
            'medios_banios'        => 'nullable|integer|min:0',
            'estacionamientos'     => 'nullable|integer|min:0',
            'antiguedad_anios'     => 'nullable|integer|min:0',
            'amueblado'            => 'nullable|boolean',
            'amenidades'           => 'nullable|array',
            'amenidades.*'         => 'exists:amenidades,id',
            'imagenes'             => 'nullable|array|max:10',
            'imagenes.*'           => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        unset($data['imagenes']);
        $data['agente_id'] = auth()->user()->agente->id;
        $data['amueblado'] = $request->has('amueblado');
        $data['aprobada']  = false;

        $propiedad = Propiedad::create($data);

        if ($request->has('amenidades')) {
            $propiedad->amenidades()->sync($request->amenidades);
        }

        // Subida de imagenes
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $i => $file) {
                $path = $file->store('propiedades/' . $propiedad->id, 'public');
                ImagenPropiedad::create([
                    'propiedad_id' => $propiedad->id,
                    'url_imagen'   => Storage::url($path),
                    'es_principal' => $i === 0,
                    'orden'        => $i,
                ]);
            }
        }

        return redirect()->route('agente.propiedades.index')
            ->with('success', 'Propiedad creada con ' . ($request->hasFile('imagenes') ? count($request->file('imagenes')) . ' imagenes' : 'sin imagenes') . '. Sera visible al ser aprobada por el admin.');
    }

    public function show(Propiedad $propiedad)
    {
        $this->authorize_owner($propiedad);
        $propiedad->load(['imagenes', 'amenidades', 'colonia.municipio', 'visitas.cliente']);
        return view('agente.propiedades.show', compact('propiedad'));
    }

    public function edit(Propiedad $propiedad)
    {
        $this->authorize_owner($propiedad);

        $tiposPropiedad = TipoPropiedad::all();
        $tiposOperacion = TipoOperacion::all();
        $estadosPropiedad = EstadoPropiedad::all();
        $colonias = Colonia::with('municipio')->orderBy('nombre')->get();
        $amenidades = Amenidad::all();
        $amenidadesSeleccionadas = $propiedad->amenidades->pluck('id')->toArray();

        return view('agente.propiedades.edit', compact(
            'propiedad', 'tiposPropiedad', 'tiposOperacion', 'estadosPropiedad',
            'colonias', 'amenidades', 'amenidadesSeleccionadas'
        ));
    }

    public function update(Request $request, Propiedad $propiedad)
    {
        $this->authorize_owner($propiedad);

        $data = $request->validate([
            'titulo'               => 'required|string|max:255',
            'descripcion'          => 'required|string',
            'precio'               => 'required|numeric|min:0',
            'tipo_operacion_id'    => 'required|exists:tipos_operacion,id',
            'tipo_propiedad_id'    => 'required|exists:tipos_propiedad,id',
            'estado_propiedad_id'  => 'required|exists:estados_propiedad,id',
            'colonia_id'           => 'required|exists:colonias,id',
            'direccion'            => 'required|string',
            'metros_construccion'  => 'nullable|numeric',
            'metros_terreno'       => 'nullable|numeric',
            'habitaciones'         => 'nullable|integer|min:0',
            'banios'               => 'nullable|integer|min:0',
            'medios_banios'        => 'nullable|integer|min:0',
            'estacionamientos'     => 'nullable|integer|min:0',
        ]);

        $data['amueblado'] = $request->has('amueblado');

        // Si cambio el precio, guardar historial
        if ($propiedad->precio != $data['precio']) {
            $propiedad->historialPrecios()->create([
                'precio_anterior' => $propiedad->precio,
                'precio_nuevo'    => $data['precio'],
                'fecha_cambio'    => now(),
                'motivo'          => 'Actualizacion del agente',
            ]);
            $data['precio_anterior'] = $propiedad->precio;
        }

        $propiedad->update($data);

        if ($request->has('amenidades')) {
            $propiedad->amenidades()->sync($request->amenidades);
        }

        return redirect()->route('agente.propiedades.index')->with('success', 'Propiedad actualizada.');
    }

    public function destroy(Propiedad $propiedad)
    {
        $this->authorize_owner($propiedad);
        $propiedad->delete();
        return back()->with('success', 'Propiedad eliminada.');
    }

    private function authorize_owner(Propiedad $propiedad): void
    {
        if ($propiedad->agente_id !== auth()->user()->agente->id) {
            abort(403);
        }
    }
}
