@extends('layouts.app')
@section('title', 'Contratos')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-warning text-dark mb-2">Panel Administrador</span>
                <h1 class="mb-1" style="font-size:2rem"><i class="fas fa-file-contract me-2"></i>Contratos</h1>
                <p class="mb-0 opacity-75">Administra todos los contratos del sistema</p>
            </div>
            <a href="{{ route('admin.contratos.create') }}" class="btn btn-warning">
                <i class="fas fa-plus me-1"></i> Nuevo contrato
            </a>
        </div>
    </div>
</div>

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show"><i class="fas fa-check-circle me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-file-contract"></i></div>
                <div class="stat-number">{{ $stats['total'] }}</div>
                <small class="text-muted">Total contratos</small>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-home"></i></div>
                <div class="stat-number text-success">{{ $stats['compraventa'] }}</div>
                <small class="text-muted">Compraventa</small>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-key"></i></div>
                <div class="stat-number" style="color:var(--accent-dark)">{{ $stats['arrendamiento'] }}</div>
                <small class="text-muted">Arrendamiento</small>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-number" style="font-size:1.1rem">${{ number_format($stats['monto_total'], 0) }}</div>
                <small class="text-muted">Monto total</small>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por propiedad o cliente..." value="{{ request('busqueda') }}">
                </div>
                <div class="col-md-3">
                    <select name="tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="compraventa" @selected(request('tipo')=='compraventa')>Compraventa</option>
                        <option value="arrendamiento" @selected(request('tipo')=='arrendamiento')>Arrendamiento</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="agente_id" class="form-select">
                        <option value="">Todos los agentes</option>
                        @foreach($agentes as $a)
                            <option value="{{ $a->id }}" @selected(request('agente_id')==$a->id)>{{ $a->usuario->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
                    <a href="{{ route('admin.contratos.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    @if($contratos->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-file-contract fa-4x text-muted mb-3"></i>
            <p class="text-muted">No hay contratos registrados aun.</p>
            <a href="{{ route('admin.contratos.create') }}" class="btn btn-primary">Registrar primer contrato</a>
        </div>
    @else
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Propiedad</th>
                            <th>Cliente</th>
                            <th>Agente</th>
                            <th>Tipo</th>
                            <th>Precio acordado</th>
                            <th>Fecha firma</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contratos as $c)
                        <tr>
                            <td class="text-muted small">{{ $c->id }}</td>
                            <td>
                                <div class="fw-semibold" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                                    {{ $c->propiedad->titulo }}
                                </div>
                            </td>
                            <td>{{ $c->cliente->name }}</td>
                            <td>{{ $c->agente->usuario->name }}</td>
                            <td>
                                <span class="badge {{ $c->tipo_contrato === 'compraventa' ? 'bg-success' : 'bg-info text-dark' }}">
                                    {{ ucfirst($c->tipo_contrato) }}
                                </span>
                            </td>
                            <td class="fw-semibold">${{ number_format($c->precio_acordado, 0) }}</td>
                            <td>{{ $c->fecha_firma->format('d/m/Y') }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.contratos.show', $c) }}" class="btn btn-sm btn-outline-primary" title="Ver detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($c->archivo_pdf)
                                        <a href="{{ Storage::url($c->archivo_pdf) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Ver PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    <form method="POST" action="{{ route('admin.contratos.destroy', $c) }}" onsubmit="return confirm('¿Eliminar este contrato?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">{{ $contratos->links() }}</div>
    @endif
</div>
@endsection
