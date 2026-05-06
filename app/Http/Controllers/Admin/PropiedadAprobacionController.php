<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use Illuminate\Http\Request; // Añadimos esto para que funcione el buscador

class PropiedadAprobacionController extends Controller
{
    public function index(Request $request)
    {
        // Capturamos lo que el usuario escribe en el buscador
        $search = $request->input('search');

        // Consultamos las propiedades con sus relaciones para que la tabla cargue rápido
        $propiedades = Propiedad::query()
            ->with(['agente.usuario', 'tipoPropiedad', 'colonia', 'imagenPrincipal'])
            // Lógica del buscador: busca por título, nombre del agente o colonia
            ->when($search, function($query, $search) {
                $query->where('titulo', 'LIKE', "%{$search}%")
                      ->orWhereHas('agente.usuario', function($q) use ($search) {
                          $q->where('name', 'LIKE', "%{$search}%");
                      })
                      ->orWhereHas('colonia', function($q) use ($search) {
                          $q->where('nombre', 'LIKE', "%{$search}%");
                      });
            })
            ->latest()
            ->paginate(10); // Paginación para que la tabla no sea infinita

        // IMPORTANTE: Mandamos 'propiedades' para que coincida con tu nueva tabla
        return view('admin.propiedades.index', compact('propiedades'));
    }

    public function aprobar(Propiedad $propiedad)
    {
        $propiedad->update(['aprobada' => true]);
        return back()->with('success', 'Propiedad aprobada correctamente.');
    }

    // Este método ahora sirve tanto para "Rechazar" como para el botón "Eliminar" de la tabla
    public function rechazar(Propiedad $propiedad)
    {
        $propiedad->delete();
        return back()->with('success', 'Propiedad eliminada del sistema.');
    }

    // Método para mostrar el formulario de edición (lo necesitaremos para el botón de Modificar)
    public function edit(Propiedad $propiedad)
    {
        // Aquí podrías retornar una vista para editar, por ahora lo dejamos listo
        return view('admin.propiedades.edit', compact('propiedad'));
    }
    public function update(Request $request, Propiedad $propiedad)
    {
    $request->validate([
        'titulo' => 'required|max:255',
        'precio' => 'required|numeric',
        'aprobada' => 'required|boolean',
    ]);

    $propiedad->update($request->all());

    return redirect()->route('admin.propiedades.index')->with('success', 'Propiedad actualizada con éxito.');
    }
}