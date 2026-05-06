@extends('layouts.app')

@section('content')
<div class="container py-5">
    <!-- Encabezado: Título, Buscador y Botón -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <!-- 1. El Título: Ahora te dice qué estás viendo (Clientes o Agentes) -->
        <div>
            <h2 class="h3 mb-1 text-body-emphasis fw-bold">
                Gestión de {{ request('rol') == 'agente' ? 'Agentes' : (request('rol') == 'cliente' ? 'Clientes' : 'Usuarios') }}
            </h2>
            <p class="text-muted mb-0">Administra los accesos y roles del sistema.</p>
        </div>

        <!-- 2. La Barra de Búsqueda de USUARIOS (La que sí queremos) -->
        <form action="{{ route('admin.usuarios.index') }}" method="GET" style="min-width: 300px;">
            <!-- Si venimos del Dashboard, mantenemos el filtro de rol oculto aquí -->
            @if(request('rol'))
                <input type="hidden" name="rol" value="{{ request('rol') }}">
            @endif
            
            <div class="input-group shadow-sm">
                <input type="text" name="search" class="form-control border-primary-subtle" placeholder="Buscar por nombre o correo..." value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search') || request('rol'))
                    <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary">Limpiar</a>
                @endif
            </div>
        </form>

        <!-- 3. El Botón de Nuevo Usuario -->
        <button class="btn btn-primary px-4 shadow-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
            <i class="fas fa-plus-circle me-2"></i> Nuevo Usuario
        </button>
    </div>

    <!-- Contenedor de la Tabla -->
    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            @include('components.admin.user-table')
        </div>
    </div>
</div>

<!-- MODAL PARA NUEVO USUARIO (Igual que lo tenías) -->
<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-labelledby="modalNuevoUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-bottom-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-body-emphasis" id="modalNuevoUsuarioLabel">Registrar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.usuarios.store') }}" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-body">Nombre Completo</label>
                        <input type="text" name="name" class="form-control form-control-lg fs-6" placeholder="Ej. Oscar Lopez" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-body">Correo Electrónico</label>
                        <input type="email" name="email" class="form-control form-control-lg fs-6" placeholder="nombre@ejemplo.com" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-body">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-lg fs-6" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-body">Rol del Usuario</label>
                            <select name="rol_id" class="form-select form-select-lg fs-6">
                                <option value="1">Administrador</option>
                                <option value="2">Agente</option>
                                <option value="3">Cliente</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary px-4 shadow">Guardar Usuario</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection