@extends('layouts.app')
@section('title', $propiedad->titulo)

@section('content')
<div class="container py-4">
    <a href="{{ route('agente.propiedades.index') }}" class="btn btn-link mb-3"><i class="fas fa-arrow-left"></i> Volver</a>

    <div class="card">
        <img src="{{ $propiedad->imagenPrincipal->url_imagen ?? 'https://picsum.photos/800/400' }}" style="height:300px; object-fit:cover">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h2>{{ $propiedad->titulo }}</h2>
                <div class="text-end">
                    <p class="price-tag" style="font-size:2rem">${{ number_format($propiedad->precio, 0) }}</p>
                </div>
            </div>
            <p>{{ $propiedad->descripcion }}</p>
            <hr>
            <h5>Visitas registradas</h5>
            @if($propiedad->visitas->isEmpty())
                <p class="text-muted">Sin visitas aun.</p>
            @else
                <ul>
                    @foreach($propiedad->visitas as $v)
                        <li>{{ $v->fecha_visita->format('d/m/Y') }} - {{ $v->cliente->name }}</li>
                    @endforeach
                </ul>
            @endif
            <a href="{{ route('agente.propiedades.edit', $propiedad) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
            <a href="{{ route('propiedades.show', $propiedad) }}" target="_blank" class="btn btn-info">Ver publica</a>
        </div>
    </div>
</div>
@endsection
