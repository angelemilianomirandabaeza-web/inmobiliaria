<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agente;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('rol')->latest();

        if ($request->filled('rol_id')) {
            $query->where('rol_id', $request->rol_id);
        }
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo === '1');
        }
        if ($request->filled('busqueda')) {
            $b = $request->busqueda;
            $query->where(fn($q) => $q->where('name', 'like', "%$b%")->orWhere('email', 'like', "%$b%"));
        }

        $usuarios = $query->paginate(20)->withQueryString();
        $roles    = Role::all();
        $stats = [
            'total'   => User::count(),
            'activos' => User::where('activo', true)->count(),
            'inactivos' => User::where('activo', false)->count(),
        ];

        return view('admin.usuarios.index', compact('usuarios', 'roles', 'stats'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'rol_id'   => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'activo'   => ['nullable', 'boolean'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'telefono' => $data['telefono'] ?? null,
            'rol_id'   => $data['rol_id'],
            'password' => Hash::make($data['password']),
            'activo'   => $request->has('activo'),
        ]);

        // Si es agente, crear perfil de agente
        if (Role::find($data['rol_id'])->nombre === 'agente') {
            Agente::create([
                'usuario_id'        => $user->id,
                'licencia_numero'   => $request->input('licencia_numero', 'LIC-' . str_pad($user->id, 6, '0', STR_PAD_LEFT)),
                'especialidad'      => $request->input('especialidad', ''),
                'anios_experiencia' => $request->input('anios_experiencia', 0),
                'biografia'         => $request->input('biografia', ''),
            ]);
        }

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario \"{$user->name}\" creado correctamente.");
    }

    public function edit(User $usuario)
    {
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, User $usuario)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', "unique:users,email,{$usuario->id}"],
            'telefono' => ['nullable', 'string', 'max:20'],
            'rol_id'   => ['required', 'exists:roles,id'],
        ]);

        $data['activo'] = $request->has('activo');

        if ($request->filled('password')) {
            $request->validate(['password' => ['confirmed', Rules\Password::defaults()]]);
            $data['password'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario \"{$usuario->name}\" actualizado.");
    }

    public function toggleActivo(User $usuario)
    {
        // No permitir desactivar al mismo admin que esta logueado
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->update(['activo' => !$usuario->activo]);
        $estado = $usuario->activo ? 'activado' : 'desactivado';

        return back()->with('success', "Usuario \"{$usuario->name}\" {$estado}.");
    }

    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $nombre = $usuario->name;
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Usuario \"{$nombre}\" eliminado.");
    }
}
