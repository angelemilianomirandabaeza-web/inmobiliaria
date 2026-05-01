@extends('layouts.app')
@section('title', 'Editar Propiedad')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-edit"></i> Editar Propiedad</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('agente.propiedades.update', $propiedad) }}">
        @csrf @method('PUT')
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <input type="text" name="titulo" class="form-control" required value="{{ old('titulo', $propiedad->titulo) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $propiedad->descripcion) }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" required value="{{ old('precio', $propiedad->precio) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Operacion</label>
                        <select name="tipo_operacion_id" class="form-select">
                            @foreach($tiposOperacion as $op)
                                <option value="{{ $op->id }}" {{ $propiedad->tipo_operacion_id == $op->id ? 'selected' : '' }}>{{ $op->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipo</label>
                        <select name="tipo_propiedad_id" class="form-select">
                            @foreach($tiposPropiedad as $tp)
                                <option value="{{ $tp->id }}" {{ $propiedad->tipo_propiedad_id == $tp->id ? 'selected' : '' }}>{{ $tp->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label">Colonia</label>
                        <select name="colonia_id" class="form-select">
                            @foreach($colonias as $c)
                                <option value="{{ $c->id }}" {{ $propiedad->colonia_id == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $propiedad->direccion) }}">
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-md-3"><label class="form-label">Habitaciones</label><input type="number" name="habitaciones" class="form-control" value="{{ $propiedad->habitaciones }}"></div>
                    <div class="col-md-3"><label class="form-label">Banos</label><input type="number" name="banios" class="form-control" value="{{ $propiedad->banios }}"></div>
                    <div class="col-md-3"><label class="form-label">Estac.</label><input type="number" name="estacionamientos" class="form-control" value="{{ $propiedad->estacionamientos }}"></div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select name="estado_propiedad_id" class="form-select">
                            @foreach($estadosPropiedad as $ep)
                                <option value="{{ $ep->id }}" {{ $propiedad->estado_propiedad_id == $ep->id ? 'selected' : '' }}>{{ $ep->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar cambios</button>
        <a href="{{ route('agente.propiedades.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
