@extends('layouts.app')
@section('title', 'Nueva Propiedad')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-plus-circle"></i> Publicar Nueva Propiedad</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('agente.propiedades.store') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-header">Informacion basica</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <input type="text" name="titulo" class="form-control" required value="{{ old('titulo') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" required value="{{ old('precio') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Operacion</label>
                        <select name="tipo_operacion_id" class="form-select" required>
                            @foreach($tiposOperacion as $op)
                                <option value="{{ $op->id }}">{{ $op->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipo de propiedad</label>
                        <select name="tipo_propiedad_id" class="form-select" required>
                            @foreach($tiposPropiedad as $tp)
                                <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Ubicacion</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Colonia</label>
                        <select name="colonia_id" class="form-select" required>
                            @foreach($colonias as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}, {{ $c->municipio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" required value="{{ old('direccion') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Caracteristicas</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label">m² Construccion</label><input type="number" name="metros_construccion" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">m² Terreno</label><input type="number" name="metros_terreno" class="form-control"></div>
                    <div class="col-md-2"><label class="form-label">Habitaciones</label><input type="number" name="habitaciones" class="form-control" value="0"></div>
                    <div class="col-md-2"><label class="form-label">Banos</label><input type="number" name="banios" class="form-control" value="0"></div>
                    <div class="col-md-2"><label class="form-label">Estac.</label><input type="number" name="estacionamientos" class="form-control" value="0"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Estado</label>
                    <select name="estado_propiedad_id" class="form-select">
                        @foreach($estadosPropiedad as $ep)
                            <option value="{{ $ep->id }}">{{ $ep->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mt-3">
                    <input type="checkbox" name="amueblado" class="form-check-input" id="amueblado">
                    <label class="form-check-label" for="amueblado">Amueblado</label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Amenidades</div>
            <div class="card-body">
                <div class="row">
                    @foreach($amenidades as $a)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="amenidades[]" value="{{ $a->id }}" class="form-check-input" id="am{{ $a->id }}">
                                <label class="form-check-label" for="am{{ $a->id }}">{{ $a->nombre }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Publicar propiedad</button>
            <a href="{{ route('agente.propiedades.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
