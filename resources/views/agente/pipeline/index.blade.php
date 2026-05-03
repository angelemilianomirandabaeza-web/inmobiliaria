@extends('layouts.app')
@section('title', 'Pipeline de ventas')

@push('styles')
<style>
.kanban-board {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
    padding: 1rem 0;
    min-height: 70vh;
}
.kanban-column {
    background: var(--bg-tertiary);
    border-radius: 16px;
    padding: 1rem;
    min-width: 280px;
    width: 280px;
    flex-shrink: 0;
}
.kanban-column-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0.25rem;
    margin-bottom: 1rem;
    border-bottom: 2px solid var(--border-color);
}
.kanban-column-title { font-weight: 700; font-size: 0.95rem; }
.kanban-column-count {
    background: white;
    color: var(--primary);
    padding: 2px 10px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 700;
    border: 1px solid var(--border-color);
}
[data-theme="dark"] .kanban-column-count { background: var(--card-bg); color: var(--text-primary); }
.kanban-cards { min-height: 100px; }
.kanban-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 0.85rem;
    margin-bottom: 0.75rem;
    cursor: grab;
    transition: all 0.2s;
    position: relative;
}
.kanban-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    border-color: var(--accent);
}
.kanban-card.dragging { opacity: 0.5; cursor: grabbing; }
.kanban-cards.drag-over { background: rgba(245,158,11,0.1); border-radius: 8px; min-height: 80px; }

.etapa-1 { border-top: 4px solid #6b7280; }
.etapa-2 { border-top: 4px solid #3b82f6; }
.etapa-3 { border-top: 4px solid #8b5cf6; }
.etapa-4 { border-top: 4px solid #f59e0b; }
.etapa-5 { border-top: 4px solid #ec4899; }
.etapa-6 { border-top: 4px solid #10b981; }
</style>
@endpush

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h1 class="mb-2" style="font-size:2rem"><i class="fas fa-stream me-2"></i>Pipeline de ventas</h1>
            <p class="mb-0 opacity-75">Arrastra los leads entre etapas para actualizar su estado</p>
        </div>
        <button class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#nuevoLeadModal">
            <i class="fas fa-plus me-1"></i> Agregar lead
        </button>
    </div>
</div>

<div class="container-fluid py-3 px-4">
    <div class="kanban-board" id="kanbanBoard">
        @foreach($etapas as $etapa)
            <div class="kanban-column etapa-{{ $etapa->orden }}" data-etapa-id="{{ $etapa->id }}">
                <div class="kanban-column-header">
                    <span class="kanban-column-title">{{ $etapa->nombre }}</span>
                    <span class="kanban-column-count">{{ $pipelineByEtapa[$etapa->id]->count() }}</span>
                </div>
                <div class="kanban-cards" data-etapa-id="{{ $etapa->id }}">
                    @foreach($pipelineByEtapa[$etapa->id] as $p)
                        <div class="kanban-card" draggable="true" data-id="{{ $p->id }}">
                            <div class="d-flex gap-2 mb-2">
                                <img src="{{ $p->propiedad->imagenPrincipal->url_imagen ?? 'https://picsum.photos/100' }}"
                                     style="width:50px; height:50px; object-fit:cover; border-radius:8px">
                                <div class="flex-grow-1" style="min-width:0">
                                    <p class="mb-0 small fw-bold text-truncate">{{ Str::limit($p->propiedad->titulo, 30) }}</p>
                                    <small class="text-muted">${{ number_format($p->propiedad->precio, 0) }}</small>
                                </div>
                            </div>
                            <p class="mb-2 small">
                                <i class="fas fa-user text-accent me-1"></i>
                                {{ $p->cliente->name }}
                            </p>
                            @if($p->notas)
                                <p class="small text-muted mb-2" style="font-size:0.75rem">{{ Str::limit($p->notas, 60) }}</p>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted" style="font-size:0.7rem">{{ $p->updated_at->diffForHumans() }}</small>
                                <form method="POST" action="{{ route('agente.pipeline.destroy', $p) }}" onsubmit="return confirmEliminar(event, this)">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-link text-danger p-0" style="font-size:0.75rem"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Modal Nuevo Lead -->
<div class="modal fade" id="nuevoLeadModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px; border:none">
            <div class="modal-header border-0">
                <h5 class="modal-title"><i class="fas fa-user-plus text-accent me-2"></i>Agregar lead al pipeline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('agente.pipeline.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Propiedad</label>
                        <select name="propiedad_id" class="form-select" required>
                            <option value="">Selecciona...</option>
                            @foreach($misPropiedades as $p)
                                <option value="{{ $p->id }}">{{ Str::limit($p->titulo, 50) }} - ${{ number_format($p->precio, 0) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cliente interesado</label>
                        <select name="cliente_id" class="form-select" required>
                            <option value="">Selecciona...</option>
                            @foreach($clientes as $c)
                                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas <small class="text-muted">(opcional)</small></label>
                        <textarea name="notas" class="form-control" rows="3" placeholder="Detalles del prospecto..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">Agregar al pipeline</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// DRAG & DROP del Kanban
let draggedCard = null;

document.querySelectorAll('.kanban-card').forEach(card => {
    card.addEventListener('dragstart', (e) => {
        draggedCard = card;
        card.classList.add('dragging');
    });
    card.addEventListener('dragend', () => {
        card.classList.remove('dragging');
        document.querySelectorAll('.kanban-cards').forEach(c => c.classList.remove('drag-over'));
    });
});

document.querySelectorAll('.kanban-cards').forEach(zone => {
    zone.addEventListener('dragover', (e) => {
        e.preventDefault();
        zone.classList.add('drag-over');
    });
    zone.addEventListener('dragleave', () => {
        zone.classList.remove('drag-over');
    });
    zone.addEventListener('drop', async (e) => {
        e.preventDefault();
        zone.classList.remove('drag-over');
        if (!draggedCard) return;

        const etapaId = zone.dataset.etapaId;
        const pipelineId = draggedCard.dataset.id;
        zone.appendChild(draggedCard);

        // Actualizar contadores
        document.querySelectorAll('.kanban-column').forEach(col => {
            const count = col.querySelectorAll('.kanban-card').length;
            col.querySelector('.kanban-column-count').textContent = count;
        });

        try {
            const res = await fetch(`/agente/pipeline/${pipelineId}/etapa`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ etapa_id: etapaId })
            });
            if (res.ok) toast.success('Etapa actualizada');
            else toast.error('Error al actualizar');
        } catch (err) {
            toast.error('Error de conexion');
        }
    });
});

function confirmEliminar(e, form) {
    e.preventDefault();
    confirmAction({ title: '¿Eliminar lead?', danger: true }).then(r => { if (r.isConfirmed) form.submit(); });
    return false;
}
</script>
@endpush
@endsection
