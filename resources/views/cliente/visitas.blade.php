@extends('layouts.app')
@section('title', 'Mis visitas')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <h1 class="mb-2" style="font-size:2rem"><i class="fas fa-calendar-check me-2"></i>Mis visitas</h1>
        <p class="mb-0 opacity-75">Gestiona tus visitas agendadas a propiedades</p>
    </div>
</div>

<div class="container py-4">
    @if($visitas->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-calendar-times text-muted" style="font-size:5rem; opacity:0.3"></i>
            <h4 class="mt-3">No tienes visitas agendadas</h4>
            <p class="text-muted mb-3">Cuando agendes una visita aparecera aqui</p>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary">Explorar propiedades</a>
        </div>
    @else
        <div class="row g-4">
            @foreach($visitas as $v)
                <div class="col-md-6">
                    <div class="card" data-aos="fade-up">
                        <div class="card-body p-4">
                            <div class="d-flex gap-3 mb-3">
                                <div class="text-center" style="min-width:80px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); padding: 1rem; border-radius: 14px; color:white">
                                    <small class="text-uppercase d-block" style="font-size:0.7rem; opacity:0.9">{{ $v->fecha_visita->format('M') }}</small>
                                    <h2 class="mb-0 text-white" style="font-weight:800">{{ $v->fecha_visita->format('d') }}</h2>
                                    <small style="font-size:0.7rem; opacity:0.9">{{ $v->hora_inicio }}</small>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ Str::limit($v->propiedad->titulo, 50) }}</h6>
                                    <p class="text-muted small mb-2"><i class="fas fa-map-marker-alt text-accent me-1"></i>{{ $v->propiedad->colonia->nombre }}</p>
                                    <div>
                                        <span class="badge" style="background: {{ $v->estadoVisita->nombre === 'Cancelada' ? 'var(--danger)' : ($v->estadoVisita->nombre === 'Realizada' ? 'var(--success)' : ($v->estadoVisita->nombre === 'Confirmada' ? 'var(--success)' : 'var(--accent)')) }}; color:white">{{ $v->estadoVisita->nombre }}</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <p class="small text-muted mb-3">
                                <i class="fas fa-user-tie me-1 text-accent"></i>Agente: <strong>{{ $v->agente->usuario->name }}</strong>
                            </p>
                            @if($v->notas_cliente)
                                <p class="small bg-light p-2 rounded"><strong>Tus notas:</strong> {{ $v->notas_cliente }}</p>
                            @endif
                            <div class="d-flex gap-2">
                                <a href="{{ route('propiedades.show', $v->propiedad) }}" class="btn btn-outline-primary btn-sm flex-grow-1"><i class="fas fa-eye me-1"></i>Ver propiedad</a>
                                @if(!in_array($v->estadoVisita->nombre, ['Cancelada', 'Realizada']))
                                    <form method="POST" action="{{ route('cliente.visitas.destroy', $v) }}" onsubmit="return confirmarCancelar(event, this)" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm"><i class="fas fa-times me-1"></i>Cancelar</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-4 d-flex justify-content-center">{{ $visitas->links() }}</div>
    @endif
</div>

@push('scripts')
<script>
function confirmarCancelar(e, form) {
    e.preventDefault();
    confirmAction({
        title: '¿Cancelar visita?',
        text: 'No podras revertir esta accion',
        icon: 'warning',
        confirmText: 'Si, cancelar',
        danger: true
    }).then(r => { if (r.isConfirmed) form.submit(); });
    return false;
}
</script>
@endpush
@endsection
