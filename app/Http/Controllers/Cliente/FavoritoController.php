<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Propiedad;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function index()
    {
        $favoritos = Favorito::where('cliente_id', auth()->id())
            ->with(['propiedad.imagenPrincipal', 'propiedad.colonia.municipio', 'propiedad.tipoPropiedad'])
            ->latest()
            ->paginate(12);

        return view('cliente.favoritos', compact('favoritos'));
    }

    public function store(Request $request, Propiedad $propiedad)
    {
        Favorito::firstOrCreate([
            'cliente_id'   => auth()->id(),
            'propiedad_id' => $propiedad->id,
        ]);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'message' => 'Agregada a favoritos']);
        }
        return back()->with('success', 'Propiedad agregada a favoritos.');
    }

    public function destroy(Request $request, Propiedad $propiedad)
    {
        Favorito::where('cliente_id', auth()->id())
            ->where('propiedad_id', $propiedad->id)
            ->delete();

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'message' => 'Eliminada de favoritos']);
        }
        return back()->with('success', 'Propiedad eliminada de favoritos.');
    }
}
