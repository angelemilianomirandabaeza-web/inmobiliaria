@extends('layouts.app')
@section('title', 'Recuperar contrasena')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; padding: 3rem 0; background: linear-gradient(135deg, var(--bg-primary), var(--bg-tertiary))">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="logo-icon mx-auto mb-3" style="width:60px;height:60px;background:linear-gradient(135deg,var(--accent),var(--accent-dark));border-radius:14px;display:inline-flex;align-items:center;justify-content:center">
                                <i class="fas fa-key text-white fa-2x"></i>
                            </div>
                            <h2 class="mb-1">Recuperar contrasena</h2>
                            <p class="text-muted">Te enviaremos un correo con instrucciones</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger"><i class="fas fa-exclamation-circle me-1"></i>{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tu email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" name="email" class="form-control" required placeholder="tu@email.com" value="{{ old('email') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="fas fa-paper-plane me-1"></i> Enviar enlace</button>
                        </form>

                        <hr class="my-4">
                        <p class="text-center mb-0">¿Recordaste tu contrasena? <a href="{{ route('login') }}" class="text-accent fw-semibold text-decoration-none">Inicia sesion</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
