@extends('layouts.app')
@section('title', 'Mis alertas')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="mb-2" style="font-size:2rem"><i class="fas fa-bell me-2"></i>Mis alertas</h1>
            <p class="mb-0 opacity-75">Te avisaremos cuando haya propiedades que cumplan tus criterios</p>
        </div>
        <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#nuevaAlertaModal">
            <i class="fas fa-plus me-1"></i> Nueva alerta
        </button>
    </div>
</div>

<div class="container py-4">
    @if($alertas->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-bell-slash text-muted" style="font-size:5rem; opacity:0.3"></i>
            <h4 class="mt-3">No tienes alertas creadas</h4>
            <p class="text-muted mb-3">Crea una alerta para recibir notificaciones cuando haya propiedades que te interesen</p>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#nuevaAlertaModal"><i class="fas fa-plus me-1"></i> Crear primera alerta</button>
        </div>
    @else
        <div class="row g-3">
            @foreach($alertas as $alerta)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100" data-aos="fade-up">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center" style="width:50px; height:50px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color:white; font-size:1.3rem">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <form method="POST" action="{{ route('cliente.alertas.destroy', $alerta) }}" onsubmit="return confirmarEliminar(event, this)">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-link text-danger p-1"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>

                            <h6>Alerta personalizada</h6>
                            <ul class="list-unstyled small text-muted mb-3">
                                @if($alerta->tipoOperacion)<li><i class="fas fa-tag text-accent me-1"></i> {{ $alerta->tipoOperacion->nombre }}</li>@endif
                                @if($alerta->tipoPropiedad)<li><i class="fas fa-home text-accent me-1"></i> {{ $alerta->tipoPropiedad->nombre }}</li>@endif
                                @if($alerta->colonia)<li><i class="fas fa-map-marker-alt text-accent me-1"></i> {{ $alerta->colonia->nombre }}, {{ $alerta->colonia->municipio->nombre }}</li>@endif
                                @if($alerta->precio_min || $alerta->precio_max)
                                    <li><i class="fas fa-dollar-sign text-accent me-1"></i>
                                        @if($alerta->precio_min) ${{ number_format($alerta->precio_min, 0) }}@else Sin minimo @endif
                                        -
                                        @if($alerta->precio_max) ${{ number_format($alerta->precio_max, 0) }}@else Sin maximo @endif
                                    </li>
                                @endif
                                @if($alerta->habitaciones_min)<li><i class="fas fa-bed text-accent me-1"></i> {{ $alerta->habitaciones_min }}+ habitaciones</li>@endif
                                @if($alerta->metros_min)<li><i class="fas fa-ruler text-accent me-1"></i> {{ $alerta->metros_min }}+ m²</li>@endif
                            </ul>

                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong style="color: var(--accent-dark); font-size:1.5rem">{{ $alerta->matches }}</strong>
                                    <small class="text-muted d-block">propiedades coinciden</small>
                                </div>
                                @php
                                    $params = array_filter([
                                        'tipo_propiedad_id' => $alerta->tipo_propiedad_id,
                                        'tipo_operacion_id' => $alerta->tipo_operacion_id,
                                        'colonia_id'        => $alerta->colonia_id,
                                        'precio_min'        => $alerta->precio_min,
                                        'precio_max'        => $alerta->precio_max,
                                        'habitaciones'      => $alerta->habitaciones_min,
                                    ]);
                                @endphp
                                <a href="{{ route('propiedades.buscar', $params) }}" class="btn btn-sm btn-outline-primary">Ver matches <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<!-- Modal Nueva Alerta -->
<div class="modal fade" id="nuevaAlertaModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:20px; border:none">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="fas fa-bell text-accent me-2"></i>Nueva alerta personalizada</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('cliente.alertas.store') }}">
                @csrf
                <div class="modal-body">
                    <p class="text-muted small mb-3">Configura los criterios para que te avisemos cuando haya nuevas propiedades.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Operacion</label>
                            <select name="tipo_operacion_id" class="form-select">
                                <option value="">Cualquiera</option>
                                @foreach($tiposOperacion as $op)
                                    <option value="{{ $op->id }}">{{ $op->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipo de propiedad</label>
                            <select name="tipo_propiedad_id" class="form-select">
                                <option value="">Cualquiera</option>
                                @foreach($tiposPropiedad as $tp)
                                    <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Ubicacion</label>
                            <select name="colonia_id" class="form-select">
                                <option value="">Cualquier ubicacion</option>
                                @foreach($colonias as $c)
                                    <option value="{{ $c->id }}">{{ $c->nombre }}, {{ $c->municipio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Precio minimo</label>
                            <input type="number" name="precio_min" class="form-control" placeholder="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Precio maximo</label>
                            <input type="number" name="precio_max" class="form-control" placeholder="Sin limite">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Habitaciones minimas</label>
                            <input type="number" name="habitaciones_min" class="form-control" min="0" max="10">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">M² construccion minimos</label>
                            <input type="number" name="metros_min" class="form-control" min="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning"><i class="fas fa-bell me-1"></i>Crear alerta</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmarEliminar(e, form) {
    e.preventDefault();
    confirmAction({ title: '¿Eliminar alerta?', danger: true }).then(r => { if (r.isConfirmed) form.submit(); });
    return false;
}
</script>
@endpush
@endsection
