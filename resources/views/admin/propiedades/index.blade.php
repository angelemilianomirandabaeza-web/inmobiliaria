@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom gap-3">
        <div>
            <h2 class="h3 mb-1 text-body-emphasis fw-bold">Gestión de Propiedades</h2>
            <p class="text-muted mb-0">Administra el catálogo completo de InmoTech.</p>
        </div>

        <form action="{{ route('admin.propiedades.index') }}" method="GET" style="min-width: 350px;">
            <div class="input-group shadow-sm">
                <input type="text" name="search" class="form-control border-primary-subtle" 
                       placeholder="Buscar título, agente o colonia..." 
                       value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        <a href="{{ route('admin.propiedades.create') }}" class="btn btn-primary px-4 shadow-sm">
            <i class="fas fa-plus-circle me-2"></i> Nueva Propiedad
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Propiedad</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($propiedades as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $p->imagenPrincipal->url_imagen ?? 'https://picsum.photos/50/50' }}" 
                                             class="rounded me-3" style="width: 45px; height: 45px; object-fit: cover;">
                                        <div>
                                            <div class="fw-bold text-dark">{{ Str::limit($p->titulo, 35) }}</div>
                                            <small class="text-muted">${{ number_format($p->precio, 0) }} | {{ $p->colonia->nombre }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($p->aprobada)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Publicada</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3">Pendiente</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- 1. Ver (Solo texto y borde) -->
                                        <a href="{{ route('propiedades.show', $p) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-eye me-1"></i> Ver
                                        </a>

                                        <!-- 2. Editar -->
                                        <a href="{{ route('admin.propiedades.edit', $p) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit me-1"></i> Editar
                                        </a>
                                        
                                        <!-- 3. Aprobar -->
                                        @if(!$p->aprobada)
                                            <form action="{{ route('admin.propiedades.aprobar', $p) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm btn-success">
                                                    <i class="fas fa-check me-1"></i> Aprobar
                                                </button>
                                            </form>
                                        @endif

                                        <!-- 4. Eliminar -->
                                        <form action="{{ route('admin.propiedades.destroy', $p) }}" method="POST" class="form-eliminar">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-danger btn-confirmar-borrado">
                                                <i class="fas fa-trash-alt me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="text-center py-5">No hay resultados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-confirmar-borrado').forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault();
            const formulario = this.closest('.form-eliminar');
            Swal.fire({
                title: '¿Confirmar eliminación?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, borrar ahora',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    formulario.submit();
                }
            });
        });
    });
</script>
@endpush
@endsection