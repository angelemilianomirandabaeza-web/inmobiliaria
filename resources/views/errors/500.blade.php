@extends('layouts.app')
@section('title', 'Error del servidor')

@section('content')
<div style="min-height: 80vh; display:flex; align-items:center; padding: 2rem 0">
    <div class="container text-center">
        <div style="font-size:6rem; color: var(--danger)"><i class="fas fa-bug"></i></div>
        <h1 class="display-4 mt-3">Algo salio mal</h1>
        <p class="text-muted mb-4">Estamos trabajando para resolverlo. Por favor intenta mas tarde.</p>
        <a href="{{ url('/') }}" class="btn btn-warning btn-lg">
            <i class="fas fa-home me-1"></i> Volver al inicio
        </a>
    </div>
</div>
@endsection
