@extends('layouts.app')
@section('title', 'Iniciar Sesion')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; padding: 3rem 0; background: linear-gradient(135deg, var(--gray-50), var(--gray-100))">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="logo-icon mx-auto mb-3" style="width:60px;height:60px;background:linear-gradient(135deg,var(--accent),var(--accent-dark));border-radius:14px;display:inline-flex;align-items:center;justify-content:center">
                                <i class="fas fa-home text-white fa-2x"></i>
                            </div>
                            <h2 class="mb-1">Bienvenido de nuevo</h2>
                            <p class="text-muted">Inicia sesion para continuar</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Correo electronico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" required placeholder="tu@email.com" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contrasena</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-lock text-muted"></i></span>
                                    <input type="password" name="password" class="form-control" required placeholder="••••••••">
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                                    <label class="form-check-label small" for="remember">Recordarme</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="small text-accent text-decoration-none">¿Olvidaste tu contrasena?</a>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg">Iniciar Sesion <i class="fas fa-arrow-right ms-1"></i></button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center mb-0">¿No tienes cuenta? <a href="{{ route('register') }}" class="text-accent fw-semibold text-decoration-none">Registrate aqui</a></p>
                    </div>
                </div>

                <div class="mt-3 p-3 rounded-3 small" style="background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2)" data-aos="fade-up" data-aos-delay="100">
                    <strong class="d-block mb-2"><i class="fas fa-info-circle me-1"></i>Cuentas de prueba</strong>
                    <div class="row g-2">
                        <div class="col-12"><code class="small">admin@inmobiliaria.com</code> <span class="badge bg-secondary">admin</span></div>
                        <div class="col-12"><code class="small">carlos@inmobiliaria.com</code> <span class="badge bg-info">agente</span></div>
                        <div class="col-12"><code class="small">ana@cliente.com</code> <span class="badge bg-success">cliente</span></div>
                        <div class="col-12 mt-2 text-muted">Password para todas: <code>password</code></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
