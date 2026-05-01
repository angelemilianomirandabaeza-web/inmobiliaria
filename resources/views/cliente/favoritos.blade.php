@extends('layouts.app')
@section('title', 'Mis Favoritos')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-heart text-danger"></i> Mis Propiedades Favoritas</h2>

    @if($favoritos->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-heart-broken fa-4x text-muted mb-3"></i>
            <h5>Aun no tienes favoritos</h5>
            <p class="text-muted">Explora propiedades y guarda las que te interesen.</p>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary">Buscar propiedades</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($favoritos as $f)
                <div class="col-md-6 col-lg-4">
                    <div class="card property-card h-100">
                        <div class="position-relative">
                            <a href="{{ route('propiedades.show', $f->propiedad) }}">
                                <img src="{{ $f->propiedad->imagenPrincipal->url_imagen ?? 'https://picsum.photos/400/300' }}" class="card-img-top" style="height:200px; object-fit:cover">
                            </a>
                            <form method="POST" action="{{ route('cliente.favoritos.destroy', $f->propiedad) }}" class="position-absolute top-0 end-0 m-2">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Quitar de favoritos"><i class="fas fa-heart-broken"></i></button>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="price-tag mb-1">${{ number_format($f->propiedad->precio, 0) }}</div>
                            <h6>{{ Str::limit($f->propiedad->titulo, 50) }}</h6>
                            <p class="small text-muted mb-2">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $f->propiedad->colonia->nombre }}, {{ $f->propiedad->colonia->municipio->nombre }}
                            </p>
                            <a href="{{ route('propiedades.show', $f->propiedad) }}" class="btn btn-primary btn-sm w-100">Ver detalle</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $favoritos->links() }}</div>
    @endif
</div>
@endsection
