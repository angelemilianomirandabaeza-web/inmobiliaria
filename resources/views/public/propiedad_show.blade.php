@extends('layouts.app')
@section('title', $propiedad->titulo)
@section('og_type', 'product')
@section('og_title', $propiedad->titulo . ' - $' . number_format($propiedad->precio, 0))
@section('og_description', Str::limit($propiedad->descripcion, 160))
@section('og_image', $propiedad->imagenPrincipal->url_imagen ?? 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1200&q=80')

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Product",
    "name": "{{ addslashes($propiedad->titulo) }}",
    "description": "{{ addslashes(Str::limit($propiedad->descripcion, 200)) }}",
    "image": "{{ $propiedad->imagenPrincipal->url_imagen ?? '' }}",
    "offers": {
        "@type": "Offer",
        "price": "{{ $propiedad->precio }}",
        "priceCurrency": "MXN",
        "availability": "https://schema.org/InStock"
    }
}
</script>
@endpush

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0" style="font-size:0.9rem">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('propiedades.buscar') }}" class="text-muted text-decoration-none">Propiedades</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($propiedad->titulo, 50) }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Galeria -->
            <div id="galeria" class="carousel slide mb-4 rounded-4 overflow-hidden shadow" data-bs-ride="carousel" data-aos="fade-up">
                <div class="carousel-indicators">
                    @foreach($propiedad->imagenes as $i => $img)
                        <button type="button" data-bs-target="#galeria" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"></button>
                    @endforeach
                </div>
                <div class="carousel-inner" style="background:#000">
                    @foreach($propiedad->imagenes as $i => $img)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            <img src="{{ $img->url_imagen }}" class="d-block w-100" style="height:520px; object-fit:cover">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#galeria" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#galeria" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
                <div class="position-absolute bottom-0 start-0 m-3 d-flex gap-2">
                    @if($propiedad->destacada)
                        <span class="badge-destacada"><i class="fas fa-star me-1"></i>Destacada</span>
                    @endif
                    <span class="badge-operacion">{{ $propiedad->tipoOperacion->nombre }}</span>
                </div>
                <div class="position-absolute bottom-0 end-0 m-3">
                    <span class="badge bg-white text-dark px-3 py-2" style="font-weight:600">
                        <i class="fas fa-eye me-1 text-muted"></i>{{ $propiedad->visitas_contador }} visitas
                    </span>
                </div>
            </div>

            <!-- Info principal -->
            <div class="card mb-4" data-aos="fade-up">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-3">
                        <div>
                            <h1 style="font-size:1.85rem; margin-bottom:0.5rem">{{ $propiedad->titulo }}</h1>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt text-accent me-1"></i>
                                {{ $propiedad->direccion }}, {{ $propiedad->colonia->nombre }}, {{ $propiedad->colonia->municipio->nombre }}
                            </p>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="badge bg-light text-dark border" style="font-size:0.8rem">{{ $propiedad->tipoPropiedad->nombre }}</span>
                                <span class="badge" style="background:{{ $propiedad->estadoPropiedad->color }}; font-size:0.8rem">{{ $propiedad->estadoPropiedad->nombre }}</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="price-tag" style="font-size:2.25rem">${{ number_format($propiedad->precio, 0) }}</div>
                            @if($propiedad->precio_anterior)
                                <small class="text-decoration-line-through text-muted">${{ number_format($propiedad->precio_anterior, 0) }}</small>
                                <span class="badge bg-success ms-1">-{{ round((1 - $propiedad->precio / $propiedad->precio_anterior) * 100) }}%</span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="row text-center g-3 my-3">
                        @if($propiedad->habitaciones > 0)
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3" style="background: var(--gray-50)">
                                <i class="fas fa-bed fa-2x text-accent mb-2"></i>
                                <p class="mb-0 fw-bold">{{ $propiedad->habitaciones }}</p>
                                <small class="text-muted">Habitaciones</small>
                            </div>
                        </div>
                        @endif
                        @if($propiedad->banios > 0)
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3" style="background: var(--gray-50)">
                                <i class="fas fa-bath fa-2x text-accent mb-2"></i>
                                <p class="mb-0 fw-bold">{{ $propiedad->banios }}@if($propiedad->medios_banios > 0).{{ $propiedad->medios_banios }}@endif</p>
                                <small class="text-muted">Banos</small>
                            </div>
                        </div>
                        @endif
                        @if($propiedad->estacionamientos > 0)
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3" style="background: var(--gray-50)">
                                <i class="fas fa-car fa-2x text-accent mb-2"></i>
                                <p class="mb-0 fw-bold">{{ $propiedad->estacionamientos }}</p>
                                <small class="text-muted">Estacionamientos</small>
                            </div>
                        </div>
                        @endif
                        @if($propiedad->metros_construccion)
                        <div class="col-6 col-md-3">
                            <div class="p-3 rounded-3" style="background: var(--gray-50)">
                                <i class="fas fa-ruler-combined fa-2x text-accent mb-2"></i>
                                <p class="mb-0 fw-bold">{{ (int)$propiedad->metros_construccion }} m²</p>
                                <small class="text-muted">Construccion</small>
                            </div>
                        </div>
                        @endif
                    </div>

                    <hr>

                    <h5 class="mb-3"><i class="fas fa-align-left text-accent me-2"></i>Descripcion</h5>
                    <p style="line-height:1.8">{{ $propiedad->descripcion }}</p>

                    @if($propiedad->amenidades->count() > 0)
                    <hr>
                    <h5 class="mb-3"><i class="fas fa-star text-accent me-2"></i>Amenidades incluidas</h5>
                    <div class="row">
                        @foreach($propiedad->amenidades as $a)
                            <div class="col-md-6 col-lg-4 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ $a->nombre }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif

                    @if($propiedad->latitud && $propiedad->longitud)
                    <hr>
                    <h5 class="mb-3"><i class="fas fa-map-marked-alt text-accent me-2"></i>Ubicacion</h5>
                    <div id="mapa-propiedad" style="height:400px; border-radius:16px; overflow:hidden; border: 1px solid var(--gray-200)"></div>
                    <small class="text-muted d-block mt-2">
                        <i class="fas fa-info-circle me-1"></i>
                        La ubicacion exacta se compartira al confirmar la visita
                    </small>
                    @endif

                    <hr>
                    <h5 class="mb-3"><i class="fas fa-info-circle text-accent me-2"></i>Detalles adicionales</h5>
                    <div class="row">
                        @if($propiedad->metros_terreno)
                            <div class="col-md-6 mb-2"><strong>Terreno:</strong> {{ (int)$propiedad->metros_terreno }} m²</div>
                        @endif
                        @if($propiedad->antiguedad_anios !== null)
                            <div class="col-md-6 mb-2"><strong>Antiguedad:</strong> {{ $propiedad->antiguedad_anios }} {{ $propiedad->antiguedad_anios == 1 ? 'ano' : 'anos' }}</div>
                        @endif
                        @if($propiedad->piso)
                            <div class="col-md-6 mb-2"><strong>Piso:</strong> {{ $propiedad->piso }}@if($propiedad->total_pisos) de {{ $propiedad->total_pisos }}@endif</div>
                        @endif
                        <div class="col-md-6 mb-2"><strong>Amueblado:</strong> {{ $propiedad->amueblado ? 'Si' : 'No' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @php
                $esElDueno = auth()->check() && auth()->user()->isAgente() && auth()->user()->agente->id === $propiedad->agente_id;
            @endphp

            @if($esElDueno)
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    <i class="fas fa-info-circle me-2"></i> <strong>Modo Vista Previa:</strong> Estas viendo tu propia propiedad tal como la ven los clientes. 
                    <a href="{{ route('agente.propiedades.edit', $propiedad) }}" class="alert-link ms-2">Editar propiedad</a>
                </div>
            @endif

            @if(!$esElDueno)
            <!-- Acciones -->
            <div class="d-flex gap-2 mb-3" data-aos="fade-up">
                @auth
                    @if(auth()->user()->isCliente())
                    <button type="button" class="btn btn-warning flex-grow-1" data-bs-toggle="modal" data-bs-target="#agendarVisitaModal">
                        <i class="fas fa-calendar-plus me-1"></i> Agendar visita
                    </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning flex-grow-1"><i class="fas fa-calendar-plus me-1"></i> Agendar visita</a>
                @endauth
                <button class="btn btn-outline-primary" onclick="navigator.share && navigator.share({url: window.location.href, title: '{{ $propiedad->titulo }}'}) || navigator.clipboard.writeText(window.location.href).then(() => toast.success('Enlace copiado'))" title="Compartir">
                    <i class="fas fa-share-alt"></i>
                </button>
                @auth
                    @if(auth()->user()->isCliente())
                        <form method="POST" action="{{ route('cliente.favoritos.store', $propiedad) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger" title="Añadir a favoritos">
                                <i class="fas fa-heart"></i>
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
            @endif

            @auth

                @if(auth()->user()->isCliente())
                @if(!$esElDueno)
                <!-- Modal: Agendar visita -->
                <div class="modal fade" id="agendarVisitaModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="border-radius:20px; border:none">
                            <div class="modal-header border-0">
                                <h5 class="modal-title"><i class="fas fa-calendar-plus text-accent me-2"></i>Agendar visita</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="{{ route('cliente.visitas.store', $propiedad) }}">
                                @csrf
                                <div class="modal-body">
                                    <p class="text-muted small mb-3">Selecciona la fecha y hora que prefieres. El agente confirmara via email.</p>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Fecha</label>
                                            <input type="date" name="fecha_visita" class="form-control" required min="{{ now()->format('Y-m-d') }}" max="{{ now()->addMonths(3)->format('Y-m-d') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Hora preferida</label>
                                            <select name="hora_inicio" class="form-select" required>
                                                <option value="">Selecciona</option>
                                                @foreach(['09:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00'] as $h)
                                                    <option value="{{ $h }}">{{ $h }} hrs</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Notas adicionales <small class="text-muted">(opcional)</small></label>
                                            <textarea name="notas_cliente" class="form-control" rows="3" placeholder="¿Algo que quieras comentarle al agente?"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane me-1"></i>Solicitar visita</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            @endauth

            @if(!$esElDueno)
            <!-- Agente -->
            <div class="card mb-3" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <h6 class="text-muted small mb-3 text-uppercase" style="letter-spacing:0.05em">Tu agente inmobiliario</h6>
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width:60px; height:60px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color:white; font-weight:700; font-size:1.4rem">
                            {{ strtoupper(substr($propiedad->agente->usuario->name, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $propiedad->agente->usuario->name }}</h6>
                            @if($propiedad->agente->especialidad)
                                <p class="text-muted small mb-1">{{ $propiedad->agente->especialidad }}</p>
                            @endif
                            <div class="d-flex align-items-center gap-2">
                                <div class="rating-stars" style="font-size:0.85rem">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($propiedad->agente->calificacion_promedio) ? 'filled' : '' }}"></i>
                                    @endfor
                                </div>
                                <small class="text-muted">{{ number_format($propiedad->agente->calificacion_promedio, 1) }}</small>
                            </div>
                        </div>
                    </div>
                    @if($propiedad->agente->anios_experiencia > 0)
                        <small class="text-muted d-block"><i class="fas fa-award text-accent me-1"></i>{{ $propiedad->agente->anios_experiencia }} anos de experiencia</small>
                    @endif

                    @auth
                        @if(auth()->user()->isCliente())
                            <hr>
                            <button class="btn btn-sm btn-outline-primary w-100" data-bs-toggle="modal" data-bs-target="#resenaModal">
                                <i class="fas fa-star me-1"></i> Calificar a este agente
                            </button>

                            <!-- Modal Reseña -->
                            <div class="modal fade" id="resenaModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius:20px; border:none">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title"><i class="fas fa-star text-accent me-2"></i>Califica al agente</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('cliente.resenas.store', $propiedad->agente) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <p class="text-muted small">Comparte tu experiencia con <strong>{{ $propiedad->agente->usuario->name }}</strong></p>
                                                <label class="form-label d-block">Tu calificacion</label>
                                                <div class="rating-stars interactive mb-3" id="ratingInput" style="font-size:2.5rem">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star" data-value="{{ $i }}"></i>
                                                    @endfor
                                                </div>
                                                <input type="hidden" name="calificacion" id="calificacionInput" required>
                                                <label class="form-label">Comentario <small class="text-muted">(opcional)</small></label>
                                                <textarea name="comentario" class="form-control" rows="4" placeholder="¿Como fue tu experiencia?"></textarea>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-warning"><i class="fas fa-paper-plane me-1"></i>Enviar reseña</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
            @endif

            @if(!$esElDueno)
            <!-- Contacto -->
            <div class="card mb-3" data-aos="fade-up" data-aos-delay="150">
                <div class="card-header">
                    <i class="fas fa-paper-plane text-accent me-2"></i>Contactar agente
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('contacto.store', $propiedad) }}">
                        @csrf
                        <div class="mb-2">
                            <input type="text" name="nombre_contacto" class="form-control" placeholder="Tu nombre" required value="{{ auth()->user()->name ?? '' }}">
                        </div>
                        <div class="mb-2">
                            <input type="email" name="email_contacto" class="form-control" placeholder="Email" required value="{{ auth()->user()->email ?? '' }}">
                        </div>
                        <div class="mb-2">
                            <input type="tel" name="telefono_contacto" class="form-control" placeholder="Telefono">
                        </div>
                        <div class="mb-3">
                            <textarea name="mensaje" class="form-control" rows="3" placeholder="Mensaje" required>Hola, me interesa esta propiedad. ¿Podemos agendar una visita?</textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100"><i class="fas fa-envelope me-1"></i> Enviar mensaje</button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Calculadora hipoteca -->
            <div class="card" data-aos="fade-up" data-aos-delay="200">
                <div class="card-header">
                    <i class="fas fa-calculator text-accent me-2"></i>Calculadora de hipoteca
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <label class="form-label small">Enganche (%)</label>
                        <input type="number" id="enganche" class="form-control form-control-sm" value="20" min="0" max="100">
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Plazo (anos)</label>
                        <input type="number" id="plazo" class="form-control form-control-sm" value="20" min="1" max="30">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Tasa anual (%)</label>
                        <input type="number" id="tasa" class="form-control form-control-sm" value="11" step="0.1" min="0">
                    </div>
                    <button onclick="calcular()" class="btn btn-primary w-100"><i class="fas fa-equals me-1"></i> Calcular</button>
                    <div id="resultado" class="mt-3 p-3 rounded-3 text-center" style="background: linear-gradient(135deg, rgba(245,158,11,0.1), rgba(217,119,6,0.05)); display:none">
                        <p class="mb-1 small text-muted">Mensualidad estimada</p>
                        <h3 class="mb-0" style="color: var(--accent-dark)" id="mensualidad"></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($similares->count() > 0)
    <section class="mt-5 pt-4">
        <h3 class="mb-4">Propiedades similares</h3>
        <div class="row g-4">
            @foreach($similares as $p)
                <div class="col-md-6 col-lg-3">
                    @include('public.partials.property_card', ['p' => $p])
                </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<style>
    [data-theme="dark"] .leaflet-tile { filter: brightness(0.7) invert(1) contrast(0.85) hue-rotate(200deg) saturate(0.6) brightness(0.8); }
    .leaflet-popup-content-wrapper { border-radius: 12px !important; }
    .property-marker {
        background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        width: 44px; height: 44px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.1rem;
        box-shadow: 0 8px 20px rgba(245,158,11,0.5);
        animation: pulse-marker 2s infinite;
    }
    .property-marker i { transform: rotate(45deg); }
    @keyframes pulse-marker {
        0%, 100% { box-shadow: 0 8px 20px rgba(245,158,11,0.5); }
        50% { box-shadow: 0 8px 30px rgba(245,158,11,0.8), 0 0 0 12px rgba(245,158,11,0.15); }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if($propiedad->latitud && $propiedad->longitud)
<script>
// MAPA LEAFLET
const lat = {{ $propiedad->latitud }};
const lng = {{ $propiedad->longitud }};
const mapa = L.map('mapa-propiedad', {
    center: [lat, lng],
    zoom: 15,
    scrollWheelZoom: false
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap',
    maxZoom: 19
}).addTo(mapa);

// Custom marker icon
const customIcon = L.divIcon({
    className: 'custom-property-marker',
    html: '<div class="property-marker"><i class="fas fa-home"></i></div>',
    iconSize: [44, 44],
    iconAnchor: [22, 44],
    popupAnchor: [0, -40]
});

const marker = L.marker([lat, lng], { icon: customIcon }).addTo(mapa);
marker.bindPopup(`
    <div style="font-family: 'Inter', sans-serif; min-width:200px">
        <strong style="font-size:0.95rem">{{ Str::limit($propiedad->titulo, 40) }}</strong><br>
        <small style="color:#6b7280">{{ $propiedad->colonia->nombre }}, {{ $propiedad->colonia->municipio->nombre }}</small><br>
        <strong style="color:#d97706; font-size:1.05rem; display:block; margin-top:4px">${{ number_format($propiedad->precio, 0) }}</strong>
    </div>
`).openPopup();

// Circulo de zona aproximada
L.circle([lat, lng], {
    color: '#f59e0b',
    fillColor: '#f59e0b',
    fillOpacity: 0.1,
    radius: 300,
    weight: 2
}).addTo(mapa);
</script>
@endif

<script>
// RATING INTERACTIVO
const ratingInput = document.getElementById('ratingInput');
if (ratingInput) {
    const stars = ratingInput.querySelectorAll('.fa-star');
    const hidden = document.getElementById('calificacionInput');
    let currentRating = 0;

    stars.forEach(star => {
        star.addEventListener('mouseenter', () => {
            const v = parseInt(star.dataset.value);
            stars.forEach((s, i) => s.classList.toggle('filled', i < v));
        });
        star.addEventListener('click', () => {
            currentRating = parseInt(star.dataset.value);
            hidden.value = currentRating;
        });
    });
    ratingInput.addEventListener('mouseleave', () => {
        stars.forEach((s, i) => s.classList.toggle('filled', i < currentRating));
    });
}

function calcular() {
    const precio = {{ $propiedad->precio }};
    const enganche = parseFloat(document.getElementById('enganche').value) / 100;
    const plazo = parseFloat(document.getElementById('plazo').value);
    const tasa = parseFloat(document.getElementById('tasa').value) / 100 / 12;
    const meses = plazo * 12;
    const monto = precio * (1 - enganche);
    const pago = monto * (tasa * Math.pow(1 + tasa, meses)) / (Math.pow(1 + tasa, meses) - 1);
    document.getElementById('mensualidad').textContent = '$' + pago.toLocaleString('es-MX', {maximumFractionDigits: 0});
    document.getElementById('resultado').style.display = 'block';
}
</script>
@endpush
@endsection
