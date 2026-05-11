@extends('layouts.app')
@section('title', 'Gestión de Agentes')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-warning text-dark mb-2">Panel Administrador</span>
                <h1 class="mb-1" style="font-size:2rem"><i class="fas fa-user-tie me-2" style="color:var(--accent)"></i>Gestión de Agentes</h1>
                <p class="mb-0 opacity-75">{{ $agentes->total() }} agentes registrados en el sistema</p>
            </div>
            <a href="{{ route('admin.agentes.create') }}" class="btn btn-warning btn-lg">
                <i class="fas fa-plus me-2"></i>Nuevo Agente
            </a>
        </div>
    </div>
</div>

<div class="container py-4">
    {{-- BACK --}}
    <a href="{{ route('admin.dashboard') }}" class="btn btn-link text-muted ps-0 mb-3">
        <i class="fas fa-arrow-left me-1"></i>Volver al dashboard
    </a>

    <div class="card border-0 shadow-sm" style="border-radius:16px; overflow:hidden">
        <div class="card-body p-0">
            @if($agentes->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-user-tie fa-3x opacity-20 mb-3"></i>
                    <h5>No hay agentes registrados</h5>
                    <a href="{{ route('admin.agentes.create') }}" class="btn btn-primary mt-2">Crear el primer agente</a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: var(--gray-50)">
                            <tr>
                                <th class="ps-4 py-3">Agente</th>
                                <th>Especialidad</th>
                                <th class="text-center">Exp.</th>
                                <th class="text-center">Propiedades</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center pe-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agentes as $agente)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-light));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1.1rem;flex-shrink:0">
                                            {{ strtoupper(substr($agente->usuario->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-weight:600">{{ $agente->usuario->name }}</div>
                                            <small class="text-muted">{{ $agente->usuario->email }}</small><br>
                                            <small class="text-muted"><i class="fas fa-phone me-1"></i>{{ $agente->usuario->telefono ?? '—' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="text-muted small">{{ $agente->especialidad ?? '—' }}</span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="badge" style="background:var(--gray-100);color:var(--gray-500);font-weight:600">
                                        {{ $agente->anios_experiencia }} años
                                    </span>
                                </td>
                                <td class="text-center py-3">
                                    <span class="fw-bold">{{ $agente->propiedades_count }}</span>
                                </td>
                                <td class="text-center py-3">
                                    @if($agente->usuario->activo)
                                        <span class="badge" style="background:#10b98120;color:#059669;padding:5px 10px;border-radius:20px;font-weight:600">
                                            <i class="fas fa-circle me-1" style="font-size:0.5rem"></i>Activo
                                        </span>
                                    @else
                                        <span class="badge" style="background:#ef444420;color:#dc2626;padding:5px 10px;border-radius:20px;font-weight:600">
                                            <i class="fas fa-circle me-1" style="font-size:0.5rem"></i>Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center pe-4 py-3">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.agentes.edit', $agente) }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.agentes.toggle-activo', $agente) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $agente->usuario->activo ? 'btn-outline-warning' : 'btn-outline-success' }}" style="border-radius:8px" title="{{ $agente->usuario->activo ? 'Desactivar' : 'Activar' }}">
                                                <i class="fas {{ $agente->usuario->activo ? 'fa-ban' : 'fa-check' }}"></i>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.agentes.destroy', $agente) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('¿Eliminar a {{ $agente->usuario->name }}? Esta acción no se puede deshacer.')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:8px" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3 d-flex justify-content-center">
                    {{ $agentes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
