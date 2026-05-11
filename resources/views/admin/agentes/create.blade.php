@extends('layouts.app')
@section('title', 'Nuevo Agente')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <span class="badge bg-warning text-dark mb-2">Panel Administrador</span>
        <h1 class="mb-1" style="font-size:2rem"><i class="fas fa-user-plus me-2" style="color:var(--accent)"></i>Nuevo Agente</h1>
        <p class="mb-0 opacity-75">Crea una cuenta de agente y su perfil profesional</p>
    </div>
</div>

<div class="container py-4" style="max-width:760px">
    <a href="{{ route('admin.agentes.index') }}" class="btn btn-link text-muted ps-0 mb-4">
        <i class="fas fa-arrow-left me-1"></i>Volver a agentes
    </a>

    <form method="POST" action="{{ route('admin.agentes.store') }}">
        @csrf

        {{-- CUENTA --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px">
            <div class="card-body p-4">
                <h6 class="mb-3" style="font-weight:700"><i class="fas fa-lock text-accent me-2"></i>Cuenta de acceso</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Nombre completo *</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="Carlos Ramírez">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Correo electrónico *</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="agente@correo.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Contraseña *</label>
                        <div class="input-group">
                            <input type="password" name="password" id="pwd" class="form-control @error('password') is-invalid @enderror" placeholder="Mínimo 8 caracteres">
                            <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('pwd').type==='password'?(this.innerHTML='<i class=\'fas fa-eye-slash\'></i>',document.getElementById('pwd').type='text'):(this.innerHTML='<i class=\'fas fa-eye\'></i>',document.getElementById('pwd').type='password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="5512345678">
                    </div>
                </div>
            </div>
        </div>

        {{-- PERFIL PROFESIONAL --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px">
            <div class="card-body p-4">
                <h6 class="mb-3" style="font-weight:700"><i class="fas fa-id-card text-accent me-2"></i>Perfil profesional</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Especialidad</label>
                        <input type="text" name="especialidad" value="{{ old('especialidad') }}" class="form-control" placeholder="Residencial de lujo, Departamentos...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-600">Años de experiencia</label>
                        <input type="number" name="anios_experiencia" value="{{ old('anios_experiencia', 0) }}" min="0" max="60" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-600">No. Licencia</label>
                        <input type="text" name="licencia_numero" value="{{ old('licencia_numero') }}" class="form-control" placeholder="LIC-001">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-600">Biografía</label>
                        <textarea name="biografia" rows="3" class="form-control" placeholder="Breve descripción del agente...">{{ old('biografia') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius:12px">
                <i class="fas fa-save me-2"></i>Crear Agente
            </button>
            <a href="{{ route('admin.agentes.index') }}" class="btn btn-outline-secondary btn-lg" style="border-radius:12px">Cancelar</a>
        </div>
    </form>
</div>
@endsection
