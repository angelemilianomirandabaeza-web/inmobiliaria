@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold text-white">Editar Usuario: {{ $user->name }}</h5>
                </div>
                <div class="card-body p-4">
                    {{-- El formulario envía los datos a la ruta 'update' --}}
                    <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT') {{-- Esto es obligatorio para actualizar en Laravel --}}

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nombre Completo</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Rol del Usuario</label>
                                <select name="rol_id" class="form-select border">
                                    <option value="1" {{ $user->rol_id == 1 ? 'selected' : '' }}>Administrador</option>
                                    <option value="2" {{ $user->rol_id == 2 ? 'selected' : '' }}>Agente</option>
                                    <option value="3" {{ $user->rol_id == 3 ? 'selected' : '' }}>Cliente</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold text-muted small">Contraseña (Vacío para no cambiar)</label>
                                <input type="password" name="password" class="form-control" placeholder="********">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-light border me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4 shadow">Actualizar Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection