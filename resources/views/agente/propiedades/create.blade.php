@extends('layouts.app')
@section('title', 'Nueva Propiedad')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-plus-circle"></i> Publicar Nueva Propiedad</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('agente.propiedades.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card mb-3">
            <div class="card-header">Informacion basica</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Titulo</label>
                    <input type="text" name="titulo" class="form-control" required value="{{ old('titulo') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripcion</label>
                    <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion') }}</textarea>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" required value="{{ old('precio') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Operacion</label>
                        <select name="tipo_operacion_id" class="form-select" required>
                            @foreach($tiposOperacion as $op)
                                <option value="{{ $op->id }}">{{ $op->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tipo de propiedad</label>
                        <select name="tipo_propiedad_id" class="form-select" required>
                            @foreach($tiposPropiedad as $tp)
                                <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Ubicacion</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Colonia</label>
                        <select name="colonia_id" class="form-select" required>
                            @foreach($colonias as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre }}, {{ $c->municipio->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Direccion</label>
                        <input type="text" name="direccion" class="form-control" required value="{{ old('direccion') }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Caracteristicas</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3"><label class="form-label">m² Construccion</label><input type="number" name="metros_construccion" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">m² Terreno</label><input type="number" name="metros_terreno" class="form-control"></div>
                    <div class="col-md-2"><label class="form-label">Habitaciones</label><input type="number" name="habitaciones" class="form-control" value="0"></div>
                    <div class="col-md-2"><label class="form-label">Banos</label><input type="number" name="banios" class="form-control" value="0"></div>
                    <div class="col-md-2"><label class="form-label">Estac.</label><input type="number" name="estacionamientos" class="form-control" value="0"></div>
                </div>
                <div class="mt-3">
                    <label class="form-label">Estado</label>
                    <select name="estado_propiedad_id" class="form-select">
                        @foreach($estadosPropiedad as $ep)
                            <option value="{{ $ep->id }}">{{ $ep->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mt-3">
                    <input type="checkbox" name="amueblado" class="form-check-input" id="amueblado">
                    <label class="form-check-label" for="amueblado">Amueblado</label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Amenidades</div>
            <div class="card-body">
                <div class="row">
                    @foreach($amenidades as $a)
                        <div class="col-md-3 mb-2">
                            <div class="form-check">
                                <input type="checkbox" name="amenidades[]" value="{{ $a->id }}" class="form-check-input" id="am{{ $a->id }}">
                                <label class="form-check-label" for="am{{ $a->id }}">{{ $a->nombre }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-images text-accent me-2"></i>Imagenes de la propiedad
                <small class="text-muted ms-2">(Maximo 10 imagenes, 5MB cada una)</small>
            </div>
            <div class="card-body">
                <div class="upload-zone position-relative" id="uploadZone"
                     style="border: 2px dashed var(--gray-200); border-radius: 16px; padding: 3rem; text-align: center; cursor: pointer; transition: all 0.3s; background: var(--bg-secondary)">
                    <i class="fas fa-cloud-upload-alt text-accent" style="font-size: 3.5rem; opacity: 0.7"></i>
                    <h5 class="mt-3 mb-2">Arrastra tus imagenes aqui</h5>
                    <p class="text-muted mb-2">o haz clic para seleccionarlas</p>
                    <small class="text-muted">JPG, PNG, WEBP - max 5MB cada una</small>
                    <input type="file" name="imagenes[]" id="fileInput" multiple accept="image/*" class="d-none">
                </div>
                <div id="previewContainer" class="row g-2 mt-3"></div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Publicar propiedad</button>
            <a href="{{ route('agente.propiedades.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>

    @push('scripts')
    <script>
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        let selectedFiles = [];

        uploadZone.addEventListener('click', () => fileInput.click());
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = 'var(--accent)';
            uploadZone.style.background = 'rgba(245,158,11,0.05)';
        });
        uploadZone.addEventListener('dragleave', () => {
            uploadZone.style.borderColor = 'var(--gray-200)';
            uploadZone.style.background = 'var(--bg-secondary)';
        });
        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = 'var(--gray-200)';
            uploadZone.style.background = 'var(--bg-secondary)';
            handleFiles(e.dataTransfer.files);
        });
        fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

        function handleFiles(files) {
            selectedFiles = Array.from(files).slice(0, 10);
            updateInput();
            renderPreviews();
        }

        function updateInput() {
            const dt = new DataTransfer();
            selectedFiles.forEach(f => dt.items.add(f));
            fileInput.files = dt.files;
        }

        function renderPreviews() {
            previewContainer.innerHTML = '';
            selectedFiles.forEach((file, i) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-3';
                    col.innerHTML = `
                        <div class="position-relative" style="border-radius:12px; overflow:hidden; aspect-ratio:1; border: 2px solid ${i === 0 ? 'var(--accent)' : 'var(--gray-200)'}">
                            <img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover">
                            ${i === 0 ? '<span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">Principal</span>' : ''}
                            <button type="button" onclick="removeFile(${i})" class="position-absolute top-0 end-0 m-2 btn btn-danger btn-sm" style="border-radius:50%; width:30px; height:30px; padding:0">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    previewContainer.appendChild(col);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            updateInput();
            renderPreviews();
        }
    </script>
    @endpush
</div>
@endsection
