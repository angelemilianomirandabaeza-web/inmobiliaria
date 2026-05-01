@extends('layouts.app')
@section('title', 'Registrarse')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; padding: 3rem 0; background: linear-gradient(135deg, var(--gray-50), var(--gray-100))">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="logo-icon mx-auto mb-3" style="width:60px;height:60px;background:linear-gradient(135deg,var(--accent),var(--accent-dark));border-radius:14px;display:inline-flex;align-items:center;justify-content:center">
                                <i class="fas fa-user-plus text-white fa-2x"></i>
                            </div>
                            <h2 class="mb-1">Crear cuenta</h2>
                            <p class="text-muted">Unete a la comunidad InmoTech</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}" placeholder="Juan Perez">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}" placeholder="tu@email.com">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefono <span class="text-muted small">(opcional)</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-phone text-muted"></i></span>
                                    <input type="tel" name="telefono" class="form-control" value="{{ old('telefono') }}" placeholder="55 1234 5678">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contrasena</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control" required placeholder="Minimo 8 caracteres">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Confirmar contrasena</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-check-double text-muted"></i></span>
                                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Repite la contrasena">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 btn-lg">Crear mi cuenta <i class="fas fa-arrow-right ms-1"></i></button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center mb-0">¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-accent fw-semibold text-decoration-none">Inicia sesion</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
