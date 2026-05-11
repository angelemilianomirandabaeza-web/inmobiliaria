@extends('layouts.app')
@section('title', 'Editar Agente')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <span class="badge bg-warning text-dark mb-2">Panel Administrador</span>
        <h1 class="mb-1" style="font-size:2rem"><i class="fas fa-user-edit me-2" style="color:var(--accent)"></i>Editar Agente</h1>
        <p class="mb-0 opacity-75">{{ $agente->usuario->name }}</p>
    </div>
</div>

<div class="container py-4" style="max-width:760px">
    <a href="{{ route('admin.agentes.index') }}" class="btn btn-link text-muted ps-0 mb-4">
        <i class="fas fa-arrow-left me-1"></i>Volver a agentes
    </a>

    {{-- BADGE ESTADO --}}
    <div class="mb-4 d-flex align-items-center gap-3">
        @if($agente->usuario->activo)
            <span class="badge" style="background:#10b98120;color:#059669;padding:6px 14px;border-radius:20px;font-size:0.85rem">
                <i class="fas fa-circle me-1" style="font-size:0.5rem"></i>Cuenta activa
            </span>
        @else
            <span class="badge" style="background:#ef444420;color:#dc2626;padding:6px 14px;border-radius:20px;font-size:0.85rem">
                <i class="fas fa-circle me-1" style="font-size:0.5rem"></i>Cuenta inactiva
            </span>
        @endif
        <form action="{{ route('admin.agentes.toggle-activo', $agente) }}" method="POST" class="d-inline">
            @csrf @method('PATCH')
            <button type="submit" class="btn btn-sm {{ $agente->usuario->activo ? 'btn-outline-warning' : 'btn-outline-success' }}" style="border-radius:8px">
                {{ $agente->usuario->activo ? 'Desactivar cuenta' : 'Activar cuenta' }}
            </button>
        </form>
    </div>

    <form method="POST" action="{{ route('admin.agentes.update', $agente) }}">
        @csrf @method('PUT')

        {{-- CUENTA --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px">
            <div class="card-body p-4">
                <h6 class="mb-3" style="font-weight:700"><i class="fas fa-lock text-accent me-2"></i>Cuenta de acceso</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Nombre completo *</label>
                        <input type="text" name="name" value="{{ old('name', $agente->usuario->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Correo electrónico *</label>
                        <input type="email" name="email" value="{{ old('email', $agente->usuario->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Nueva contraseña <small class="text-muted">(dejar vacío para no cambiar)</small></label>
                        <div class="input-group">
                            <input type="password" name="password" id="pwd" class="form-control @error('password') is-invalid @enderror" placeholder="Nueva contraseña...">
                            <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('pwd').type==='password'?(this.innerHTML='<i class=\'fas fa-eye-slash\'></i>',document.getElementById('pwd').type='text'):(this.innerHTML='<i class=\'fas fa-eye\'></i>',document.getElementById('pwd').type='password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-600">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono', $agente->usuario->telefono) }}" class="form-control">
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
                        <input type="text" name="especialidad" value="{{ old('especialidad', $agente->especialidad) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-600">Años de experiencia</label>
                        <input type="number" name="anios_experiencia" value="{{ old('anios_experiencia', $agente->anios_experiencia) }}" min="0" max="60" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-600">No. Licencia</label>
                        <input type="text" name="licencia_numero" value="{{ old('licencia_numero', $agente->licencia_numero) }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-600">Biografía</label>
                        <textarea name="biografia" rows="3" class="form-control">{{ old('biografia', $agente->biografia) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- STATS --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius:16px; background: var(--gray-50)">
            <div class="card-body p-4">
                <h6 class="mb-3" style="font-weight:700"><i class="fas fa-chart-bar text-accent me-2"></i>Estadísticas (solo lectura)</h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div style="font-size:1.8rem;font-weight:800">{{ $agente->propiedades()->count() }}</div>
                            <small class="text-muted">Propiedades</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div style="font-size:1.8rem;font-weight:800">{{ number_format($agente->calificacion_promedio ?? 0, 1) }}</div>
                            <small class="text-muted">Calificación prom.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div style="font-size:1.8rem;font-weight:800">{{ $agente->total_ventas ?? 0 }}</div>
                            <small class="text-muted">Ventas totales</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg px-5" style="border-radius:12px">
                <i class="fas fa-save me-2"></i>Guardar cambios
            </button>
            <a href="{{ route('admin.agentes.index') }}" class="btn btn-outline-secondary btn-lg" style="border-radius:12px">Cancelar</a>
        </div>
    </form>
</div>
@endsection
