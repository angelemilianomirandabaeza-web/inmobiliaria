@extends('layouts.app')
@section('title', 'Panel Agente')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <span class="badge bg-warning text-dark mb-2">Panel Agente Inmobiliario</span>
                <h1 class="mb-1" style="font-size:2rem">Hola, {{ auth()->user()->name }} 👋</h1>
                <p class="mb-0 opacity-75">Gestiona tus propiedades y citas desde aqui</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0">
                <a href="{{ route('agente.pipeline.index') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-stream me-1"></i> Pipeline
                </a>
                <a href="{{ route('agente.propiedades.create') }}" class="btn btn-warning btn-lg">
                    <i class="fas fa-plus-circle me-1"></i> Nueva propiedad
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="50">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-home"></i></div>
                <div class="stat-number">{{ $stats['mis_propiedades'] }}</div>
                <small class="text-muted">Mis propiedades</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-bullseye"></i></div>
                <div class="stat-number text-success">{{ $stats['propiedades_activas'] }}</div>
                <small class="text-muted">Activas</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="150">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-calendar-day"></i></div>
                <div class="stat-number" style="color: var(--accent-dark)">{{ $stats['visitas_pendientes'] }}</div>
                <small class="text-muted">Visitas pendientes</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-trophy"></i></div>
                <div class="stat-number">{{ $stats['total_ventas'] }}</div>
                <small class="text-muted">Total ventas</small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-6" data-aos="fade-right">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-alt text-accent me-2"></i>Proximas visitas</span>
                </div>
                <div class="card-body">
                    @if($proximasVisitas->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times text-muted" style="font-size:3rem; opacity:0.3"></i>
                            <p class="text-muted mt-2 mb-0">No hay visitas programadas</p>
                        </div>
                    @else
                        @foreach($proximasVisitas as $v)
                            <div class="d-flex p-3 mb-2 rounded-3" style="background: var(--gray-50)">
                                <div class="text-center me-3" style="min-width:60px">
                                    <div class="fw-bold text-accent" style="font-size:1.25rem">{{ $v->fecha_visita->format('d') }}</div>
                                    <small class="text-uppercase text-muted">{{ $v->fecha_visita->format('M') }}</small>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-semibold">{{ Str::limit($v->propiedad->titulo, 50) }}</p>
                                    <small class="text-muted d-block"><i class="fas fa-clock me-1"></i>{{ $v->hora_inicio }}</small>
                                    <small class="text-muted"><i class="fas fa-user me-1"></i>{{ $v->cliente->name }}</small>
                                </div>
                                <span class="badge bg-secondary align-self-start">{{ $v->estadoVisita->nombre }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6" data-aos="fade-left">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-home text-accent me-2"></i>Mis propiedades recientes</span>
                    <a href="{{ route('agente.propiedades.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
                </div>
                <div class="card-body">
                    @if($misPropiedadesRecientes->isEmpty())
                        <div class="text-center py-4">
                            <i class="fas fa-home text-muted" style="font-size:3rem; opacity:0.3"></i>
                            <p class="text-muted mt-2 mb-2">Aun no tienes propiedades</p>
                            <a href="{{ route('agente.propiedades.create') }}" class="btn btn-primary btn-sm">Agregar primera</a>
                        </div>
                    @else
                        @foreach($misPropiedadesRecientes as $p)
                            <a href="{{ route('agente.propiedades.show', $p) }}" class="d-flex p-3 mb-2 rounded-3 text-decoration-none text-dark"
                               style="background: var(--gray-50); transition: all 0.2s"
                               onmouseover="this.style.background='var(--gray-100)'"
                               onmouseout="this.style.background='var(--gray-50)'">
                                <div class="me-3">
                                    <img src="{{ $p->imagenPrincipal->url_imagen ?? 'https://picsum.photos/100' }}" style="width:60px;height:60px;object-fit:cover;border-radius:8px">
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 fw-semibold">{{ Str::limit($p->titulo, 45) }}</p>
                                    <p class="mb-0 small text-accent fw-bold">${{ number_format($p->precio, 0) }}</p>
                                </div>
                                <span class="badge align-self-start" style="background:{{ $p->estadoPropiedad->color }}">{{ $p->estadoPropiedad->nombre }}</span>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
