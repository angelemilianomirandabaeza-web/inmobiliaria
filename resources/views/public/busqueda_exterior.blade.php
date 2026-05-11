@extends('layouts.app')
@section('title', 'Busqueda en portales externos')

@section('content')
{{-- HEADER --}}
<div style="background: linear-gradient(135deg, #1e293b, #0f172a); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex align-items-center gap-3 mb-3">
            <span style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3); border-radius: 10px; padding: 10px 14px;">
                <i class="fas fa-globe-americas" style="color: var(--accent); font-size: 1.4rem"></i>
            </span>
            <div>
                <h1 class="mb-0" style="font-size: 1.9rem; font-weight: 800">Busqueda exterior</h1>
                <p class="mb-0 opacity-60" style="font-size: 0.9rem">Consulta en paralelo Mercado Libre y mas portales de bienes raices</p>
            </div>
        </div>

        {{-- FORMULARIO DE BUSQUEDA --}}
        <form method="GET" action="{{ route('busqueda.exterior') }}" class="d-flex gap-2 mt-4" style="max-width: 700px">
            <div class="flex-grow-1 position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: rgba(255,255,255,0.5); pointer-events: none"></i>
                <input
                    type="text"
                    name="q"
                    value="{{ $query }}"
                    placeholder="Ej: casa 3 recamaras Guadalajara..."
                    autocomplete="off"
                    class="form-control form-control-lg"
                    style="padding-left: 40px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: white; border-radius: 12px"
                >
            </div>
            <button type="submit" class="btn btn-warning btn-lg px-4" style="border-radius: 12px; font-weight: 700; white-space: nowrap">
                <i class="fas fa-search me-1"></i> Buscar
            </button>
        </form>
    </div>
</div>

