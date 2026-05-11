@extends('layouts.app')
@section('title', 'Panel Administrador')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <span class="badge bg-warning text-dark mb-2">Panel Administrador</span>
                <h1 class="mb-1" style="font-size:2rem">Hola, {{ auth()->user()->name }} 👋</h1>
                <p class="mb-0 opacity-75">Aqui esta el resumen general del sistema</p>
            </div>
            <div class="d-flex gap-2 mt-3 mt-md-0 flex-wrap">
                <a href="{{ route('admin.reporte') }}" class="btn btn-warning"><i class="fas fa-file-invoice me-1"></i> Reporte</a>
                <a href="{{ route('admin.propiedades.index') }}" class="btn btn-outline-light"><i class="fas fa-tasks me-1"></i> Aprobaciones</a>
                <a href="{{ route('admin.agentes.index') }}" class="btn btn-outline-light"><i class="fas fa-user-tie me-1"></i> Agentes</a>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <!-- Stats principales -->
    <div class="row g-3 mb-4">
        <div class="col-md-6 col-lg-2" data-aos="fade-up" data-aos-delay="50">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-home"></i></div>
                <div class="stat-number">{{ $stats['total_propiedades'] }}</div>
                <small class="text-muted">Total propiedades</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-2" data-aos="fade-up" data-aos-delay="100">
            <div class="stat-card">
                <div class="stat-icon success"><i class="fas fa-check-circle"></i></div>
                <div class="stat-number text-success">{{ $stats['propiedades_aprobadas'] }}</div>
                <small class="text-muted">Aprobadas</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-2" data-aos="fade-up" data-aos-delay="150">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
                <div class="stat-number" style="color: var(--accent-dark)">{{ $stats['propiedades_pendientes'] }}</div>
                <small class="text-muted">Pendientes</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-2" data-aos="fade-up" data-aos-delay="200">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ $stats['total_usuarios'] }}</div>
                <small class="text-muted">Usuarios</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-2" data-aos="fade-up" data-aos-delay="250">
            <div class="stat-card">
                <div class="stat-icon primary"><i class="fas fa-user-tie"></i></div>
                <div class="stat-number">{{ $stats['total_agentes'] }}</div>
                <small class="text-muted">Agentes</small>
            </div>
        </div>
        <div class="col-md-6 col-lg-2" data-aos="fade-up" data-aos-delay="300">
            <div class="stat-card">
                <div class="stat-icon warning"><i class="fas fa-calendar-check"></i></div>
                <div class="stat-number">{{ $stats['visitas_mes'] }}</div>
                <small class="text-muted">Visitas este mes</small>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7" data-aos="fade-right">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-chart-pie text-accent me-2"></i>Distribucion de propiedades</span>
                    <small class="text-muted">Por tipo</small>
                </div>
                <div class="card-body">
                    <canvas id="chartTipos" height="240"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-5" data-aos="fade-left">
            <div class="card h-100" style="background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color:white; border:none">
                <div class="card-body p-4 d-flex flex-column">
                    <i class="fas fa-tasks fa-2x mb-3 opacity-75"></i>
                    <h4 class="text-white">Propiedades por revisar</h4>
                    @if($stats['propiedades_pendientes'] > 0)
                        <p class="opacity-90">Hay <strong>{{ $stats['propiedades_pendientes'] }}</strong> propiedades esperando tu revision para ser publicadas.</p>
                        <a href="{{ route('admin.propiedades.index') }}" class="btn btn-light text-dark fw-bold mt-auto">
                            <i class="fas fa-eye me-1"></i> Revisar ahora
                        </a>
                    @else
                        <p class="opacity-90">No hay propiedades pendientes de revision. Estas al dia.</p>
                        <div class="mt-auto">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4" data-aos="fade-up">
        <div class="card-header">
            <i class="fas fa-history text-accent me-2"></i>Propiedades recientes
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Titulo</th>
                            <th>Agente</th>
                            <th>Tipo</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($propiedadesRecientes as $p)
                            <tr>
                                <td class="ps-4">{{ Str::limit($p->titulo, 50) }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-2"
                                             style="width:30px;height:30px;font-size:0.75rem;font-weight:700">
                                            {{ strtoupper(substr($p->agente->usuario->name, 0, 1)) }}
                                        </div>
                                        {{ $p->agente->usuario->name }}
                                    </div>
                                </td>
                                <td>{{ $p->tipoPropiedad->nombre }}</td>
                                <td class="fw-bold">${{ number_format($p->precio, 0) }}</td>
                                <td>
                                    @if($p->aprobada)
                                        <span class="badge bg-success">Aprobada</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <form method="POST" action="{{ route('admin.propiedades.destroy', $p) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta propiedad permanentemente del sistema?');">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar propiedad">
                                            <i class="fas fa-trash-alt"></i> Borrar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartTipos');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [@foreach($propiedadesPorTipo as $pt)'{{ $pt->tipoPropiedad->nombre ?? "N/A" }}',@endforeach],
        datasets: [{
            data: [@foreach($propiedadesPorTipo as $pt){{ $pt->total }},@endforeach],
            backgroundColor: ['#0f172a', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#06b6d4'],
            borderWidth: 0,
            hoverOffset: 8
        }]
    },
    options: {
        plugins: { legend: { position: 'right', labels: { font: { family: 'Inter', weight: 500 }, usePointStyle: true, padding: 15 } } },
        cutout: '65%'
    }
});
</script>
@endpush
@endsection
