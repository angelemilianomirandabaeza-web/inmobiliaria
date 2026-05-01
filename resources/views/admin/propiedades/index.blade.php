@extends('layouts.app')
@section('title', 'Aprobar Propiedades')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-check-double"></i> Propiedades Pendientes de Aprobacion</h2>

    @if($pendientes->isEmpty())
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> No hay propiedades pendientes.</div>
    @else
        <div class="row g-3">
            @foreach($pendientes as $p)
                <div class="col-md-6">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-4">
                                <img src="{{ $p->imagenPrincipal->url_imagen ?? 'https://picsum.photos/300/200' }}" class="img-fluid rounded-start h-100" style="object-fit:cover">
                            </div>
                            <div class="col-8">
                                <div class="card-body">
                                    <h6>{{ $p->titulo }}</h6>
                                    <p class="text-muted small mb-1">Agente: {{ $p->agente->usuario->name }}</p>
                                    <p class="text-muted small mb-1">{{ $p->tipoPropiedad->nombre }} | {{ $p->colonia->nombre }}</p>
                                    <p class="price-tag" style="font-size:1rem">${{ number_format($p->precio, 0) }}</p>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('propiedades.show', $p) }}" target="_blank" class="btn btn-sm btn-outline-primary">Ver</a>
                                        <form method="POST" action="{{ route('admin.propiedades.aprobar', $p) }}">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Aprobar</button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.propiedades.rechazar', $p) }}" onsubmit="return confirm('¿Rechazar y eliminar?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Rechazar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $pendientes->links() }}</div>
    @endif
</div>
@endsection
