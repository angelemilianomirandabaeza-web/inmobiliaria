@extends('layouts.app')
@section('title', 'Reporte ejecutivo')

@push('styles')
<style>
@media print {
    .no-print, .navbar, footer, .scroll-progress, .cursor-follower, .whatsapp-float, .scroll-top, .compare-widget { display: none !important; }
    .container { max-width: 100% !important; }
    body { background: white !important; color: black !important; }
    .stat-card, .card { box-shadow: none !important; border: 1px solid #ddd !important; break-inside: avoid; }
    section { padding: 1rem 0 !important; }
    .reporte-header { background: #0f172a !important; color: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
.reporte-header { background: linear-gradient(135deg, var(--primary), var(--primary-light)); color: white; padding: 3rem 0; }
</style>
@endpush

@section('content')
<div class="reporte-header">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <small class="opacity-75 d-block" style="letter-spacing:0.15em; text-transform:uppercase">Reporte Ejecutivo</small>
                <h1 class="mb-0" style="font-size:2.5rem">InmoTech Analytics</h1>
                <p class="mb-0 opacity-75 mt-2">Generado el {{ now()->translatedFormat('d \d\e F \d\e Y \a \l\a\s H:i') }}</p>
            </div>
            <div class="no-print d-flex gap-2">
                <button onclick="window.print()" class="btn btn-warning btn-lg">
                    <i class="fas fa-file-pdf me-1"></i> Exportar PDF
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light">Volver</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- METRICAS GENERALES -->
    <h4 class="mb-3"><i class="fas fa-chart-line text-accent me-2"></i>Metricas generales</h4>
    <div class="row g-3 mb-5">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-home"></i></div>
                <div class="stat-number">{{ $stats['total_propiedades'] }}</div>
                <small class="text-muted">Total propiedades</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number text-success">{{ $stats['propiedades_aprobadas'] }}</div>
                <small class="text-muted">Aprobadas</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
                <div class="stat-number" style="color:var(--accent-dark)">{{ $stats['propiedades_pendientes'] }}</div>
                <small class="text-muted">Pendientes</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ $stats['total_usuarios'] }}</div>
                <small class="text-muted">Usuarios totales</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon purple"><i class="fas fa-user-tie"></i></div>
                <div class="stat-number">{{ $stats['total_agentes'] }}</div>
                <small class="text-muted">Agentes activos</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-calendar"></i></div>
                <div class="stat-number">{{ $stats['visitas_mes'] }}</div>
                <small class="text-muted">Visitas del mes</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-dollar-sign"></i></div>
                <div class="stat-number" style="font-size:1.6rem">${{ number_format($stats['precio_promedio'], 0) }}</div>
                <small class="text-muted">Precio promedio</small>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-trophy"></i></div>
                <div class="stat-number" style="font-size:1.6rem">${{ number_format($stats['precio_max'], 0) }}</div>
                <small class="text-muted">Precio mas alto</small>
            </div>
        </div>
    </div>

    <!-- DISTRIBUCION POR TIPO -->
    <h4 class="mb-3"><i class="fas fa-chart-pie text-accent me-2"></i>Propiedades por tipo</h4>
    <div class="card mb-5">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Tipo</th>
                        <th>Cantidad</th>
                        <th>Precio promedio</th>
                        <th>%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($propiedadesPorTipo as $pt)
                        <tr>
                            <td class="ps-3"><strong>{{ $pt->tipoPropiedad->nombre ?? 'N/A' }}</strong></td>
                            <td>{{ $pt->total }}</td>
                            <td>${{ number_format($pt->precio_promedio, 0) }}</td>
                            <td>
                                <div style="background: var(--bg-tertiary); border-radius: 10px; overflow: hidden; width: 200px; height: 8px">
                                    <div style="background: linear-gradient(135deg, var(--accent), var(--accent-dark)); height: 100%; width: {{ $stats['total_propiedades'] > 0 ? round($pt->total / $stats['total_propiedades'] * 100, 1) : 0 }}%"></div>
                                </div>
                                <small class="text-muted">{{ $stats['total_propiedades'] > 0 ? round($pt->total / $stats['total_propiedades'] * 100, 1) : 0 }}%</small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- POR OPERACION -->
    <h4 class="mb-3"><i class="fas fa-tags text-accent me-2"></i>Propiedades por operacion</h4>
    <div class="row g-3 mb-5">
        @foreach($propiedadesPorOperacion as $po)
            <div class="col-md-3">
                <div class="stat-card">
                    <h6 class="text-muted small text-uppercase">{{ $po->tipoOperacion->nombre ?? 'N/A' }}</h6>
                    <div class="stat-number">{{ $po->total }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- TOP AGENTES -->
    <h4 class="mb-3"><i class="fas fa-medal text-accent me-2"></i>Top agentes</h4>
    <div class="card mb-5">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">#</th>
                        <th>Agente</th>
                        <th>Especialidad</th>
                        <th>Propiedades</th>
                        <th>Calificacion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topAgentes as $i => $a)
                        <tr>
                            <td class="ps-3"><strong>{{ $i + 1 }}</strong></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-2" style="width:35px;height:35px;background:linear-gradient(135deg,var(--accent),var(--accent-dark));font-weight:700;font-size:0.85rem">
                                        {{ strtoupper(substr($a->usuario->name, 0, 1)) }}
                                    </div>
                                    {{ $a->usuario->name }}
                                </div>
                            </td>
                            <td><small class="text-muted">{{ $a->especialidad ?? 'General' }}</small></td>
                            <td><strong>{{ $a->propiedades_count }}</strong></td>
                            <td>
                                <i class="fas fa-star text-warning"></i> {{ number_format($a->calificacion_promedio, 1) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- TOP COLONIAS -->
    <h4 class="mb-3"><i class="fas fa-map-marker-alt text-accent me-2"></i>Zonas con mas propiedades</h4>
    <div class="card mb-5">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Colonia</th>
                        <th>Propiedades</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topColonias as $c)
                        <tr>
                            <td class="ps-3"><strong>{{ $c->nombre }}</strong></td>
                            <td>{{ $c->propiedades_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-muted small text-center mt-5 mb-0">
        InmoTech © {{ date('Y') }} | Reporte generado automaticamente
    </p>
</div>
@endsection
