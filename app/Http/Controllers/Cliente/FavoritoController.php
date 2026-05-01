<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Favorito;
use App\Models\Propiedad;

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

    public function store(Propiedad $propiedad)
    {
        Favorito::firstOrCreate([
            'cliente_id'   => auth()->id(),
            'propiedad_id' => $propiedad->id,
        ]);

        return back()->with('success', 'Propiedad agregada a favoritos.');
    }

    public function destroy(Propiedad $propiedad)
    {
        Favorito::where('cliente_id', auth()->id())
            ->where('propiedad_id', $propiedad->id)
            ->delete();

        return back()->with('success', 'Propiedad eliminada de favoritos.');
    }
}
