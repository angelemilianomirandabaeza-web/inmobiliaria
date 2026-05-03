@extends('layouts.app')
@section('title', 'Mi perfil')

@section('content')
<div style="background: linear-gradient(135deg, var(--primary), var(--primary-light)); padding: 3rem 0 2rem; color: white">
    <div class="container">
        <h1 class="mb-2" style="font-size:2rem"><i class="fas fa-user-cog me-2"></i>Mi perfil</h1>
        <p class="mb-0 opacity-75">Administra tu informacion personal</p>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card text-center" data-aos="fade-right">
                <div class="card-body p-4">
                    <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white"
                         style="width:120px; height:120px; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); font-size: 3rem; font-weight:800; box-shadow: 0 15px 40px rgba(245,158,11,0.4)">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    <span class="badge bg-warning text-dark">{{ ucfirst($user->rol->nombre ?? 'usuario') }}</span>
                    <hr>
                    <div class="text-start small">
                        <p class="mb-2"><i class="fas fa-calendar text-accent me-2"></i>Miembro desde: <strong>{{ $user->created_at->format('M Y') }}</strong></p>
                        @if($user->telefono)
                            <p class="mb-0"><i class="fas fa-phone text-accent me-2"></i>{{ $user->telefono }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-3" data-aos="fade-left">
                <div class="card-header"><i class="fas fa-user-edit text-accent me-2"></i>Informacion personal</div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf @method('PATCH')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Nombre completo</label>
                                <input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Telefono</label>
                                <input type="tel" name="telefono" class="form-control" value="{{ old('telefono', $user->telefono) }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save me-1"></i>Guardar cambios</button>
                    </form>
                </div>
            </div>

            <div class="card" data-aos="fade-left" data-aos-delay="100">
                <div class="card-header"><i class="fas fa-key text-accent me-2"></i>Cambiar contrasena</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf @method('PATCH')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Contrasena actual</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nueva contrasena</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirmar nueva contrasena</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning mt-3"><i class="fas fa-shield-alt me-1"></i>Actualizar contrasena</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
