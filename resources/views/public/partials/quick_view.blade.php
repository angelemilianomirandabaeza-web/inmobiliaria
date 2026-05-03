<div class="quick-view-image">
    <img src="{{ $propiedad->imagenes->first()->url_imagen ?? 'https://picsum.photos/800/450' }}" alt="{{ $propiedad->titulo }}">
    <div class="position-absolute bottom-0 start-0 m-3 d-flex gap-2">
        @if($propiedad->destacada)
            <span class="badge-destacada"><i class="fas fa-star me-1"></i>Destacada</span>
        @endif
        <span class="badge-operacion">{{ $propiedad->tipoOperacion->nombre }}</span>
    </div>
    @if($propiedad->imagenes->count() > 1)
        <div class="position-absolute bottom-0 end-0 m-3">
            <span class="badge bg-white text-dark">
                <i class="fas fa-images me-1"></i>+{{ $propiedad->imagenes->count() - 1 }} fotos
            </span>
        </div>
    @endif
</div>
<div class="p-4">
    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-2">
        <span class="badge bg-light text-dark">{{ $propiedad->tipoPropiedad->nombre }}</span>
        <div class="price-tag" style="font-size:1.6rem">${{ number_format($propiedad->precio, 0) }}</div>
    </div>
    <h4 class="mb-2">{{ $propiedad->titulo }}</h4>
    <p class="text-muted mb-3">
        <i class="fas fa-map-marker-alt text-accent me-1"></i>
        {{ $propiedad->colonia->nombre }}, {{ $propiedad->colonia->municipio->nombre }}
    </p>

    <div class="row g-2 mb-3">
        @if($propiedad->habitaciones > 0)
        <div class="col-3 text-center p-2 rounded-3" style="background: var(--bg-tertiary)">
            <i class="fas fa-bed text-accent"></i>
            <p class="mb-0 small fw-bold mt-1">{{ $propiedad->habitaciones }} hab</p>
        </div>
        @endif
        @if($propiedad->banios > 0)
        <div class="col-3 text-center p-2 rounded-3" style="background: var(--bg-tertiary)">
            <i class="fas fa-bath text-accent"></i>
            <p class="mb-0 small fw-bold mt-1">{{ $propiedad->banios }} ban</p>
        </div>
        @endif
        @if($propiedad->estacionamientos > 0)
        <div class="col-3 text-center p-2 rounded-3" style="background: var(--bg-tertiary)">
            <i class="fas fa-car text-accent"></i>
            <p class="mb-0 small fw-bold mt-1">{{ $propiedad->estacionamientos }} est</p>
        </div>
        @endif
        @if($propiedad->metros_construccion)
        <div class="col-3 text-center p-2 rounded-3" style="background: var(--bg-tertiary)">
            <i class="fas fa-ruler-combined text-accent"></i>
            <p class="mb-0 small fw-bold mt-1">{{ (int)$propiedad->metros_construccion }}m²</p>
        </div>
        @endif
    </div>

    <p class="text-muted small">{{ Str::limit($propiedad->descripcion, 200) }}</p>

    @if($propiedad->amenidades->count() > 0)
    <div class="d-flex flex-wrap gap-1 mb-3">
        @foreach($propiedad->amenidades->take(5) as $a)
            <span class="badge bg-light text-dark">{{ $a->nombre }}</span>
        @endforeach
        @if($propiedad->amenidades->count() > 5)
            <span class="badge bg-light text-dark">+{{ $propiedad->amenidades->count() - 5 }} mas</span>
        @endif
    </div>
    @endif

    <div class="d-flex gap-2">
        <a href="{{ route('propiedades.show', $propiedad) }}" class="btn btn-warning flex-grow-1">
            <i class="fas fa-arrow-right me-1"></i> Ver detalle completo
        </a>
        <button class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>
