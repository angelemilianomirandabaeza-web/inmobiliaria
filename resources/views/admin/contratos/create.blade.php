@extends('layouts.app')
@section('title', 'Nuevo Contrato')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 2.5rem 0 2rem; color: white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255,255,255,.5)">
                <li class="breadcrumb-item"><a href="{{ route('admin.contratos.index') }}" class="text-white-50">Contratos</a></li>
                <li class="breadcrumb-item active text-white">Nuevo</li>
            </ol>
        </nav>
        <h1 class="mb-0" style="font-size:1.75rem"><i class="fas fa-plus-circle me-2"></i>Registrar contrato</h1>
    </div>
</div>

<div class="container py-4" style="max-width:780px">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.contratos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Propiedad <span class="text-danger">*</span></label>
                        <select name="propiedad_id" class="form-select @error('propiedad_id') is-invalid @enderror" required>
                            <option value="">Seleccionar propiedad</option>
                            @foreach($propiedades as $p)
                                <option value="{{ $p->id }}" @selected(old('propiedad_id')==$p->id)>
                                    {{ $p->titulo }} — {{ $p->colonia->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('propiedad_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Cliente <span class="text-danger">*</span></label>
                        <select name="cliente_id" class="form-select @error('cliente_id') is-invalid @enderror" required>
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}" @selected(old('cliente_id')==$c->id)>{{ $c->name }} ({{ $c->email }})</option>
                            @endforeach
                        </select>
                        @error('cliente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Agente <span class="text-danger">*</span></label>
                        <select name="agente_id" class="form-select @error('agente_id') is-invalid @enderror" required>
                            <option value="">Seleccionar agente</option>
                            @foreach($agentes as $a)
                                <option value="{{ $a->id }}" @selected(old('agente_id')==$a->id)>{{ $a->usuario->name }}</option>
                            @endforeach
                        </select>
                        @error('agente_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tipo de contrato <span class="text-danger">*</span></label>
                        <select name="tipo_contrato" class="form-select @error('tipo_contrato') is-invalid @enderror" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="compraventa" @selected(old('tipo_contrato')=='compraventa')>Compraventa</option>
                            <option value="arrendamiento" @selected(old('tipo_contrato')=='arrendamiento')>Arrendamiento</option>
                        </select>
                        @error('tipo_contrato')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Precio acordado <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="precio_acordado" class="form-control @error('precio_acordado') is-invalid @enderror"
                                   value="{{ old('precio_acordado') }}" min="0" step="0.01" required>
                        </div>
                        @error('precio_acordado')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Comision del agente</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="comision_agente" class="form-control @error('comision_agente') is-invalid @enderror"
                                   value="{{ old('comision_agente') }}" min="0" step="0.01">
                        </div>
                        @error('comision_agente')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha de firma <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_firma" class="form-control @error('fecha_firma') is-invalid @enderror"
                               value="{{ old('fecha_firma') }}" required>
                        @error('fecha_firma')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Fecha de entrega</label>
                        <input type="date" name="fecha_entrega" class="form-control @error('fecha_entrega') is-invalid @enderror"
                               value="{{ old('fecha_entrega') }}">
                        @error('fecha_entrega')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Archivo PDF del contrato</label>
                        <input type="file" name="archivo_pdf" class="form-control @error('archivo_pdf') is-invalid @enderror" accept=".pdf">
                        <div class="form-text">Maximo 10 MB en formato PDF.</div>
                        @error('archivo_pdf')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Guardar contrato</button>
                    <a href="{{ route('admin.contratos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
