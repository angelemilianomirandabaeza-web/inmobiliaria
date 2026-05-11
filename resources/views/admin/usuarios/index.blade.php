@extends('layouts.app')
@section('title', 'Gestión de Usuarios')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <span class="badge bg-warning text-dark mb-2">Panel Administrador</span>
                <h1 class="mb-1" style="font-size:2rem"><i class="fas fa-users me-2"></i>Gestión de usuarios</h1>
                <p class="mb-0 opacity-75">Administra cuentas, roles y accesos</p>
            </div>
            <a href="{{ route('admin.usuarios.create') }}" class="btn btn-warning">
                <i class="fas fa-user-plus me-1"></i> Nuevo usuario
            </a>
        </div>
    </div>
</div>

<div class="container py-4">

    @foreach(['success','error'] as $type)
        @if(session($type))
            <div class="alert alert-{{ $type === 'success' ? 'success' : 'danger' }} alert-dismissible fade show">
                <i class="fas fa-{{ $type === 'success' ? 'check-circle' : 'exclamation-circle' }} me-2"></i>{{ session($type) }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- Stats --}}
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="stat-card text-center">
                <div class="stat-icon primary"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ $stats['total'] }}</div>
                <small class="text-muted">Total</small>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center">
                <div class="stat-icon success"><i class="fas fa-user-check"></i></div>
                <div class="stat-number text-success">{{ $stats['activos'] }}</div>
                <small class="text-muted">Activos</small>
            </div>
        </div>
        <div class="col-4">
            <div class="stat-card text-center">
                <div class="stat-icon warning"><i class="fas fa-user-slash"></i></div>
                <div class="stat-number" style="color:var(--accent-dark)">{{ $stats['inactivos'] }}</div>
                <small class="text-muted">Inactivos</small>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <input type="text" name="busqueda" class="form-control" placeholder="Buscar por nombre o email..." value="{{ request('busqueda') }}">
                </div>
                <div class="col-md-3">
                    <select name="rol_id" class="form-select">
                        <option value="">Todos los roles</option>
                        @foreach($roles as $r)
                            <option value="{{ $r->id }}" @selected(request('rol_id')==$r->id)>{{ ucfirst($r->nombre) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="activo" class="form-select">
                        <option value="">Todos</option>
                        <option value="1" @selected(request('activo')==='1')>Activos</option>
                        <option value="0" @selected(request('activo')==='0')>Inactivos</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Filtrar</button>
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Registrado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $u)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center"
                                     style="width:38px;height:38px;font-weight:700;flex-shrink:0;font-size:.9rem;
                                     background:{{ $u->isAdmin() ? 'var(--gradient-primary)' : ($u->isAgente() ? '#8b5cf6' : 'var(--gradient-accent)') }}">
                                    {{ strtoupper(substr($u->name,0,1)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold">{{ $u->name }}</div>
                                    @if($u->telefono)<div class="text-muted" style="font-size:.75rem">{{ $u->telefono }}</div>@endif
                                </div>
                            </div>
                        </td>
                        <td class="text-muted small">{{ $u->email }}</td>
                        <td>
                            @php
                                $badgeColor = match($u->rol?->nombre) {
                                    'admin'   => 'danger',
                                    'agente'  => 'primary',
                                    'cliente' => 'success',
                                    default   => 'secondary',
                                };
                            @endphp
                            <span class="badge bg-{{ $badgeColor }}">{{ ucfirst($u->rol?->nombre ?? 'Sin rol') }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $u->activo ? 'bg-success' : 'bg-secondary' }}">
                                {{ $u->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="text-muted small">{{ $u->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('admin.usuarios.edit', $u) }}" class="btn btn-sm btn-outline-primary" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.usuarios.toggle', $u) }}">
                                        @csrf @method('PATCH')
                                        <button class="btn btn-sm {{ $u->activo ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                                title="{{ $u->activo ? 'Desactivar' : 'Activar' }}">
                                            <i class="fas fa-{{ $u->activo ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}" onsubmit="return confirm('¿Eliminar al usuario {{ $u->name }}? Esta accion no se puede deshacer.')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" title="Eliminar"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No se encontraron usuarios.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $usuarios->links() }}</div>
</div>
@endsection
