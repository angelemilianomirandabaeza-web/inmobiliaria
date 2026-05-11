@extends('layouts.app')
@section('title', 'Comparar Propiedades')

@push('styles')
<style>
    .step-badge {
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--primary); color: white;
        display: inline-flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 0.9rem; flex-shrink: 0;
    }
    .compare-table td, .compare-table th { vertical-align: middle; }
    .compare-table thead th { background: var(--primary); color: white; border: none; padding: 1rem; }
    .compare-table tbody td { padding: 0.85rem 1rem; }
    .compare-table tbody tr:hover { background: var(--gray-50); }
    .highlight-best { color: var(--success); font-weight: 700; }
    .prop-header-img { width: 100%; height: 160px; object-fit: cover; border-radius: 12px; }
</style>
@endpush

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <h1 class="mb-1" style="font-size: 2rem; font-weight: 800">
            <i class="fas fa-balance-scale me-2" style="color: var(--accent)"></i>Comparador de Propiedades
        </h1>
        <p class="mb-0 opacity-60">Compara hasta 3 propiedades lado a lado</p>
    </div>
</div>

<div class="container py-5">

    @if($propiedades->isEmpty())
        {{-- ESTADO VACÍO — instrucciones visuales --}}
        <div class="text-center mb-5">
            <div style="font-size: 3.5rem; opacity: 0.12"><i class="fas fa-balance-scale"></i></div>
            <h4 class="mt-3 mb-1">Aun no has seleccionado propiedades</h4>
            <p class="text-muted">Sigue estos pasos para comparar propiedades en segundos:</p>
        </div>

        <div class="row g-4 justify-content-center mb-5" style="max-width: 800px; margin: auto">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px">
                    <div class="card-body text-center p-4">
                        <span class="step-badge mb-3 d-inline-flex">1</span>
                        <div style="font-size: 2.2rem; margin-bottom: 0.75rem">🏠</div>
                        <h6 style="font-weight: 700">Ve al listado</h6>
                        <p class="text-muted small mb-0">Navega por todas las propiedades disponibles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px">
                    <div class="card-body text-center p-4">
                        <span class="step-badge mb-3 d-inline-flex">2</span>
                        <div style="font-size: 2.2rem; margin-bottom: 0.75rem">⚖️</div>
                        <h6 style="font-weight: 700">Haz clic en <i class="fas fa-balance-scale" style="color: var(--accent)"></i></h6>
                        <p class="text-muted small mb-0">Cada tarjeta tiene un boton de comparar. Selecciona hasta 3 propiedades.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px">
                    <div class="card-body text-center p-4">
                        <span class="step-badge mb-3 d-inline-flex">3</span>
                        <div style="font-size: 2.2rem; margin-bottom: 0.75rem">📊</div>
                        <h6 style="font-weight: 700">Compara</h6>
                        <p class="text-muted small mb-0">Aparece una barra flotante en la parte inferior. Haz clic en "Comparar".</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA: ir al listado o recuperar selección de localStorage --}}
        <div class="text-center">
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary btn-lg px-5" style="border-radius: 12px">
                <i class="fas fa-search me-2"></i>Explorar propiedades
            </a>
            <p class="text-muted small mt-3 mb-0" id="savedHint" style="display:none">
                <i class="fas fa-info-circle me-1"></i>
                Tienes propiedades guardadas en la barra de abajo — haz clic en <strong>Comparar</strong> para verlas.
            </p>
        </div>

    @else
        {{-- TABLA DE COMPARACIÓN --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <p class="mb-0 text-muted">Comparando <strong class="text-dark">{{ $propiedades->count() }}</strong> {{ $propiedades->count() === 1 ? 'propiedad' : 'propiedades' }}</p>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 20px">
                <i class="fas fa-plus me-1"></i>Agregar mas
            </a>
        </div>

        <div class="table-responsive">
            <table class="table compare-table border-0 shadow-sm" style="border-radius: 16px; overflow: hidden">
                <thead>
                    <tr>
                        <th style="width: 160px; min-width: 140px">Caracteristica</th>
                        @foreach($propiedades as $p)
                            <th class="text-center" style="min-width: 220px">
                                <a href="{{ route('propiedades.show', $p) }}" class="text-decoration-none text-white">
                                    <img src="{{ $p->imagenPrincipal->url_imagen ?? 'https://picsum.photos/400/300' }}"
                                         alt="{{ $p->titulo }}"
                                         class="prop-header-img mb-2"
                                         onerror="this.src='https://picsum.photos/400/300'">
                                    <div style="font-size: 0.9rem; font-weight: 700; line-height: 1.3">{{ Str::limit($p->titulo, 45) }}</div>
                                </a>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{-- PRECIO --}}
                    @php $precios = $propiedades->pluck('precio'); $minPrecio = $precios->min(); @endphp
                    <tr>
                        <td><i class="fas fa-tag text-accent me-2"></i><strong>Precio</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">
                                <span class="{{ $p->precio === $minPrecio && $propiedades->count() > 1 ? 'highlight-best' : '' }}" style="font-size: 1.1rem">
                                    ${{ number_format($p->precio, 0) }}
                                </span>
                                @if($p->precio === $minPrecio && $propiedades->count() > 1)
                                    <br><small class="badge" style="background: #10b98120; color: #059669; font-size: 0.65rem">Mejor precio</small>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    {{-- TIPO --}}
                    <tr>
                        <td><i class="fas fa-home text-accent me-2"></i><strong>Tipo</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->tipoPropiedad->nombre }}</td>
                        @endforeach
                    </tr>

                    {{-- OPERACION --}}
                    <tr>
                        <td><i class="fas fa-handshake text-accent me-2"></i><strong>Operacion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">
                                <span class="badge bg-warning text-dark">{{ $p->tipoOperacion->nombre }}</span>
                            </td>
                        @endforeach
                    </tr>

                    {{-- UBICACION --}}
                    <tr>
                        <td><i class="fas fa-map-marker-alt text-accent me-2"></i><strong>Ubicacion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center small">{{ $p->colonia->nombre }}, {{ $p->colonia->municipio->nombre }}</td>
                        @endforeach
                    </tr>

                    {{-- HABITACIONES --}}
                    @php $maxHab = $propiedades->max('habitaciones'); @endphp
                    <tr>
                        <td><i class="fas fa-bed text-accent me-2"></i><strong>Habitaciones</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center {{ $p->habitaciones === $maxHab && $maxHab > 0 && $propiedades->count() > 1 ? 'highlight-best' : '' }}">
                                {{ $p->habitaciones ?: '—' }}
                            </td>
                        @endforeach
                    </tr>

                    {{-- BAÑOS --}}
                    @php $maxBan = $propiedades->max('banios'); @endphp
                    <tr>
                        <td><i class="fas fa-bath text-accent me-2"></i><strong>Banos</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center {{ $p->banios === $maxBan && $maxBan > 0 && $propiedades->count() > 1 ? 'highlight-best' : '' }}">
                                {{ $p->banios ?: '—' }}
                            </td>
                        @endforeach
                    </tr>

                    {{-- ESTACIONAMIENTOS --}}
                    <tr>
                        <td><i class="fas fa-car text-accent me-2"></i><strong>Estacionamientos</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->estacionamientos ?: '—' }}</td>
                        @endforeach
                    </tr>

                    {{-- M² CONSTRUCCIÓN --}}
                    @php $maxM2 = $propiedades->max('metros_construccion'); @endphp
                    <tr>
                        <td><i class="fas fa-ruler-combined text-accent me-2"></i><strong>m² Construccion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center {{ $p->metros_construccion == $maxM2 && $maxM2 > 0 && $propiedades->count() > 1 ? 'highlight-best' : '' }}">
                                {{ $p->metros_construccion ? number_format($p->metros_construccion, 0) . ' m²' : '—' }}
                            </td>
                        @endforeach
                    </tr>

                    {{-- M² TERRENO --}}
                    <tr>
                        <td><i class="fas fa-expand-arrows-alt text-accent me-2"></i><strong>m² Terreno</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->metros_terreno ? number_format($p->metros_terreno, 0) . ' m²' : '—' }}</td>
                        @endforeach
                    </tr>

                    {{-- AMENIDADES --}}
                    <tr>
                        <td><i class="fas fa-star text-accent me-2"></i><strong>Amenidades</strong></td>
                        @foreach($propiedades as $p)
                            <td>
                                @if($p->amenidades->isEmpty())
                                    <span class="text-muted small">—</span>
                                @else
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($p->amenidades as $a)
                                            <span class="badge" style="background: var(--gray-100); color: var(--gray-500); font-size: 0.65rem; font-weight: 600">{{ $a->nombre }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>

                    {{-- ACCIONES --}}
                    <tr style="background: var(--gray-50)">
                        <td><strong>Accion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">
                                <a href="{{ route('propiedades.show', $p) }}" class="btn btn-primary btn-sm" style="border-radius: 20px">
                                    <i class="fas fa-eye me-1"></i>Ver detalle
                                </a>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 20px">
                <i class="fas fa-arrow-left me-1"></i>Volver al listado
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Si el usuario tiene propiedades en el comparador local, mostrar el hint
document.addEventListener('DOMContentLoaded', () => {
    try {
        const saved = JSON.parse(localStorage.getItem('compare_properties') || '[]');
        if (saved.length > 0) {
            const hint = document.getElementById('savedHint');
            if (hint) hint.style.display = '';
        }
    } catch (e) {}
});
</script>
@endpush
