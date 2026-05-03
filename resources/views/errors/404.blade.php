@extends('layouts.app')
@section('title', 'Pagina no encontrada')

@section('content')
<div style="min-height: 80vh; display:flex; align-items:center; padding: 2rem 0; background: linear-gradient(135deg, var(--bg-primary), var(--bg-tertiary)); position:relative; overflow:hidden">
    <!-- Blobs decorativos -->
    <div style="position:absolute; top:-100px; right:-100px; width:400px; height:400px; background: radial-gradient(circle, rgba(245,158,11,0.15), transparent 70%); border-radius:50%; animation: float-blob 8s ease-in-out infinite"></div>
    <div style="position:absolute; bottom:-100px; left:-100px; width:500px; height:500px; background: radial-gradient(circle, rgba(102,126,234,0.15), transparent 70%); border-radius:50%; animation: float-blob 10s ease-in-out infinite; animation-delay:-3s"></div>

    <div class="container text-center position-relative">
        <!-- SVG Animado: Casa con lupa buscando -->
        <svg width="280" height="280" viewBox="0 0 280 280" xmlns="http://www.w3.org/2000/svg" style="margin-bottom:2rem">
            <!-- Suelo -->
            <ellipse cx="140" cy="240" rx="100" ry="8" fill="rgba(0,0,0,0.05)">
                <animate attributeName="rx" values="100;90;100" dur="2s" repeatCount="indefinite"/>
            </ellipse>

            <!-- Casa (atras) -->
            <g transform="translate(60 80)" style="opacity:0.4">
                <rect x="20" y="60" width="120" height="100" rx="8" fill="#cbd5e1"/>
                <polygon points="0,60 80,0 160,60" fill="#94a3b8"/>
                <rect x="55" y="100" width="50" height="60" rx="6" fill="#64748b"/>
                <rect x="35" y="80" width="20" height="20" fill="#64748b"/>
                <rect x="105" y="80" width="20" height="20" fill="#64748b"/>
            </g>

            <!-- Casa principal (animada flotando) -->
            <g style="animation: house-float 4s ease-in-out infinite">
                <g transform="translate(80 100)">
                    <!-- Cuerpo -->
                    <rect x="10" y="50" width="100" height="80" rx="6" fill="url(#houseGrad)"/>
                    <!-- Techo -->
                    <polygon points="0,50 60,0 120,50" fill="#d97706"/>
                    <!-- Puerta -->
                    <rect x="48" y="85" width="24" height="45" rx="3" fill="#78350f"/>
                    <circle cx="65" cy="108" r="2" fill="#fbbf24"/>
                    <!-- Ventanas -->
                    <rect x="22" y="62" width="20" height="20" fill="#fef3c7" stroke="#92400e" stroke-width="2"/>
                    <rect x="78" y="62" width="20" height="20" fill="#fef3c7" stroke="#92400e" stroke-width="2"/>
                    <line x1="32" y1="62" x2="32" y2="82" stroke="#92400e" stroke-width="1"/>
                    <line x1="22" y1="72" x2="42" y2="72" stroke="#92400e" stroke-width="1"/>
                    <line x1="88" y1="62" x2="88" y2="82" stroke="#92400e" stroke-width="1"/>
                    <line x1="78" y1="72" x2="98" y2="72" stroke="#92400e" stroke-width="1"/>
                    <!-- Chimenea -->
                    <rect x="80" y="10" width="14" height="25" fill="#d97706"/>
                </g>

                <!-- Lupa buscando (animada moviendose) -->
                <g style="animation: search-move 3s ease-in-out infinite">
                    <circle cx="195" cy="140" r="30" fill="none" stroke="#0f172a" stroke-width="6"/>
                    <circle cx="195" cy="140" r="22" fill="rgba(255,255,255,0.3)"/>
                    <line x1="217" y1="162" x2="240" y2="185" stroke="#0f172a" stroke-width="6" stroke-linecap="round"/>
                    <text x="195" y="148" text-anchor="middle" font-family="Bricolage Grotesque" font-size="32" font-weight="800" fill="#0f172a">?</text>
                </g>
            </g>

            <defs>
                <linearGradient id="houseGrad" x1="0" y1="0" x2="0" y2="1">
                    <stop offset="0%" stop-color="#fbbf24"/>
                    <stop offset="100%" stop-color="#d97706"/>
                </linearGradient>
            </defs>
        </svg>

        <h1 style="font-size: clamp(5rem, 12vw, 9rem); font-weight: 900; line-height: 1; background: linear-gradient(135deg, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 0">
            404
        </h1>
        <h2 class="mt-3" data-aos="fade-up">¡Ups! No encontramos esta propiedad</h2>
        <p class="text-muted mb-4" data-aos="fade-up" data-aos-delay="100" style="max-width: 500px; margin: 0 auto; font-size:1.1rem">
            La pagina que buscas se mudo, fue vendida o nunca existio. Pero tenemos miles de propiedades esperandote.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ url('/') }}" class="btn btn-warning btn-lg">
                <i class="fas fa-home me-1"></i> Ir al inicio
            </a>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-outline-primary btn-lg">
                <i class="fas fa-search me-1"></i> Buscar propiedades
            </a>
        </div>
    </div>
</div>

<style>
@keyframes house-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
}
@keyframes search-move {
    0%, 100% { transform: translate(0, 0); }
    25% { transform: translate(-15px, -10px); }
    50% { transform: translate(10px, 15px); }
    75% { transform: translate(20px, -5px); }
}
</style>
@endsection
