@extends('layouts.app')
@section('title', 'Restablecer contrasena')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; padding: 3rem 0; background: linear-gradient(135deg, var(--bg-primary), var(--bg-tertiary))">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow" data-aos="fade-up">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="logo-icon mx-auto mb-3" style="width:60px;height:60px;background:linear-gradient(135deg,var(--accent),var(--accent-dark));border-radius:14px;display:inline-flex;align-items:center;justify-content:center">
                                <i class="fas fa-lock text-white fa-2x"></i>
                            </div>
                            <h2 class="mb-1">Nueva contrasena</h2>
                            <p class="text-muted">Crea una contrasena segura</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required value="{{ $email ?? old('email') }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nueva contrasena</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Confirmar contrasena</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 btn-lg">Restablecer contrasena</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
