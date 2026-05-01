@extends('layouts.app')
@section('title', 'Mis Propiedades')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-home"></i> Mis Propiedades</h2>
        <a href="{{ route('agente.propiedades.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nueva</a>
    </div>

    <div class="row g-3">
        @forelse($propiedades as $p)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100">
                    <img src="{{ $p->imagenPrincipal->url_imagen ?? 'https://picsum.photos/400/250' }}" style="height:200px; object-fit:cover">
                    <div class="card-body">
                        <h6>{{ Str::limit($p->titulo, 40) }}</h6>
                        <p class="price-tag mb-1">${{ number_format($p->precio, 0) }}</p>
                        <p class="small text-muted mb-2">{{ $p->colonia->nombre }} | {{ $p->tipoPropiedad->nombre }}</p>
                        <div>
                            @if($p->aprobada)
                                <span class="badge bg-success">Aprobada</span>
                            @else
                                <span class="badge bg-warning">Pendiente aprobacion</span>
                            @endif
                            <span class="badge" style="background:{{ $p->estadoPropiedad->color }}">{{ $p->estadoPropiedad->nombre }}</span>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex gap-1">
                            <a href="{{ route('agente.propiedades.show', $p) }}" class="btn btn-sm btn-outline-primary flex-grow-1"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('agente.propiedades.edit', $p) }}" class="btn btn-sm btn-outline-warning flex-grow-1"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('agente.propiedades.destroy', $p) }}" onsubmit="return confirm('¿Eliminar?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No tienes propiedades registradas. <a href="{{ route('agente.propiedades.create') }}">Agrega tu primera propiedad</a>.</div>
            </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $propiedades->links() }}</div>
</div>
@endsection
