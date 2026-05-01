<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Propiedad;
use App\Models\SolicitudContacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function store(Request $request, Propiedad $propiedad)
    {
        $data = $request->validate([
            'nombre_contacto'    => 'required|string|max:255',
            'email_contacto'     => 'required|email',
            'telefono_contacto'  => 'nullable|string|max:20',
            'mensaje'            => 'required|string',
        ]);

        $data['propiedad_id'] = $propiedad->id;
        $data['cliente_id'] = auth()->id();

        SolicitudContacto::create($data);

        return back()->with('success', 'Tu mensaje ha sido enviado al agente. Te contactaran pronto.');
    }
}
