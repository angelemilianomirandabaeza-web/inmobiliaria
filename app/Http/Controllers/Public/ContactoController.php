<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\NuevaSolicitudContacto;
use App\Models\Propiedad;
use App\Models\SolicitudContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $solicitud = SolicitudContacto::create($data);
        $solicitud->load(['propiedad.colonia.municipio', 'propiedad.agente.usuario']);

        // Enviar email al agente (usa driver "log" en .env por defecto)
        try {
            $emailAgente = $propiedad->agente->usuario->email;
            Mail::to($emailAgente)->send(new NuevaSolicitudContacto($solicitud));
        } catch (\Throwable $e) {
            Log::warning('No se pudo enviar email de contacto: ' . $e->getMessage());
        }

        return back()->with('success', 'Tu mensaje fue enviado al agente. Te contactaran pronto.');
    }
}
