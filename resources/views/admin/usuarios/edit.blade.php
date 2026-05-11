@extends('layouts.app')
@section('title', 'Editar Usuario')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 2.5rem 0 2rem; color: white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255,255,255,.5)">
                <li class="breadcrumb-item"><a href="{{ route('admin.usuarios.index') }}" class="text-white-50">Usuarios</a></li>
                <li class="breadcrumb-item active text-white">Editar</li>
            </ol>
        </nav>
        <h1 class="mb-0" style="font-size:1.75rem"><i class="fas fa-user-edit me-2"></i>Editar: {{ $usuario->name }}</h1>
    </div>
</div>

<div class="container py-4" style="max-width:700px">
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
                @csrf @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $usuario->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $usuario->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telefono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $usuario->telefono) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                        <select name="rol_id" class="form-select @error('rol_id') is-invalid @enderror" required>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}" @selected(old('rol_id', $usuario->rol_id)==$r->id)>{{ ucfirst($r->nombre) }}</option>
                            @endforeach
                        </select>
                        @error('rol_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Nueva contrasena (opcional) --}}
                    <div class="col-12"><hr class="my-1"><p class="text-muted small mb-0">Deja en blanco para no cambiar la contrasena</p></div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nueva contrasena</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirmar nueva contrasena</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1"
                                   @checked(old('activo', $usuario->activo)) {{ $usuario->id === auth()->id() ? 'disabled' : '' }}>
                            <label class="form-check-label" for="activo">
                                Cuenta activa
                                @if($usuario->id === auth()->id())
                                    <span class="text-muted small">(no puedes desactivar tu propia cuenta)</span>
                                @endif
                            </label>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Guardar cambios</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Info adicional --}}
    <div class="card mt-3">
        <div class="card-body">
            <div class="row g-2 text-muted small">
                <div class="col-6"><i class="fas fa-calendar me-1"></i>Registrado: {{ $usuario->created_at->format('d/m/Y H:i') }}</div>
                <div class="col-6"><i class="fas fa-clock me-1"></i>Actualizado: {{ $usuario->updated_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
