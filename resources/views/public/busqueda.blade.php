@extends('layouts.app')
@section('title', 'Buscar Propiedades')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css">
<style>
    [data-theme="dark"] .leaflet-tile { filter: brightness(0.7) invert(1) contrast(0.85) hue-rotate(200deg) saturate(0.6) brightness(0.8); }
    .marker-cluster-small div { background: rgba(245,158,11,0.9) !important; color:white !important; font-weight:700 !important; border-radius:50% !important; }
    .marker-cluster-medium div { background: rgba(217,119,6,0.9) !important; color:white !important; font-weight:700 !important; border-radius:50% !important; }
    .marker-cluster-large div { background: rgba(180,83,9,0.95) !important; color:white !important; font-weight:700 !important; border-radius:50% !important; }
    .marker-cluster-small, .marker-cluster-medium, .marker-cluster-large { background: rgba(245,158,11,0.3) !important; }
    .price-marker {
        background: var(--primary);
        color: white;
        padding: 4px 10px;
        border-radius: 100px;
        font-weight: 700;
        font-size: 0.75rem;
        white-space: nowrap;
        box-shadow: 0 4px 14px rgba(0,0,0,0.3);
        border: 2px solid white;
    }
    .price-marker.destacada { background: linear-gradient(135deg, var(--accent), var(--accent-dark)); }
    .view-toggle .btn { border-radius: 0; }
    .view-toggle .btn:first-child { border-radius: 10px 0 0 10px; }
    .view-toggle .btn:last-child { border-radius: 0 10px 10px 0; }
    .view-toggle .btn.active { background: var(--primary); color: white; border-color: var(--primary); }
