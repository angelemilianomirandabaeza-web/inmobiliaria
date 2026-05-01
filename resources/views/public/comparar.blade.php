@extends('layouts.app')
@section('title', 'Comparar Propiedades')

@section('content')
<div class="container py-4">
    <h2 class="mb-4"><i class="fas fa-balance-scale"></i> Comparador de Propiedades</h2>

    @if($propiedades->isEmpty())
        <div class="alert alert-info">
            <h5>Como usar el comparador</h5>
            <p class="mb-0">Agrega IDs de propiedades en la URL: <code>/comparar?ids=1,2,3</code> (hasta 3 propiedades).</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-primary">
                    <tr>
                        <th>Caracteristica</th>
                        @foreach($propiedades as $p)
                            <th class="text-center">{{ $p->titulo }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Imagen</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center"><img src="{{ $p->imagenPrincipal->url_imagen }}" style="height:120px"></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Precio</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center price-tag">${{ number_format($p->precio, 0) }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Tipo</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->tipoPropiedad->nombre }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Operacion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->tipoOperacion->nombre }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Ubicacion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->colonia->nombre }}, {{ $p->colonia->municipio->nombre }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Habitaciones</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->habitaciones }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Banos</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->banios }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Estacionamientos</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->estacionamientos }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>m² Construccion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->metros_construccion ?? '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>m² Terreno</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center">{{ $p->metros_terreno ?? '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Amenidades</strong></td>
                        @foreach($propiedades as $p)
                            <td>
                                <ul class="small mb-0">
                                    @foreach($p->amenidades as $a)
                                        <li>{{ $a->nombre }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td><strong>Accion</strong></td>
                        @foreach($propiedades as $p)
                            <td class="text-center"><a href="{{ route('propiedades.show', $p) }}" class="btn btn-primary btn-sm">Ver detalle</a></td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