<div class="container py-4">

    {{-- ESTADO INICIAL: sin búsqueda --}}
    @if($query === '')
        <div class="text-center py-5 my-4">
            <div style="font-size: 4rem; opacity: 0.15"><i class="fas fa-globe"></i></div>
            <h4 class="mt-3">¿Que propiedad buscas?</h4>
            <p class="text-muted">Escribe tu busqueda arriba para consultar multiples portales en tiempo real.</p>

            <div class="row g-3 justify-content-center mt-4" style="max-width: 700px; margin: auto">
                @foreach([
                    ['Mercado Libre', 'fas fa-store', '#FFE600', '#1e293b'],
                    ['Google (multi-portal)', 'fab fa-google', '#4285F4', 'white'],
                ] as [$nombre, $icon, $bg, $color])
                <div class="col-6 col-md-4">
                    <div class="card h-100 border-0" style="border-radius: 14px; background: {{ $bg }}10; border: 1px solid {{ $bg }}40 !important">
                        <div class="card-body text-center py-3">
                            <i class="{{ $icon }}" style="font-size: 1.6rem; color: {{ $bg }}"></i>
                            <p class="mb-0 small fw-600 mt-2">{{ $nombre }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    @else
        {{-- ERRORES de portales --}}
        @if(count($errores))
            <div class="mb-3">
                @foreach($errores as $portal => $msg)
                    <div class="alert alert-warning alert-dismissible py-2 d-flex align-items-center gap-2" role="alert" style="border-radius: 10px">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span><strong>{{ ucfirst($portal) }}:</strong> {{ $msg }}</span>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                    </div>
                @endforeach
            </div>
        @endif

        @if(count($resultados) === 0)
            <div class="text-center py-5">
                <div style="font-size: 3.5rem; opacity: 0.2"><i class="fas fa-search-minus"></i></div>
                <h4 class="mt-3">Sin resultados</h4>
                <p class="text-muted">Ningún portal respondio resultados para <strong>"{{ $query }}"</strong>. Intenta con otros terminos.</p>
            </div>
        @else
            {{-- RESUMEN --}}
            <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
                <p class="mb-0 text-muted">
                    Resultados para <strong class="text-dark">"{{ $query }}"</strong>
                    &mdash; {{ collect($resultados)->sum(fn($r) => count($r['items'])) }} propiedades en
                    {{ count($resultados) }} {{ count($resultados) === 1 ? 'portal' : 'portales' }}
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach($resultados as $key => $portal)
                        <span class="badge" style="background: {{ $portal['color'] }}20; color: {{ $portal['color'] === '#FFE600' ? '#1e293b' : $portal['color'] }}; border: 1px solid {{ $portal['color'] }}40; padding: 6px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600">
                            <i class="{{ $portal['icon'] }} me-1"></i>
                            {{ $portal['nombre'] }} &mdash; {{ count($portal['items']) }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- TABS --}}
            <ul class="nav nav-pills mb-4 gap-2" id="portalTabs" role="tablist">
                @foreach($resultados as $key => $portal)
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link {{ $loop->first ? 'active' : '' }}"
                            id="tab-{{ $key }}"
                            data-bs-toggle="pill"
                            data-bs-target="#pane-{{ $key }}"
                            type="button" role="tab"
                            style="border-radius: 30px; font-weight: 600; {{ $loop->first ? 'background: var(--primary); color: white' : '' }}"
                        >
                            <i class="{{ $portal['icon'] }} me-1"></i>
                            {{ $portal['nombre'] }}
                            <span class="badge bg-secondary ms-1">{{ count($portal['items']) }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content" id="portalTabsContent">
                @foreach($resultados as $key => $portal)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="pane-{{ $key }}" role="tabpanel">

                        @if(count($portal['items']) === 0)
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-2x mb-3 opacity-30"></i>
                                <p>Este portal no devolvio resultados.</p>
                            </div>
                        @else
                            <div class="row g-4">
                                @foreach($portal['items'] as $item)
                                    <div class="col-sm-6 col-lg-4 col-xl-3">
                                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="text-decoration-none">
                                            <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden; transition: transform .2s, box-shadow .2s"
                                                 onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.12)'"
                                                 onmouseout="this.style.transform='';this.style.boxShadow=''">

                                                {{-- IMAGEN --}}
                                                <div style="position: relative; height: 180px; overflow: hidden; background: var(--gray-100)">
                                                    @if($item['imagen'])
                                                        <img src="{{ $item['imagen'] }}"
                                                             alt="{{ $item['titulo'] }}"
                                                             style="width:100%; height:100%; object-fit:cover"
                                                             onerror="this.parentElement.innerHTML='<div style=\'display:flex;align-items:center;justify-content:center;height:100%;color:#9ca3af\'><i class=\'fas fa-home fa-2x\'></i></div>'">
                                                    @else
                                                        <div style="display:flex;align-items:center;justify-content:center;height:100%;color:#9ca3af">
                                                            <i class="fas fa-home fa-2x"></i>
                                                        </div>
                                                    @endif

                                                    {{-- BADGE FUENTE --}}
                                                    <span style="position:absolute; top:10px; left:10px; background: {{ $portal['color'] }}; color: {{ $portal['color'] === '#FFE600' ? '#1e293b' : 'white' }}; font-size:0.65rem; font-weight:700; padding:3px 8px; border-radius:20px; text-transform:uppercase; letter-spacing:.5px">
                                                        @if($key === 'google' && isset($item['fuente']))
                                                            {{ str_replace('www.', '', $item['fuente']) }}
                                                        @else
                                                            {{ $portal['nombre'] }}
                                                        @endif
                                                    </span>

                                                    {{-- ICONO EXTERNO --}}
                                                    <span style="position:absolute; top:10px; right:10px; background: rgba(0,0,0,0.5); color:white; width:28px; height:28px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:0.65rem">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </span>
                                                </div>

                                                <div class="card-body p-3">
                                                    <h6 class="mb-1 text-dark" style="font-size:0.85rem; font-weight:700; line-height:1.3; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden">
                                                        {{ $item['titulo'] }}
                                                    </h6>

                                                    @if(isset($item['precio']) && $item['precio'])
                                                        <p class="mb-2" style="color: var(--accent-dark); font-weight:800; font-size:1rem">
                                                            ${{ number_format($item['precio'], 0, '.', ',') }}
                                                            <small class="text-muted fw-normal" style="font-size:0.7rem">{{ $item['moneda'] ?? 'MXN' }}</small>
                                                        </p>
                                                    @elseif(isset($item['descripcion']))
                                                        <p class="text-muted mb-2" style="font-size:0.75rem; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden">
                                                            {{ $item['descripcion'] }}
                                                        </p>
                                                    @endif

                                                    @if(isset($item['ubicacion']) && $item['ubicacion'])
                                                        <p class="mb-2 text-muted" style="font-size:0.75rem">
                                                            <i class="fas fa-map-marker-alt me-1 text-accent"></i>{{ $item['ubicacion'] }}
                                                        </p>
                                                    @endif

                                                    @if(isset($item['atributos']) && count($item['atributos']))
                                                        <div class="d-flex gap-2 flex-wrap">
                                                            @if(isset($item['atributos']['BEDROOMS']))
                                                                <span class="badge" style="background:var(--gray-100); color:var(--gray-500); font-size:0.65rem; font-weight:600">
                                                                    <i class="fas fa-bed me-1"></i>{{ $item['atributos']['BEDROOMS'] }}
                                                                </span>
                                                            @endif
                                                            @if(isset($item['atributos']['BATHROOMS']))
                                                                <span class="badge" style="background:var(--gray-100); color:var(--gray-500); font-size:0.65rem; font-weight:600">
                                                                    <i class="fas fa-bath me-1"></i>{{ $item['atributos']['BATHROOMS'] }}
                                                                </span>
                                                            @endif
                                                            @if(isset($item['atributos']['TOTAL_AREA']))
                                                                <span class="badge" style="background:var(--gray-100); color:var(--gray-500); font-size:0.65rem; font-weight:600">
                                                                    <i class="fas fa-ruler-combined me-1"></i>{{ $item['atributos']['TOTAL_AREA'] }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    @endif

    {{-- NOTA GOOGLE CSE --}}
    @if(!config('services.google_cse.key'))
        <div class="mt-5 p-4" style="background: linear-gradient(135deg, #4285F410, #34A85310); border: 1px dashed #4285F440; border-radius: 16px">
            <div class="d-flex gap-3 align-items-start">
                <i class="fab fa-google mt-1" style="font-size:1.4rem; color:#4285F4"></i>
                <div>
                    <h6 class="mb-1" style="font-weight:700">Activa Google CSE para ampliar la cobertura</h6>
                    <p class="mb-2 text-muted small">Con Google Custom Search puedes cubrir Lamudi, Vivanuncios, Inmuebles24 y mas portales con una sola clave (gratis hasta 100 busquedas/dia).</p>
                    <ol class="small text-muted mb-2 ps-3">
                        <li>En <strong>console.cloud.google.com</strong> copia tu <strong>API Key</strong> de Custom Search API</li>
                        <li>En <strong>programmablesearchengine.google.com</strong> crea un motor e ingresa los sitios: <code>lamudi.com.mx</code>, <code>vivanuncios.com.mx</code>, <code>inmuebles24.com</code>, <code>propiedades.com</code></li>
                        <li>Agrega al <code>.env</code>:<br>
                            <code>GOOGLE_CSE_KEY=tu_api_key</code><br>
                            <code>GOOGLE_CSE_ID=tu_cx_id</code>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
