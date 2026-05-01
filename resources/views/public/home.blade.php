@extends('layouts.app')
@section('title', 'Inicio')

@section('content')
<!-- HERO ESPECTACULAR -->
<section class="hero-spectacular">
    <div class="hero-mesh"></div>
    <div class="hero-grid-bg"></div>
    <div class="hero-blob hero-blob-1"></div>
    <div class="hero-blob hero-blob-2"></div>
    <div class="hero-blob hero-blob-3"></div>

    <div class="container hero-content">
        <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
                <span class="hero-badge" data-aos="fade-down">
                    <span class="pulse-dot"></span>
                    +{{ $totalPropiedades }} propiedades disponibles ahora
                </span>
                <h1 class="hero-title" data-aos="fade-up">
                    Encuentra tu<br>
                    <span class="gradient-text"><span id="typed"></span></span>
                </h1>
                <p class="lead opacity-75 mb-4" style="max-width:600px; font-size:1.2rem" data-aos="fade-up" data-aos-delay="100">
                    Tecnologia de punta combinada con experiencia inmobiliaria. Miles de propiedades verificadas te esperan.
                </p>

                <form action="{{ route('propiedades.buscar') }}" method="GET" class="hero-search-glass" data-aos="fade-up" data-aos-delay="200">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <select name="tipo_operacion_id" class="form-select form-select-lg">
                                <option value="">Operacion</option>
                                @foreach($tiposOperacion as $op)
                                    <option value="{{ $op->id }}">{{ $op->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="tipo_propiedad_id" class="form-select form-select-lg">
                                <option value="">Tipo</option>
                                @foreach($tiposPropiedad as $tp)
                                    <option value="{{ $tp->id }}">{{ $tp->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="busqueda" class="form-control form-control-lg" placeholder="Ciudad, colonia...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-warning btn-lg w-100"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>

                <div class="d-flex gap-4 mt-4 flex-wrap" data-aos="fade-up" data-aos-delay="300">
                    <div class="d-flex align-items-center gap-2">
                        <div class="d-flex">
                            <span class="rounded-circle border border-2 border-white" style="width:32px;height:32px;background:linear-gradient(135deg,#667eea,#764ba2);margin-right:-10px"></span>
                            <span class="rounded-circle border border-2 border-white" style="width:32px;height:32px;background:linear-gradient(135deg,#f093fb,#f5576c);margin-right:-10px"></span>
                            <span class="rounded-circle border border-2 border-white" style="width:32px;height:32px;background:linear-gradient(135deg,#4facfe,#00f2fe);margin-right:-10px"></span>
                            <span class="rounded-circle border border-2 border-white d-flex align-items-center justify-content-center text-white fw-bold" style="width:32px;height:32px;background:var(--accent);font-size:0.7rem">+5K</span>
                        </div>
                        <small class="opacity-75">Mas de 5,000 clientes felices</small>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <small class="ms-2 opacity-75">4.9 / 5.0</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block position-relative" style="height:500px">
                <!-- Card flotante 1 -->
                <div class="floating-card" style="top:20px; left:20px" data-aos="zoom-in" data-aos-delay="400">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width:50px;height:50px;background:linear-gradient(135deg,#10b981,#059669)">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Propiedad verificada</small>
                        <strong class="text-dark">100% confiable</strong>
                    </div>
                </div>

                <!-- Card flotante 2 (centro principal) -->
                <div class="floating-card delay-1" style="top:160px; right:0; min-width:280px" data-aos="zoom-in" data-aos-delay="500">
                    <img src="https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=200&q=80" style="width:80px;height:80px;object-fit:cover;border-radius:12px">
                    <div>
                        <small class="text-muted d-block">Casa moderna</small>
                        <strong class="text-dark d-block" style="color:var(--primary) !important">$12,500,000</strong>
                        <small style="color:var(--accent)">⭐ Destacada</small>
                    </div>
                </div>

                <!-- Card flotante 3 -->
                <div class="floating-card delay-2" style="bottom:50px; left:40px; min-width:240px" data-aos="zoom-in" data-aos-delay="600">
                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white" style="width:50px;height:50px;background:linear-gradient(135deg,#f59e0b,#d97706)">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Inversion segura</small>
                        <strong class="text-dark">+12% anual</strong>
                    </div>
                </div>

                <!-- Imagen de fondo casa -->
                <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:280px; height:380px; border-radius:24px; overflow:hidden; box-shadow:0 30px 80px rgba(0,0,0,0.5); border:8px solid rgba(255,255,255,0.1)" data-aos="zoom-in" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=600&q=80" style="width:100%;height:100%;object-fit:cover">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MARQUEE DE MARCAS / CARACTERISTICAS -->
<section style="padding:2rem 0; background:white; border-bottom: 1px solid var(--gray-200)">
    <div class="container-fluid p-0">
        <div class="text-center mb-3">
            <small class="text-muted" style="letter-spacing:0.15em; text-transform:uppercase; font-weight:600">Confian en nosotros</small>
        </div>
        <div class="marquee">
            <div class="marquee-track">
                <div class="marquee-item"><i class="fas fa-shield-alt text-accent"></i> Seguridad SSL</div>
                <div class="marquee-item"><i class="fas fa-medal text-accent"></i> Premio 2025</div>
                <div class="marquee-item"><i class="fas fa-handshake text-accent"></i> +500 Agencias</div>
                <div class="marquee-item"><i class="fas fa-globe text-accent"></i> Cobertura Nacional</div>
                <div class="marquee-item"><i class="fas fa-clock text-accent"></i> Atencion 24/7</div>
                <div class="marquee-item"><i class="fas fa-users text-accent"></i> +5,000 Clientes</div>
                <!-- Duplicado para loop infinito -->
                <div class="marquee-item"><i class="fas fa-shield-alt text-accent"></i> Seguridad SSL</div>
                <div class="marquee-item"><i class="fas fa-medal text-accent"></i> Premio 2025</div>
                <div class="marquee-item"><i class="fas fa-handshake text-accent"></i> +500 Agencias</div>
                <div class="marquee-item"><i class="fas fa-globe text-accent"></i> Cobertura Nacional</div>
                <div class="marquee-item"><i class="fas fa-clock text-accent"></i> Atencion 24/7</div>
                <div class="marquee-item"><i class="fas fa-users text-accent"></i> +5,000 Clientes</div>
            </div>
        </div>
    </div>
</section>

<!-- STATS CON CONTADORES -->
<section style="background:white">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3 col-6" data-aos="fade-up">
                <div class="counter-number" data-target="{{ $totalPropiedades }}">0</div>
                <p class="text-muted fw-semibold mt-2">Propiedades activas</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="100">
                <div class="counter-number" data-target="50">0</div>
                <p class="text-muted fw-semibold mt-2">Agentes verificados</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="200">
                <div class="counter-number" data-target="15">0</div>
                <p class="text-muted fw-semibold mt-2">Ciudades cubiertas</p>
            </div>
            <div class="col-md-3 col-6" data-aos="fade-up" data-aos-delay="300">
                <div class="counter-number" data-target="98">0</div>
                <p class="text-muted fw-semibold mt-2">Satisfaccion %</p>
            </div>
        </div>
    </div>
</section>

<!-- TIPOS DE PROPIEDAD -->
<section style="background: var(--gray-50)">
    <div class="container">
        <div class="text-center" style="margin-bottom:3rem">
            <span class="section-tag" data-aos="fade-up">Categorias</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="50">Explora por <span class="text-gradient">tipo</span></h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Encuentra exactamente lo que buscas</p>
        </div>
        <div class="row g-3">
            @php
                $iconos = ['Casa' => 'fa-house', 'Departamento' => 'fa-building', 'Terreno' => 'fa-mountain', 'Local Comercial' => 'fa-store', 'Oficina' => 'fa-briefcase', 'Bodega' => 'fa-warehouse', 'Rancho' => 'fa-tractor'];
                $colores = ['#667eea', '#f093fb', '#4facfe', '#43e97b', '#fa709a', '#feca57', '#ff9ff3'];
            @endphp
            @foreach($tiposPropiedad as $i => $tp)
                <div class="col-6 col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ $i * 60 }}">
                    <a href="{{ route('propiedades.buscar', ['tipo_propiedad_id' => $tp->id]) }}"
                       data-tilt
                       class="d-block text-decoration-none p-4 rounded-4 text-center"
                       style="color: var(--gray-900); background: white; border: 2px solid transparent; transition: all 0.4s; position:relative; overflow:hidden">
                        <div style="position:absolute; top:-20px; right:-20px; width:80px; height:80px; background: {{ $colores[$i % 7] }}22; border-radius:50%"></div>
                        <i class="fas {{ $iconos[$tp->nombre] ?? 'fa-home' }} fa-2x mb-3" style="color: {{ $colores[$i % 7] }}"></i>
                        <p class="mb-0 fw-bold" style="font-size:1.05rem">{{ $tp->nombre }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- DESTACADAS -->
@if($destacadas->count() > 0)
<section style="background:white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-end mb-5 flex-wrap">
            <div data-aos="fade-right">
                <span class="section-tag">Lo mejor de lo mejor</span>
                <h2 class="section-title">
                    <span class="text-gradient">Propiedades</span> destacadas
                </h2>
                <p class="text-muted mb-0" style="font-size:1.05rem">Las mas exclusivas seleccionadas para ti</p>
            </div>
            <a href="{{ route('propiedades.buscar', ['orden' => 'destacadas']) }}" class="btn btn-outline-primary mt-3 mt-md-0" data-aos="fade-left">
                Ver todas <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($destacadas as $i => $p)
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    @include('public.partials.property_card', ['p' => $p])
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- COMO FUNCIONA -->
<section style="background: var(--gray-50); position:relative; overflow:hidden">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:600px; height:600px; background: radial-gradient(circle, rgba(245,158,11,0.08), transparent 70%); pointer-events:none"></div>
    <div class="container position-relative">
        <div class="text-center" style="margin-bottom:4rem">
            <span class="section-tag" data-aos="fade-up">Proceso simple</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="50">Como <span class="text-gradient">funciona</span></h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">4 pasos para encontrar tu hogar ideal</p>
        </div>
        <div class="row g-4">
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                <div class="step-card" data-tilt>
                    <div class="step-number">1</div>
                    <div class="step-icon"><i class="fas fa-search"></i></div>
                    <h5>Busca</h5>
                    <p class="text-muted mb-0">Filtra por ciudad, presupuesto, tipo de propiedad y caracteristicas que buscas.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                <div class="step-card" data-tilt>
                    <div class="step-number">2</div>
                    <div class="step-icon" style="background: rgba(102,126,234,0.1); color: #667eea"><i class="fas fa-heart"></i></div>
                    <h5>Guarda</h5>
                    <p class="text-muted mb-0">Anade tus favoritas a tu lista personal y comparalas lado a lado.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                <div class="step-card" data-tilt>
                    <div class="step-number">3</div>
                    <div class="step-icon" style="background: rgba(16,185,129,0.1); color: var(--success)"><i class="fas fa-calendar-check"></i></div>
                    <h5>Visita</h5>
                    <p class="text-muted mb-0">Agenda visitas directamente con el agente y recorre la propiedad en persona.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                <div class="step-card" data-tilt>
                    <div class="step-number">4</div>
                    <div class="step-icon" style="background: rgba(236,72,153,0.1); color: #ec4899"><i class="fas fa-key"></i></div>
                    <h5>Concreta</h5>
                    <p class="text-muted mb-0">Cierra el trato con seguridad legal y mudate a tu nuevo hogar.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- RECIENTES -->
<section style="background:white">
    <div class="container">
        <div class="text-center" style="margin-bottom:3rem">
            <span class="section-tag" data-aos="fade-up">Lo mas nuevo</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="50">Recien <span class="text-gradient">publicadas</span></h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Las propiedades mas frescas del mercado</p>
        </div>
        <div class="row g-4">
            @foreach($recientes as $i => $p)
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $i * 75 }}">
                    @include('public.partials.property_card', ['p' => $p])
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-primary btn-lg">
                Ver todas las propiedades <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- TESTIMONIOS -->
<section style="background: linear-gradient(135deg, var(--gray-50), var(--gray-100))">
    <div class="container">
        <div class="text-center" style="margin-bottom:3rem">
            <span class="section-tag" data-aos="fade-up">Testimonios</span>
            <h2 class="section-title" data-aos="fade-up" data-aos-delay="50">Lo que dicen <span class="text-gradient">nuestros clientes</span></h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Miles de familias ya encontraron su hogar con InmoTech</p>
        </div>
        <div class="splide" id="testimonials" data-aos="fade-up" data-aos-delay="200">
            <div class="splide__track">
                <ul class="splide__list">
                    <li class="splide__slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">Encontre la casa de mis suenos en menos de 2 semanas. El proceso fue increiblemente sencillo y los agentes super profesionales.</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width:50px;height:50px;background:linear-gradient(135deg,#667eea,#764ba2)">AG</div>
                                <div>
                                    <p class="mb-0 fw-bold">Ana Garcia</p>
                                    <small class="text-muted">Compradora en CDMX</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">La calculadora de hipoteca me ayudo a planear mi presupuesto antes de visitar. Excelente herramienta y servicio de primera.</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width:50px;height:50px;background:linear-gradient(135deg,#f093fb,#f5576c)">LT</div>
                                <div>
                                    <p class="mb-0 fw-bold">Luis Torres</p>
                                    <small class="text-muted">Inversionista</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">Como agente, InmoTech me ha permitido cerrar ventas mas rapido. La plataforma es intuitiva y los leads de calidad.</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width:50px;height:50px;background:linear-gradient(135deg,#4facfe,#00f2fe)">CR</div>
                                <div>
                                    <p class="mb-0 fw-bold">Carlos Ramirez</p>
                                    <small class="text-muted">Agente Senior</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">El comparador de propiedades es genial. Pude evaluar 3 opciones lado a lado y tomar la mejor decision para mi familia.</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width:50px;height:50px;background:linear-gradient(135deg,#43e97b,#38f9d7)">PS</div>
                                <div>
                                    <p class="mb-0 fw-bold">Patricia Silva</p>
                                    <small class="text-muted">Familia de 4</small>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="splide__slide">
                        <div class="testimonial-card">
                            <div class="testimonial-stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="testimonial-quote">La transparencia del proceso es lo que mas valoro. Sin sorpresas, sin letra chica. Definitivamente recomendare InmoTech.</p>
                            <div class="d-flex align-items-center mt-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3" style="width:50px;height:50px;background:linear-gradient(135deg,#fa709a,#fee140)">JH</div>
                                <div>
                                    <p class="mb-0 fw-bold">Jorge Hernandez</p>
                                    <small class="text-muted">Empresario</small>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- POR QUE ELEGIRNOS -->
<section style="background: var(--primary); color: white; position:relative; overflow:hidden">
    <div style="position:absolute; top:-200px; right:-200px; width:500px; height:500px; background: radial-gradient(circle, var(--accent)33, transparent 70%); border-radius:50%"></div>
    <div style="position:absolute; bottom:-200px; left:-200px; width:500px; height:500px; background: radial-gradient(circle, #667eea33, transparent 70%); border-radius:50%"></div>
    <div class="container position-relative">
        <div class="text-center mb-5">
            <span class="section-tag" data-aos="fade-up">Diferenciadores</span>
            <h2 class="section-title text-white" data-aos="fade-up" data-aos-delay="50">¿Por que <span class="text-gradient">elegirnos</span>?</h2>
            <p class="opacity-75 mb-0" style="font-size:1.1rem" data-aos="fade-up" data-aos-delay="100">La forma mas inteligente de comprar, vender o rentar</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); transition: all 0.4s" data-tilt>
                    <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, var(--accent), var(--accent-dark)); color: white"><i class="fas fa-shield-alt"></i></div>
                    <h5 class="text-white">Propiedades verificadas</h5>
                    <p class="opacity-75 mb-0">Todas pasan por verificacion legal y fisica para garantizar tu seguridad.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); transition: all 0.4s" data-tilt>
                    <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white"><i class="fas fa-user-tie"></i></div>
                    <h5 class="text-white">Agentes profesionales</h5>
                    <p class="opacity-75 mb-0">Equipo certificado con anos de experiencia en el mercado mexicano.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="text-center p-4 rounded-4 h-100" style="background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); transition: all 0.4s" data-tilt>
                    <div class="stat-icon mx-auto" style="background: linear-gradient(135deg, #4facfe, #00f2fe); color: white"><i class="fas fa-headset"></i></div>
                    <h5 class="text-white">Soporte 24/7</h5>
                    <p class="opacity-75 mb-0">Estamos disponibles cuando nos necesites para acompanarte en el proceso.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL ESPECTACULAR -->
<section style="background: linear-gradient(135deg, #f59e0b, #ec4899, #667eea); color: white; position:relative; overflow:hidden; padding: 5rem 0">
    <div style="position:absolute; inset:0; background-image: url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cpath d=%22M30 0 L30 60 M0 30 L60 30%22 stroke=%22white%22 stroke-opacity=%220.05%22/%3E%3C/svg%3E'); pointer-events: none"></div>
    <div class="container text-center position-relative">
        <h2 class="section-title text-white mb-3" data-aos="zoom-in" style="font-size: clamp(2.25rem, 5vw, 4rem)">¿Listo para encontrar tu nuevo hogar?</h2>
        <p class="lead opacity-90 mb-4" data-aos="fade-up" data-aos-delay="100" style="font-size:1.25rem">
            Unete a miles que ya confian en InmoTech
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg fw-bold text-dark">
                Crear cuenta gratis <i class="fas fa-arrow-right ms-2"></i>
            </a>
            <a href="{{ route('propiedades.buscar') }}" class="btn btn-outline-light btn-lg">
                Explorar propiedades
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// TYPED.JS - Texto que se escribe solo
new Typed('#typed', {
    strings: ['hogar ideal.', 'casa de ensueno.', 'inversion perfecta.', 'nuevo comienzo.'],
    typeSpeed: 60,
    backSpeed: 40,
    backDelay: 2000,
    loop: true,
    showCursor: true,
    cursorChar: '|'
});

// COUNT UP - Contadores animados
const counters = document.querySelectorAll('.counter-number');
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const target = parseInt(entry.target.dataset.target);
            const counter = new countUp.CountUp(entry.target, target, {
                duration: 2.5,
                separator: ',',
                suffix: entry.target.dataset.target == 98 ? '%' : '+'
            });
            if (!counter.error) counter.start();
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });
counters.forEach(c => observer.observe(c));

// SPLIDE - Carousel testimonios
new Splide('#testimonials', {
    type: 'loop',
    perPage: 3,
    perMove: 1,
    gap: '1.5rem',
    autoplay: true,
    interval: 4000,
    pauseOnHover: true,
    arrows: false,
    pagination: true,
    breakpoints: {
        992: { perPage: 2 },
        768: { perPage: 1 }
    }
}).mount();
</script>
<style>
.splide__pagination__page.is-active { background: var(--accent) !important; transform: scale(1.4) !important; }
.splide__pagination__page { background: var(--gray-300); }
</style>
@endpush
