@extends('layouts.app')
@section('title', 'Acceso denegado')

@section('content')
<div style="min-height: 80vh; display:flex; align-items:center; padding: 2rem 0">
    <div class="container text-center">
        <div style="font-size:6rem; color: var(--accent)"><i class="fas fa-lock"></i></div>
        <h1 class="display-4 mt-3">403 - Acceso denegado</h1>
        <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'No tienes permiso para acceder a esta seccion.' }}</p>
        <a href="{{ url('/') }}" class="btn btn-warning btn-lg">
            <i class="fas fa-home me-1"></i> Volver al inicio
        </a>
    </div>
</div>
@endsection
