<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Role;
use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminAgenteController extends Controller
{
    public function index()
    {
        $agentes = Agente::with(['usuario', 'suscripcionActiva'])
            ->withCount('propiedades')
            ->latest()
            ->paginate(15);

        return view('admin.agentes.index', compact('agentes'));
    }

    public function create()
    {
        return view('admin.agentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email',
            'password'           => ['required', Password::min(8)],
            'telefono'           => 'nullable|string|max:20',
            'especialidad'       => 'nullable|string|max:255',
            'anios_experiencia'  => 'nullable|integer|min:0|max:60',
            'biografia'          => 'nullable|string|max:1000',
            'licencia_numero'    => 'nullable|string|max:50',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'rol_id'    => Role::where('nombre', 'agente')->value('id'),
            'telefono'  => $request->telefono,
            'activo'    => true,
        ]);

        Agente::create([
            'usuario_id'         => $user->id,
            'especialidad'       => $request->especialidad,
            'anios_experiencia'  => $request->anios_experiencia ?? 0,
            'biografia'          => $request->biografia,
            'licencia_numero'    => $request->licencia_numero ?? 'LIC-' . strtoupper(substr(md5($user->email), 0, 6)),
        ]);

        return redirect()->route('admin.agentes.index')
            ->with('success', "Agente {$user->name} creado exitosamente.");
    }

    public function edit(Agente $agente)
    {
        $agente->load('usuario');
        return view('admin.agentes.edit', compact('agente'));
    }

    public function update(Request $request, Agente $agente)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'email'              => 'required|email|unique:users,email,' . $agente->usuario_id,
            'password'           => ['nullable', Password::min(8)],
            'telefono'           => 'nullable|string|max:20',
            'especialidad'       => 'nullable|string|max:255',
            'anios_experiencia'  => 'nullable|integer|min:0|max:60',
            'biografia'          => 'nullable|string|max:1000',
            'licencia_numero'    => 'nullable|string|max:50',
        ]);

        $agente->usuario->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'telefono' => $request->telefono,
            ...($request->filled('password') ? ['password' => Hash::make($request->password)] : []),
        ]);

        $agente->update([
            'especialidad'       => $request->especialidad,
            'anios_experiencia'  => $request->anios_experiencia ?? 0,
            'biografia'          => $request->biografia,
            'licencia_numero'    => $request->licencia_numero,
        ]);

        return redirect()->route('admin.agentes.index')
            ->with('success', "Agente {$agente->usuario->name} actualizado correctamente.");
    }

    public function toggleActivo(Agente $agente)
    {
        $agente->usuario->update(['activo' => !$agente->usuario->activo]);
        $estado = $agente->usuario->activo ? 'activado' : 'desactivado';

        return back()->with('success', "Agente {$agente->usuario->name} {$estado}.");
    }

    public function destroy(Agente $agente)
    {
        $nombre = $agente->usuario->name;
        $agente->usuario->delete();

        return redirect()->route('admin.agentes.index')
            ->with('success', "Agente {$nombre} eliminado del sistema.");
    }
}
