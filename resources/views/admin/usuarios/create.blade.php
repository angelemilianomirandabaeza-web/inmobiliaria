@extends('layouts.app')
@section('title', 'Nuevo Usuario')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 2.5rem 0 2rem; color: white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255,255,255,.5)">
                <li class="breadcrumb-item"><a href="{{ route('admin.usuarios.index') }}" class="text-white-50">Usuarios</a></li>
                <li class="breadcrumb-item active text-white">Nuevo</li>
            </ol>
        </nav>
        <h1 class="mb-0" style="font-size:1.75rem"><i class="fas fa-user-plus me-2"></i>Crear usuario</h1>
    </div>
</div>

<div class="container py-4" style="max-width:700px">
    @if($errors->any())
        <div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.usuarios.store') }}" id="createForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Nombre completo <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Telefono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                        <select name="rol_id" id="rolSelect" class="form-select @error('rol_id') is-invalid @enderror" required>
                            <option value="">Seleccionar rol</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->id }}" @selected(old('rol_id')==$r->id)>{{ ucfirst($r->nombre) }}</option>
                            @endforeach
                        </select>
                        @error('rol_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contrasena <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirmar contrasena <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" @checked(old('activo', true))>
                            <label class="form-check-label" for="activo">Cuenta activa</label>
                        </div>
                    </div>
                </div>

                {{-- Campos extra para agente --}}
                <div id="agenteFields" class="mt-3" style="display:none">
                    <hr>
                    <p class="fw-semibold text-primary mb-3"><i class="fas fa-user-tie me-1"></i>Datos del agente</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">No. Licencia</label>
                            <input type="text" name="licencia_numero" class="form-control" value="{{ old('licencia_numero') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Anos de experiencia</label>
                            <input type="number" name="anios_experiencia" class="form-control" value="{{ old('anios_experiencia', 0) }}" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Especialidad</label>
                            <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Biografia</label>
                            <textarea name="biografia" class="form-control" rows="3">{{ old('biografia') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Crear usuario</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('rolSelect').addEventListener('change', function () {
    const selectedText = this.options[this.selectedIndex].text.toLowerCase();
    document.getElementById('agenteFields').style.display = selectedText === 'agente' ? 'block' : 'none';
});
// Trigger on load in case of old() value
document.getElementById('rolSelect').dispatchEvent(new Event('change'));
</script>
@endpush
@endsection
