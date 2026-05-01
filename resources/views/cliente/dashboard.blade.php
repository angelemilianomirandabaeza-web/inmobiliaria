@extends('layouts.app')
@section('title', 'Mi Panel')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <span class="badge bg-warning text-dark mb-2">Mi cuenta</span>
                <h1 class="mb-1" style="font-size:2rem">Hola, {{ auth()->user()->name }} 👋</h1>
                <p class="mb-0 opacity-75">Aqui tienes todo lo que necesitas para encontrar tu hogar ideal</p>
            </div>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-warning btn-lg mt-3 mt-md-0">
                <i class="fas fa-search me-1"></i> Buscar propiedades
            </a>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-3 mb-4">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="50">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(239,68,68,0.1); color: #ef4444"><i class="fas fa-heart"></i></div>
                <div class="stat-number" style="color:#ef4444">{{ $stats['favoritos'] }}</div>
                <small class="text-muted">Propiedades favoritas</small>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-number">{{ $stats['visitas_proximas'] }}</div>
                <small class="text-muted">Visitas proximas</small>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-bell"></i></div>
                <div class="stat-number" style="color: var(--accent-dark)">{{ $stats['alertas_activas'] }}</div>
                <small class="text-muted">Alertas activas</small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7" data-aos="fade-right">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-heart text-danger me-2"></i>Mis favoritos recientes</span>
                    <a href="{{ route('cliente.favoritos.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
                </div>
                <div class="card-body">
                    @if($favoritosRecientes->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-heart-broken text-muted" style="font-size:3rem; opacity:0.3"></i>
                            <h6 class="mt-3 mb-1">Aun no tienes favoritos</h6>
                            <p class="text-muted small mb-3">Explora propiedades y guarda las que te interesen</p>
                            <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary btn-sm">Explorar propiedades</a>
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach($favoritosRecientes as $f)
                                <div class="col-md-6">
                                    <a href="{{ route('propiedades.show', $f->propiedad) }}" class="d-flex border rounded-3 p-2 text-decoration-none text-dark"
                                       style="transition:all 0.2s" onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--gray-200)'">
                                        <img src="{{ $f->propiedad->imagenPrincipal->url_imagen ?? 'https://picsum.photos/100' }}" style="width:80px;height:80px;object-fit:cover;border-radius:8px">
                                        <div class="ms-2 flex-grow-1">
                                            <p class="mb-1 small fw-bold" style="line-height:1.3">{{ Str::limit($f->propiedad->titulo, 40) }}</p>
                                            <p class="mb-0 small text-muted"><i class="fas fa-map-marker-alt text-accent me-1"></i>{{ $f->propiedad->colonia->nombre }}</p>
                                            <p class="mb-0 small text-accent fw-bold mt-1">${{ number_format($f->propiedad->precio, 0) }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5" data-aos="fade-left">
            <div class="card h-100">
                <div class="card-header"><i class="fas fa-calendar text-accent me-2"></i>Proximas visitas</div>
                <div class="card-body">
                    @if($proximasVisitas->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-calendar-plus text-muted" style="font-size:3rem; opacity:0.3"></i>
                            <h6 class="mt-3 mb-1">Sin visitas programadas</h6>
                            <p class="text-muted small mb-0">Cuando agendes una visita aparecera aqui</p>
                        </div>
                    @else
                        @foreach($proximasVisitas as $v)
                            <div class="d-flex p-3 mb-2 rounded-3" style="background: var(--gray-50)">
                                <div class="text-center me-3" style="min-width:55px">
                                    <div class="fw-bold text-accent" style="font-size:1.25rem">{{ $v->fecha_visita->format('d') }}</div>
                                    <small class="text-uppercase text-muted">{{ $v->fecha_visita->format('M') }}</small>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-semibold small">{{ Str::limit($v->propiedad->titulo, 45) }}</p>
                                    <small class="text-muted d-block"><i class="fas fa-clock me-1"></i>{{ $v->hora_inicio }}</small>
                                    <small class="text-muted"><i class="fas fa-user-tie me-1"></i>{{ $v->agente->usuario->name }}</small>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="card mt-4" style="background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color:white; border:none" data-aos="fade-up">
        <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h4 class="text-white mb-2">¿Listo para encontrar tu nuevo hogar?</h4>
                <p class="mb-0 opacity-90">Tenemos cientos de propiedades esperandote</p>
            </div>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-light text-dark fw-bold mt-3 mt-md-0">
                Comenzar busqueda <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>
@endsection
