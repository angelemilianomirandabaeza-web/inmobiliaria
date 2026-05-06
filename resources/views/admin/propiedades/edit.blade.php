@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i> Editar Propiedad</h5>
                    <a href="{{ route('admin.propiedades.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.propiedades.update', $propiedad) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Título de la Propiedad -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Título de la Publicación</label>
                            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $propiedad->titulo) }}" required>
                        </div>

                        <div class="row">
                            <!-- Precio -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Precio ($)</label>
                                <input type="number" name="precio" class="form-control" value="{{ old('precio', $propiedad->precio) }}" required>
                            </div>

                            <!-- Estado (Aprobada o no) -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Estado de Publicación</label>
                                <select name="aprobada" class="form-select">
                                    <option value="1" {{ $propiedad->aprobada ? 'selected' : '' }}>Aprobada / Pública</option>
                                    <option value="0" {{ !$propiedad->aprobada ? 'selected' : '' }}>Pendiente / Oculta</option>
                                </select>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary py-2 fw-bold">
                                <i class="fas fa-save me-2"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection