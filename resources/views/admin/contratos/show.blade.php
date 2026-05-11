@extends('layouts.app')
@section('title', 'Detalle de Contrato #' . $contrato->id)

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 2.5rem 0 2rem; color: white">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="--bs-breadcrumb-divider-color: rgba(255,255,255,.5)">
                <li class="breadcrumb-item"><a href="{{ route('admin.contratos.index') }}" class="text-white-50">Contratos</a></li>
                <li class="breadcrumb-item active text-white">Contrato #{{ $contrato->id }}</li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="mb-1" style="font-size:1.75rem"><i class="fas fa-file-contract me-2"></i>Contrato #{{ $contrato->id }}</h1>
                <span class="badge {{ $contrato->tipo_contrato === 'compraventa' ? 'bg-success' : 'bg-info text-dark' }} fs-6">
                    {{ ucfirst($contrato->tipo_contrato) }}
                </span>
            </div>
            <div class="d-flex gap-2">
                @if($contrato->archivo_pdf)
                    <a href="{{ Storage::url($contrato->archivo_pdf) }}" target="_blank" class="btn btn-outline-light">
                        <i class="fas fa-file-pdf me-1"></i> Ver PDF
                    </a>
                @endif
                <form method="POST" action="{{ route('admin.contratos.destroy', $contrato) }}" onsubmit="return confirm('¿Eliminar este contrato?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger"><i class="fas fa-trash me-1"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        {{-- Propiedad --}}
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header fw-semibold"><i class="fas fa-home me-2 text-primary"></i>Propiedad</div>
                <div class="card-body">
                    @if($contrato->propiedad->imagenPrincipal)
                        <img src="{{ $contrato->propiedad->imagenPrincipal->url_imagen }}" class="img-fluid rounded mb-3" style="max-height:180px;width:100%;object-fit:cover">
                    @endif
                    <h6 class="fw-bold">{{ $contrato->propiedad->titulo }}</h6>
                    <p class="text-muted small mb-1"><i class="fas fa-map-marker-alt me-1"></i>{{ $contrato->propiedad->colonia->nombre }}, {{ $contrato->propiedad->colonia->municipio->nombre }}</p>
                    <p class="price-tag mb-0">${{ number_format($contrato->propiedad->precio, 0) }}</p>
                    <a href="{{ route('propiedades.show', $contrato->propiedad) }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Ver propiedad</a>
                </div>
            </div>
        </div>

        {{-- Partes --}}
        <div class="col-md-7">
            <div class="row g-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header fw-semibold"><i class="fas fa-user me-2 text-success"></i>Cliente</div>
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.2rem;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($contrato->cliente->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $contrato->cliente->name }}</div>
                                <div class="text-muted small">{{ $contrato->cliente->email }}</div>
                                @if($contrato->cliente->telefono)
                                    <div class="text-muted small"><i class="fas fa-phone me-1"></i>{{ $contrato->cliente->telefono }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header fw-semibold"><i class="fas fa-user-tie me-2 text-primary"></i>Agente</div>
                        <div class="card-body d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:48px;height:48px;font-size:1.2rem;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($contrato->agente->usuario->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $contrato->agente->usuario->name }}</div>
                                <div class="text-muted small">{{ $contrato->agente->usuario->email }}</div>
                                <div class="text-muted small">Licencia: {{ $contrato->agente->licencia_numero }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detalles financieros --}}
        <div class="col-12">
            <div class="card">
                <div class="card-header fw-semibold"><i class="fas fa-dollar-sign me-2 text-warning"></i>Detalles del contrato</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6 col-lg-3">
                            <div class="text-muted small mb-1">Precio acordado</div>
                            <div class="fw-bold fs-5 text-success">${{ number_format($contrato->precio_acordado, 0) }}</div>
                        </div>
                        @if($contrato->comision_agente)
                        <div class="col-sm-6 col-lg-3">
                            <div class="text-muted small mb-1">Comision agente</div>
                            <div class="fw-bold">${{ number_format($contrato->comision_agente, 0) }}</div>
                        </div>
                        @endif
                        <div class="col-sm-6 col-lg-3">
                            <div class="text-muted small mb-1">Fecha de firma</div>
                            <div class="fw-semibold">{{ $contrato->fecha_firma->format('d/m/Y') }}</div>
                        </div>
                        @if($contrato->fecha_entrega)
                        <div class="col-sm-6 col-lg-3">
                            <div class="text-muted small mb-1">Fecha de entrega</div>
                            <div class="fw-semibold">{{ $contrato->fecha_entrega->format('d/m/Y') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
