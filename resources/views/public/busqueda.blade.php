@extends('layouts.app')
@section('title', 'Buscar Propiedades')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <h1 class="mb-2" style="font-size:2.25rem">Encuentra tu propiedad ideal</h1>
        <p class="mb-0 opacity-75">{{ $propiedades->total() }} propiedades disponibles</p>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <aside class="col-lg-3 mb-4">
            <div class="card sticky-top" style="top: 90px">
                <div class="card-body">
                    <h6 class="d-flex align-items-center mb-3" style="font-weight:700">
                        <i class="fas fa-sliders-h text-accent me-2"></i> Filtros de busqueda
                    </h6>
                    <form method="GET" action="{{ route('propiedades.buscar') }}">
                        <div class="mb-3">
                            <label class="form-label small">Operacion</label>
                            <select name="tipo_operacion_id" class="form-select form-select-sm">
                                <option value="">Todas</option>
                                @foreach($tiposOperacion as $op)
                                    <option value="{{ $op->id }}" {{ request('tipo_operacion_id') == $op->id ? 'selected' : '' }}>{{ $op->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Tipo de propiedad</label>
                            <select name="tipo_propiedad_id" class="form-select form-select-sm">
                                <option value="">Todos</option>
                                @foreach($tiposPropiedad as $tp)
                                    <option value="{{ $tp->id }}" {{ request('tipo_propiedad_id') == $tp->id ? 'selected' : '' }}>{{ $tp->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Ubicacion</label>
                            <select name="colonia_id" class="form-select form-select-sm">
                                <option value="">Todas las colonias</option>
                                @foreach($colonias as $c)
                                    <option value="{{ $c->id }}" {{ request('colonia_id') == $c->id ? 'selected' : '' }}>{{ $c->nombre }}, {{ $c->municipio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small">Precio min</label>
                                <input type="number" name="precio_min" class="form-control form-control-sm" placeholder="0" value="{{ request('precio_min') }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label small">Precio max</label>
                                <input type="number" name="precio_max" class="form-control form-control-sm" placeholder="∞" value="{{ request('precio_max') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Habitaciones</label>
                            <div class="btn-group w-100" role="group">
                                @for($i = 1; $i <= 4; $i++)
                                    <input type="radio" class="btn-check" name="habitaciones" value="{{ $i }}" id="hab{{ $i }}" {{ request('habitaciones') == $i ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-primary" for="hab{{ $i }}">{{ $i }}+</label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Banos</label>
                            <div class="btn-group w-100" role="group">
                                @for($i = 1; $i <= 4; $i++)
                                    <input type="radio" class="btn-check" name="banios" value="{{ $i }}" id="ban{{ $i }}" {{ request('banios') == $i ? 'checked' : '' }}>
                                    <label class="btn btn-sm btn-outline-primary" for="ban{{ $i }}">{{ $i }}+</label>
                                @endfor
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Aplicar filtros</button>
                        <a href="{{ route('propiedades.buscar') }}" class="btn btn-link w-100 mt-2 text-muted">Limpiar todo</a>
                    </form>
                </div>
            </div>
        </aside>

        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-muted">Mostrando <strong class="text-dark">{{ $propiedades->count() }}</strong> de <strong class="text-dark">{{ $propiedades->total() }}</strong> resultados</p>
                <form method="GET" class="d-flex">
                    @foreach(request()->except('orden', 'page') as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach
                    <select name="orden" class="form-select form-select-sm" style="min-width:200px" onchange="this.form.submit()">
                        <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Mas recientes</option>
                        <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                        <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                        <option value="destacadas" {{ request('orden') == 'destacadas' ? 'selected' : '' }}>Destacadas primero</option>
                    </select>
                </form>
            </div>

            @if($propiedades->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-search-minus text-muted" style="font-size: 4rem; opacity: 0.3"></i>
                    <h4 class="mt-3">No se encontraron propiedades</h4>
                    <p class="text-muted">Intenta ajustar tus filtros para ver mas resultados.</p>
                    <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary mt-2">Ver todas las propiedades</a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($propiedades as $p)
                        <div class="col-md-6 col-lg-4">
                            @include('public.partials.property_card', ['p' => $p])
                        </div>
                    @endforeach
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    {{ $propiedades->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