</style>
@endpush

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <h1 class="mb-2" style="font-size:2.25rem">Encuentra tu propiedad ideal</h1>
        <p class="mb-0 opacity-75">{{ $propiedades->total() }} propiedades disponibles</p>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="card sticky-top" style="top: 90px">
                <div class="card-body">
                    <h6 class="d-flex align-items-center mb-3" style="font-weight:700">
                        <i class="fas fa-sliders-h text-accent me-2"></i> Filtros de busqueda
                    </h6>
                    <form method="GET" action="{{ route('propiedades.buscar') }}">
                        <div class="mb-3">
                            <label class="form-label small">Operacion</label>
                            <select name="tipo_operacion_id" class="form-select form-select-sm">
                                <option value="">Todas</option>
                                @foreach($tiposOperacion as $op)
                                    <option value="{{ $op->id }}" {{ request('tipo_operacion_id') == $op->id ? 'selected' : '' }}>{{ $op->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Tipo de propiedad</label>
                            <select name="tipo_propiedad_id" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                @foreach($tiposPropiedad as $tp)
                                    <option value="{{ $tp->id }}" {{ request('tipo_propiedad_id') == $tp->id ? 'selected' : '' }}>{{ $tp->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Ubicacion</label>
                            <select name="colonia_id" class="form-select form-select-sm">
                                <option value="">Todas las colonias</option>
                                @foreach($colonias as $c)
                                    <option value="{{ $c->id }}" {{ request('colonia_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}, {{ $c->municipio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>

                        <!-- SLIDER DE PRECIO -->
                        <div class="mb-3">
                            <label class="form-label small">Rango de precio</label>
                            <div id="priceSlider" class="mt-4 mb-2"></div>
                            <div class="d-flex justify-content-between mt-3">
                                <small class="text-muted">$<span id="priceMinDisplay">0</span></small>
                                <small class="text-muted">$<span id="priceMaxDisplay">25M</span></small>
                            </div>
                            <input type="hidden" name="precio_min" id="precio_min" value="{{ request('precio_min') }}">
                            <input type="hidden" name="precio_max" id="precio_max" value="{{ request('precio_max') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small">Habitaciones</label>
                            <div class="btn-group w-100" role="group">
                                @for($i = 1; $i <= 4; $i++)
                                    <input type="radio" class="btn-check" name="habitaciones" value="{{ $i }}" id="hab{{ $i }}" {{ request('habitaciones') == $i ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-primary" for="hab{{ $i }}">{{ $i }}+</label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Banos</label>
                            <div class="btn-group w-100" role="group">
                                @for($i = 1; $i <= 4; $i++)
                                    <input type="radio" class="btn-check" name="banios" value="{{ $i }}" id="ban{{ $i }}" {{ request('banios') == $i ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-primary" for="ban{{ $i }}">{{ $i }}+</label>
                                @endfor
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Aplicar filtros</button>
                        <a href="{{ route('propiedades.buscar') }}" class="btn btn-link w-100 mt-2 text-muted">Limpiar todo</a>
                    </form>
                </div>
            </div>
        </aside>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                <p class="mb-0 text-muted">Mostrando <strong class="text-dark">{{ $propiedades->count() }}</strong> de <strong class="text-dark">{{ $propiedades->total() }}</strong> resultados</p>
                <div class="d-flex gap-2 align-items-center">
                    <div class="btn-group view-toggle" role="group">
                        <button type="button" class="btn btn-outline-primary btn-sm active" id="viewGrid" title="Vista lista"><i class="fas fa-th"></i></button>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="viewMap" title="Vista mapa"><i class="fas fa-map-marked-alt"></i></button>
                    </div>
                    <form method="GET" class="d-flex">
                        @foreach(request()->except('orden', 'page') as $key => $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endforeach
                        <select name="orden" class="form-select form-select-sm" style="min-width:200px" onchange="this.form.submit()">
                            <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Mas recientes</option>
                            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            <option value="destacadas" {{ request('orden') == 'destacadas' ? 'selected' : '' }}>Destacadas primero</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- VISTA MAPA -->
            <div id="mapView" style="display:none">
                <div id="mapaPropiedades" style="height: 70vh; min-height: 600px; border-radius: 16px; overflow: hidden; border: 1px solid var(--border-color);"></div>
                <p class="text-muted small mt-2 mb-0">
                    <i class="fas fa-info-circle me-1"></i>
                    Haz clic en un marker para ver los detalles. Usa zoom para explorar zonas.
                </p>
            </div>

            <!-- VISTA GRID -->
            <div id="gridView" data-external-url="{{ route('api.busqueda-externa') }}"
                 data-params="{{ json_encode(request()->only(['busqueda','tipo_operacion_id','precio_min','precio_max','habitaciones','banios'])) }}">
                @if($propiedades->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-search-minus text-muted" style="font-size: 4rem; opacity: 0.3"></i>
                        <h4 class="mt-3">No se encontraron propiedades</h4>
                        <p class="text-muted">Intenta ajustar tus filtros para ver mas resultados.</p>
                        <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary mt-2">Ver todas las propiedades</a>
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($propiedades as $p)
                            <div class="col-md-6 col-lg-4">
                                @include('public.partials.property_card', ['p' => $p])
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 d-flex justify-content-center">
                        {{ $propiedades->links() }}
                    </div>
                @endif

                {{-- Resultados externos (multi-fuente) --}}
                <div id="externalLoading" class="text-center py-5 mt-4" style="display:none">
                    <div class="d-flex justify-content-center gap-3 mb-3">
                        <div class="spinner-grow spinner-grow-sm text-warning" role="status"></div>
                        <div class="spinner-grow spinner-grow-sm text-danger" style="animation-delay:.15s" role="status"></div>
                        <div class="spinner-grow spinner-grow-sm text-primary" style="animation-delay:.3s" role="status"></div>
                    </div>
                    <p class="text-muted mb-0">Buscando en portales externos...</p>
                </div>

                <div id="externalSection" class="mt-5" style="display:none">
                    <hr class="my-4">
                    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
                        <i class="fas fa-globe text-primary"></i>
                        <h5 class="mb-0 fw-bold">Propiedades en internet</h5>
                        <span class="text-muted small">(resultados de portales externos)</span>
                    </div>

                    {{-- Tabs de fuentes --}}
                    <ul class="nav nav-tabs" id="externalTabs" role="tablist"></ul>

                    <div class="tab-content pt-4" id="externalTabContent"></div>

                    <p class="text-muted small mt-3">
                        <i class="fas fa-info-circle me-1"></i>
                        InmoTech no es responsable del contenido de portales externos. Los precios y disponibilidad pueden variar.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
<script>
// PRICE SLIDER
const priceSlider = document.getElementById('priceSlider');
const minInput = document.getElementById('precio_min');
const maxInput = document.getElementById('precio_max');
const minDisp = document.getElementById('priceMinDisplay');
const maxDisp = document.getElementById('priceMaxDisplay');

const fmt = (v) => {
    v = Math.round(v);
    if (v >= 1000000) return (v/1000000).toFixed(1).replace('.0','') + 'M';
    if (v >= 1000) return Math.round(v/1000) + 'K';
    return v;
};

noUiSlider.create(priceSlider, {
    start: [
        parseInt(minInput.value) || 0,
        parseInt(maxInput.value) || 25000000
    ],
    connect: true,
    step: 50000,
    range: { 'min': 0, 'max': 25000000 },
    tooltips: [
        { to: v => '$' + fmt(v) },
        { to: v => '$' + fmt(v) }
    ]
});

priceSlider.noUiSlider.on('update', (values) => {
    minDisp.textContent = fmt(values[0]);
    maxDisp.textContent = fmt(values[1]);
});

priceSlider.noUiSlider.on('change', (values) => {
    minInput.value = Math.round(values[0]);
    maxInput.value = values[1] >= 25000000 ? '' : Math.round(values[1]);
});

// VIEW TOGGLE GRID / MAPA
let mapaInstance = null;

document.getElementById('viewGrid').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('viewMap').classList.remove('active');
    document.getElementById('gridView').style.display = '';
    document.getElementById('mapView').style.display = 'none';
});

document.getElementById('viewMap').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('viewGrid').classList.remove('active');
    document.getElementById('gridView').style.display = 'none';
    document.getElementById('mapView').style.display = '';
    if (!mapaInstance) initMapa();
    else setTimeout(() => mapaInstance.invalidateSize(), 100);
});

async function initMapa() {
    mapaInstance = L.map('mapaPropiedades').setView([23.6345, -102.5528], 5);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap',
        maxZoom: 19
    }).addTo(mapaInstance);

    const cluster = L.markerClusterGroup({
        showCoverageOnHover: false,
        maxClusterRadius: 50,
        spiderfyOnMaxZoom: true
    });

    try {
        const res = await fetch('{{ route("api.mapa-propiedades") }}');
        const props = await res.json();

        if (props.length === 0) {
            mapaInstance.setView([19.4326, -99.1332], 11);
            return;
        }

        const bounds = [];
        props.forEach(p => {
            const icon = L.divIcon({
                className: '',
                html: `<div class="price-marker ${p.destacada ? 'destacada' : ''}">$${formatPrice(p.precio)}</div>`,
                iconSize: null,
                iconAnchor: [40, 12]
            });

            const marker = L.marker([p.lat, p.lng], { icon });
            marker.bindPopup(`
                <div style="font-family: 'Inter', sans-serif; min-width:240px">
                    ${p.imagen ? `<img src="${p.imagen}" style="width:100%; height:140px; object-fit:cover; border-radius:8px; margin-bottom:8px">` : ''}
                    <strong style="font-size:0.95rem; display:block">${p.titulo.substring(0, 50)}${p.titulo.length > 50 ? '...' : ''}</strong>
                    <small style="color:#6b7280">${p.colonia}, ${p.municipio}</small>
                    <div style="display:flex; gap:4px; margin-top:6px">
                        <span style="background:#f3f4f6; padding:2px 6px; border-radius:4px; font-size:0.7rem">${p.tipo}</span>
                        <span style="background:#f59e0b; color:white; padding:2px 6px; border-radius:4px; font-size:0.7rem">${p.operacion}</span>
                    </div>
                    <strong style="color:#d97706; font-size:1.1rem; display:block; margin-top:8px">$${p.precio.toLocaleString('es-MX')}</strong>
                    <a href="${p.url}" class="btn btn-warning btn-sm w-100 mt-2" style="font-size:0.8rem">Ver detalle <i class="fas fa-arrow-right"></i></a>
                </div>
            `);
            cluster.addLayer(marker);
            bounds.push([p.lat, p.lng]);
        });

        mapaInstance.addLayer(cluster);
        if (bounds.length > 1) mapaInstance.fitBounds(bounds, { padding: [50, 50] });
        else mapaInstance.setView(bounds[0], 14);

        toast.success(`${props.length} propiedades cargadas en el mapa`);
    } catch (e) {
        console.error(e);
        toast.error('Error al cargar el mapa');
    }
}

function formatPrice(p) {
    if (p >= 1000000) return (p/1000000).toFixed(1).replace('.0','') + 'M';
    if (p >= 1000) return Math.round(p/1000) + 'K';
    return p;
}

// BUSQUEDA EXTERNA MULTI-FUENTE
(async function loadExternalResults() {
    const gridEl  = document.getElementById('gridView');
    const baseUrl = gridEl.dataset.externalUrl;
    const params  = JSON.parse(gridEl.dataset.params || '{}');

    if (!Object.values(params).some(v => v)) return;

    document.getElementById('externalLoading').style.display = 'block';

    try {
        const qs  = new URLSearchParams(params).toString();
        const res = await fetch(baseUrl + '?' + qs);
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const data = await res.json();

        document.getElementById('externalLoading').style.display = 'none';

        const fuentes = data.fuentes || [];
        if (!fuentes.length) return;

        document.getElementById('externalSection').style.display = 'block';
        const tabList    = document.getElementById('externalTabs');
        const tabContent = document.getElementById('externalTabContent');

        fuentes.forEach((fuente, idx) => {
            const id      = 'tab-' + fuente.fuente;
            const isFirst = idx === 0;
            const badge   = `<span class="badge ms-1" style="background:${fuente.color};color:${fuente.text_color};font-size:.65rem">${fuente.nombre.toUpperCase()}</span>`;
            const total   = fuente.total ? fuente.total.toLocaleString() : '';

            // Tab button
            const li = document.createElement('li');
            li.className = 'nav-item';
            li.innerHTML = `
                <button class="nav-link ${isFirst ? 'active' : ''}" data-bs-toggle="tab" data-bs-target="#${id}" type="button">
                    ${badge} <small class="text-muted ms-1">${total}</small>
                </button>`;
            tabList.appendChild(li);

            // Tab pane
            const pane = document.createElement('div');
            pane.className = `tab-pane fade ${isFirst ? 'show active' : ''}`;
            pane.id = id;

            const row = document.createElement('div');
            row.className = 'row g-4';

            fuente.resultados.forEach(p => {
                const precio = p.precio
                    ? (p.moneda === 'USD' ? 'USD ' + p.precio.toLocaleString('en-US') : '$' + p.precio.toLocaleString('es-MX'))
                    : null;

                const card = document.createElement('div');
                card.className = 'col-md-6 col-lg-4';
                card.innerHTML = `
                    <div class="property-card h-100 position-relative">
                        <span class="position-absolute top-0 end-0 m-2 badge z-1" style="background:${fuente.color};color:${fuente.text_color};font-size:.65rem">${fuente.nombre.toUpperCase()}</span>
                        <div class="overflow-hidden rounded-top" style="height:175px">
                            <img src="${p.imagen || 'https://placehold.co/400x175/e5e7eb/9ca3af?text=Sin+foto'}"
                                 class="w-100 h-100" style="object-fit:cover"
                                 onerror="this.src='https://placehold.co/400x175/e5e7eb/9ca3af?text=Sin+foto'">
                        </div>
                        <div class="p-3">
                            <p class="property-tipo mb-1">${p.tipo}</p>
                            <h6 class="property-title mb-1" style="font-size:.88rem;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">${p.titulo}</h6>
                            <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt me-1"></i>${p.ubicacion || 'Mexico'}</p>
                            ${p.snippet ? `<p class="text-muted mb-2" style="font-size:.78rem;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical">${p.snippet}</p>` : ''}
                            <div class="d-flex gap-3 text-muted mb-2" style="font-size:.78rem">
                                ${p.habitaciones ? `<span><i class="fas fa-bed me-1"></i>${p.habitaciones}</span>` : ''}
                                ${p.banios ? `<span><i class="fas fa-bath me-1"></i>${p.banios}</span>` : ''}
                                ${p.metros ? `<span><i class="fas fa-ruler-combined me-1"></i>${p.metros}</span>` : ''}
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-auto pt-1 border-top">
                                <span class="price-tag" style="font-size:.95rem">${precio || '<span class="text-muted small">Precio no disponible</span>'}</span>
                                <a href="${p.url}" target="_blank" rel="noopener noreferrer"
                                   class="btn btn-sm" style="background:${fuente.color};color:${fuente.text_color};border:none">
                                    Ver <i class="fas fa-external-link-alt ms-1" style="font-size:.65rem"></i>
                                </a>
                            </div>
                        </div>
                    </div>`;
                row.appendChild(card);
            });

            pane.appendChild(row);
            tabContent.appendChild(pane);
        });

    } catch (e) {
        document.getElementById('externalLoading').style.display = 'none';
        console.warn('External search error:', e);
    }
})();
</script>
@endpush
