<div class="property-card" onclick="window.location='{{ route('propiedades.show', $p) }}'">
    <div class="img-wrapper">
        <img src="{{ $p->imagenPrincipal->url_imagen ?? 'https://picsum.photos/800/600' }}" alt="{{ $p->titulo }}" loading="lazy">
        <div class="position-absolute top-0 start-0 m-3 d-flex gap-2">
            @if($p->destacada)
                <span class="badge-destacada"><i class="fas fa-star me-1"></i>Destacada</span>
            @endif
        </div>
        <div class="position-absolute top-0 end-0 m-3">
            <span class="badge-operacion">{{ $p->tipoOperacion->nombre }}</span>
        </div>
        <div class="position-absolute bottom-0 start-0 m-3">
            <span class="badge bg-white text-dark px-2 py-1" style="font-size:0.7rem; font-weight:600">
                <i class="fas fa-eye me-1 text-muted"></i>{{ $p->visitas_contador }} vistas
            </span>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <span class="badge bg-light text-dark" style="font-size:0.7rem">{{ $p->tipoPropiedad->nombre }}</span>
        </div>
        <div class="price-tag">${{ number_format($p->precio, 0) }}</div>
        @if($p->precio_anterior)
            <small class="text-muted text-decoration-line-through d-block mb-1">${{ number_format($p->precio_anterior, 0) }}</small>
        @endif
        <h6 class="mt-2 mb-2" style="font-weight:600; line-height:1.4">{{ Str::limit($p->titulo, 55) }}</h6>
        <p class="text-muted small mb-3">
            <i class="fas fa-map-marker-alt text-accent me-1"></i>
            {{ $p->colonia->nombre }}, {{ $p->colonia->municipio->nombre }}
        </p>
        <div class="property-meta">
            @if($p->habitaciones > 0)<span><i class="fas fa-bed"></i>{{ $p->habitaciones }} hab</span>@endif
            @if($p->banios > 0)<span><i class="fas fa-bath"></i>{{ $p->banios }} ban</span>@endif
            @if($p->estacionamientos > 0)<span><i class="fas fa-car"></i>{{ $p->estacionamientos }}</span>@endif
            @if($p->metros_construccion)<span><i class="fas fa-ruler-combined"></i>{{ (int)$p->metros_construccion }}m²</span>@endif
        </div>
    </div>
</div>
