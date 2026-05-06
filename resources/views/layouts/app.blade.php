<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="InmoTech - La plataforma inmobiliaria mas completa de Mexico. Encuentra casas, departamentos y locales en venta o renta.">
    <title>@yield('title', 'Inicio') | InmoTech</title>

    <!-- SEO META TAGS -->
    <meta name="keywords" content="bienes raices, inmobiliaria, casas, departamentos, mexico, venta, renta, propiedades">
    <meta name="author" content="InmoTech">
    <meta name="theme-color" content="#0f172a">

    <!-- OPEN GRAPH (Facebook, WhatsApp, LinkedIn) -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', 'InmoTech - Tu hogar ideal te espera')">
    <meta property="og:description" content="@yield('og_description', 'La plataforma inmobiliaria mas completa de Mexico. Miles de propiedades verificadas.')">
    <meta property="og:image" content="@yield('og_image', 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1200&q=80')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="InmoTech">
    <meta property="og:locale" content="es_MX">

    <!-- TWITTER CARD -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'InmoTech')">
    <meta name="twitter:description" content="@yield('og_description', 'Encuentra tu hogar ideal')">
    <meta name="twitter:image" content="@yield('og_image', 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=1200&q=80')">

    <!-- SCHEMA.ORG -->
    @stack('schema')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateAgent",
        "name": "InmoTech",
        "description": "Plataforma inmobiliaria de Mexico",
        "url": "{{ url('/') }}",
        "logo": "{{ url('/storage/logo.png') }}"
    }
    </script>

    <!-- FAVICON -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Crect width='24' height='24' rx='5' fill='%23f59e0b'/%3E%3Cpath d='M12 5l-7 6h2v6h4v-4h2v4h4v-6h2z' fill='white'/%3E%3C/svg%3E">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0f172a;
            --primary-light: #1e293b;
            --accent: #f59e0b;
            --accent-dark: #d97706;
            --accent-light: #fbbf24;
            --gradient-1: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-2: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-3: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-warm: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --gradient-dark: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --gradient-mesh: radial-gradient(at 20% 20%, #667eea 0px, transparent 50%),
                             radial-gradient(at 80% 0%, #f59e0b 0px, transparent 50%),
                             radial-gradient(at 0% 80%, #ec4899 0px, transparent 50%),
                             radial-gradient(at 80% 80%, #4facfe 0px, transparent 50%);
            --success: #10b981;
            --danger: #ef4444;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-900: #111827;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.05);
            --shadow-lg: 0 20px 25px -5px rgba(0,0,0,0.08), 0 8px 10px -6px rgba(0,0,0,0.05);
            --shadow-xl: 0 25px 50px -12px rgba(0,0,0,0.15);
            --shadow-glow: 0 0 30px rgba(245, 158, 11, 0.4);
            --shadow-glow-blue: 0 0 30px rgba(102, 126, 234, 0.4);

            /* THEME COLORS - LIGHT */
            --bg-primary: #f9fafb;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f3f4f6;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --card-bg: #ffffff;
            --navbar-bg: rgba(255,255,255,0.85);
        }
        [data-theme="dark"] {
            --bg-primary: #0a0e1a;
            --bg-secondary: #111827;
            --bg-tertiary: #1f2937;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --border-color: #374151;
            --card-bg: #1f2937;
            --navbar-bg: rgba(17,24,39,0.85);
            --gray-50: #1f2937;
            --gray-100: #374151;
            --gray-200: #4b5563;
            --gray-900: #f9fafb;
        }
        [data-theme="dark"] body { background: var(--bg-primary); color: var(--text-primary); }
        [data-theme="dark"] .navbar { background: var(--navbar-bg) !important; border-bottom-color: rgba(75,85,99,0.3); }
        [data-theme="dark"] .navbar-brand, [data-theme="dark"] .navbar .nav-link { color: var(--text-primary) !important; }
        [data-theme="dark"] .card,
        [data-theme="dark"] .property-card,
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .step-card,
        [data-theme="dark"] .testimonial-card,
        [data-theme="dark"] .agent-card { background: var(--card-bg); border-color: var(--border-color); color: var(--text-primary); }
        [data-theme="dark"] .card-header { background: var(--card-bg); border-bottom-color: var(--border-color); color: var(--text-primary); }
        [data-theme="dark"] .text-muted { color: var(--text-secondary) !important; }
        [data-theme="dark"] .text-dark { color: var(--text-primary) !important; }
        [data-theme="dark"] .bg-white,
        [data-theme="dark"] section[style*="background:white"],
        [data-theme="dark"] section[style*="background: white"] { background: var(--bg-secondary) !important; }
        [data-theme="dark"] section[style*="background: var(--gray-50)"],
        [data-theme="dark"] .bg-light-soft { background: var(--bg-primary) !important; }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select { background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-primary); }
        [data-theme="dark"] .form-control::placeholder { color: var(--text-secondary); }
        [data-theme="dark"] .input-group-text { background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-secondary); }
        [data-theme="dark"] .table { color: var(--text-primary); }
        [data-theme="dark"] .table thead th { background: var(--bg-tertiary); color: var(--text-secondary); }
        [data-theme="dark"] .table-hover tbody tr:hover { background: rgba(255,255,255,0.05); }
        [data-theme="dark"] .breadcrumb-item.active,
        [data-theme="dark"] .breadcrumb-item a { color: var(--text-secondary); }
        [data-theme="dark"] .badge.bg-light { background: var(--bg-tertiary) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] hr { border-color: var(--border-color); }
        [data-theme="dark"] .pagination .page-link { background: var(--card-bg); border-color: var(--border-color); color: var(--text-primary); }
        [data-theme="dark"] .dropdown-menu { background: var(--card-bg); border-color: var(--border-color); }
        [data-theme="dark"] .dropdown-item { color: var(--text-primary); }
        [data-theme="dark"] .dropdown-item:hover { background: var(--bg-tertiary); color: var(--text-primary); }
        [data-theme="dark"] .alert-info { background: rgba(59,130,246,0.15); color: #93c5fd; }
        [data-theme="dark"] .alert-success { background: rgba(16,185,129,0.15); color: #6ee7b7; }
        [data-theme="dark"] .alert-danger { background: rgba(239,68,68,0.15); color: #fca5a5; }
        [data-theme="dark"] .alert-warning { background: rgba(245,158,11,0.15); color: #fcd34d; }

        /* DARK MODE TOGGLE BUTTON */
        .theme-toggle {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            width: 42px; height: 42px;
            border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative; overflow: hidden;
        }
        .theme-toggle:hover {
            background: var(--accent);
            color: white;
            transform: rotate(180deg) scale(1.1);
            box-shadow: 0 8px 20px rgba(245,158,11,0.4);
        }
        .theme-toggle .sun-icon { display: block; }
        .theme-toggle .moon-icon { display: none; }
        [data-theme="dark"] .theme-toggle .sun-icon { display: none; }
        [data-theme="dark"] .theme-toggle .moon-icon { display: block; }

        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
            transition: background-color 0.3s, color 0.3s;
        }
        h1,h2,h3,h4,h5,h6 { font-family: 'Bricolage Grotesque', 'Plus Jakarta Sans', sans-serif; font-weight: 700; letter-spacing: -0.025em; }
        ::selection { background: var(--accent); color: white; }

        /* SCROLL PROGRESS BAR */
        .scroll-progress {
            position: fixed;
            top: 0; left: 0;
            width: 0%; height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-dark));
            z-index: 9999;
            transition: width 0.1s;
            box-shadow: 0 0 10px rgba(245,158,11,0.5);
        }

        /* CURSOR FOLLOWER */
        .cursor-follower {
            position: fixed;
            width: 30px; height: 30px;
            border: 2px solid var(--accent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 9998;
            transition: transform 0.2s ease, width 0.3s, height 0.3s, background 0.3s;
            transform: translate(-50%, -50%);
            mix-blend-mode: difference;
            display: none;
        }
        @media (min-width: 992px) {
            .cursor-follower { display: block; }
            body, a, button { cursor: none !important; }
        }
        .cursor-follower.expand {
            width: 60px; height: 60px;
            background: var(--accent);
            border-color: transparent;
        }

        /* NAVBAR */
        .navbar {
            background: rgba(255,255,255,0.85) !important;
            backdrop-filter: blur(20px) saturate(1.5);
            -webkit-backdrop-filter: blur(20px) saturate(1.5);
            border-bottom: 1px solid rgba(229,231,235,0.5);
            padding: 1rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar.scrolled {
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
        }
        .navbar-brand {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary) !important;
            display: flex; align-items: center; gap: 0.6rem;
            transition: transform 0.3s;
        }
        .navbar-brand:hover { transform: scale(1.05); }
        .navbar-brand .logo-icon {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
            width: 42px; height: 42px;
            border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(245,158,11,0.4);
            position: relative;
            overflow: hidden;
        }
        .navbar-brand .logo-icon::before {
            content: ''; position: absolute; top: -50%; left: -50%;
            width: 200%; height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            animation: shine 3s infinite;
        }
        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        .navbar .nav-link {
            font-weight: 500;
            color: var(--gray-900) !important;
            margin: 0 0.4rem;
            transition: all 0.3s;
            position: relative;
            padding: 0.5rem 0.75rem !important;
        }
        .navbar .nav-link:hover { color: var(--accent) !important; transform: translateY(-2px); }
        .navbar .nav-link.active::after {
            content: ''; position: absolute; bottom: 0; left: 50%;
            transform: translateX(-50%);
            width: 24px; height: 3px;
            background: var(--accent);
            border-radius: 3px;
            box-shadow: 0 2px 8px rgba(245,158,11,0.5);
        }

        /* BUTTONS */
        .btn {
            font-weight: 600;
            border-radius: 12px;
            padding: 0.7rem 1.6rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .btn-sm { padding: 0.45rem 1rem; }
        .btn::before {
            content: ''; position: absolute; top: 50%; left: 50%;
            width: 0; height: 0;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        .btn:hover::before { width: 300px; height: 300px; }
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            box-shadow: 0 4px 14px rgba(15,23,42,0.2);
        }
        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15,23,42,0.25);
        }
        .btn-warning {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border: none;
            color: white;
            box-shadow: 0 8px 20px rgba(245,158,11,0.35);
        }
        .btn-warning:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(245,158,11,0.45), 0 0 30px rgba(245,158,11,0.3);
        }
        .btn-glow {
            position: relative;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white; border: none;
        }
        .btn-glow::after {
            content: ''; position: absolute; inset: -3px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 14px; z-index: -1;
            filter: blur(10px); opacity: 0.6;
            animation: pulse-glow 2s infinite;
        }
        @keyframes pulse-glow {
            0%, 100% { opacity: 0.6; }
            50% { opacity: 1; }
        }
        .btn-outline-primary {
            border: 2px solid var(--gray-200); color: var(--primary);
        }
        .btn-outline-primary:hover {
            background: var(--primary); border-color: var(--primary);
        }

        /* PROPERTY CARDS */
        .property-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            height: 100%;
            transform-style: preserve-3d;
            position: relative;
        }
        .property-card::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, transparent 50%, rgba(245,158,11,0.08));
            opacity: 0; transition: opacity 0.4s;
            pointer-events: none; border-radius: 20px;
        }
        .property-card:hover {
            transform: translateY(-12px) scale(1.01);
            box-shadow: 0 30px 60px -15px rgba(0,0,0,0.2), 0 0 30px rgba(245,158,11,0.1);
            border-color: transparent;
        }
        .property-card:hover::after { opacity: 1; }
        .property-card .img-wrapper {
            position: relative;
            overflow: hidden;
            aspect-ratio: 4/3;
            background: var(--gray-100);
        }
        .property-card .img-wrapper img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .property-card:hover .img-wrapper img { transform: scale(1.15); }
        .property-card .img-wrapper::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 60%, rgba(0,0,0,0.5));
            opacity: 0; transition: opacity 0.4s;
        }
        .property-card:hover .img-wrapper::after { opacity: 1; }
        .property-card .card-body { padding: 1.5rem; }
        .badge-destacada {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white; font-weight: 700; padding: 0.4rem 0.9rem;
            border-radius: 8px; font-size: 0.75rem;
            box-shadow: 0 4px 14px rgba(245,158,11,0.5);
            display: inline-flex; align-items: center; gap: 4px;
            animation: glow-badge 2s ease-in-out infinite;
        }
        @keyframes glow-badge {
            0%, 100% { box-shadow: 0 4px 14px rgba(245,158,11,0.5); }
            50% { box-shadow: 0 4px 20px rgba(245,158,11,0.8); }
        }
        .badge-operacion {
            background: rgba(15,23,42,0.85); backdrop-filter: blur(10px);
            color: white; font-weight: 600; padding: 0.4rem 0.9rem;
            border-radius: 8px; font-size: 0.75rem;
        }
        .price-tag {
            color: var(--primary);
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            font-size: 1.65rem;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, var(--primary), var(--accent-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .property-meta {
            display: flex; gap: 1rem; color: var(--gray-500);
            font-size: 0.875rem; padding-top: 0.75rem;
            border-top: 1px solid var(--gray-200);
            flex-wrap: wrap;
        }
        .property-meta span i { color: var(--accent); margin-right: 0.25rem; }

        /* HERO ESPECTACULAR */
        .hero-spectacular {
            position: relative;
            min-height: 100vh;
            background: var(--gradient-dark);
            color: white;
            overflow: hidden;
            padding: 8rem 0 6rem;
        }
        .hero-mesh {
            position: absolute; inset: 0;
            background: var(--gradient-mesh);
            opacity: 0.4;
            animation: mesh-rotate 20s ease infinite;
        }
        @keyframes mesh-rotate {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.2); }
        }
        .hero-grid-bg {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
        }
        .hero-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: float-blob 20s ease-in-out infinite;
        }
        .hero-blob-1 { top: 10%; left: -10%; width: 400px; height: 400px; background: #667eea; }
        .hero-blob-2 { bottom: -10%; right: -10%; width: 500px; height: 500px; background: var(--accent); animation-delay: -7s; }
        .hero-blob-3 { top: 50%; left: 60%; width: 300px; height: 300px; background: #ec4899; animation-delay: -14s; }
        @keyframes float-blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(50px, -80px) scale(1.1); }
            66% { transform: translate(-50px, 50px) scale(0.95); }
        }
        .hero-content { position: relative; z-index: 5; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.5rem 1.2rem;
            border-radius: 100px;
            font-size: 0.85rem; font-weight: 600;
            margin-bottom: 1.5rem;
        }
        .hero-badge .pulse-dot {
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(245,158,11,0.7);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0% { box-shadow: 0 0 0 0 rgba(245,158,11,0.7); }
            70% { box-shadow: 0 0 0 12px rgba(245,158,11,0); }
            100% { box-shadow: 0 0 0 0 rgba(245,158,11,0); }
        }
        .hero-title {
            font-size: clamp(3rem, 7vw, 6rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            margin-bottom: 1.5rem;
        }
        .hero-title .gradient-text {
            background: linear-gradient(135deg, var(--accent-light), var(--accent), #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradient-shift 5s ease infinite;
            display: inline-block;
        }
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .typed-cursor {
            color: var(--accent);
            animation: blink 0.7s infinite;
        }
        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0; }
        }

        /* HERO SEARCH GLASS */
        .hero-search-glass {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            padding: 1.25rem;
            box-shadow: 0 30px 60px -10px rgba(0,0,0,0.3);
        }
        .hero-search-glass .form-select, .hero-search-glass .form-control {
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 0.85rem 1.1rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        .hero-search-glass .form-select:focus, .hero-search-glass .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(245,158,11,0.15);
        }

        /* FLOATING PROPERTY CARDS (decorative) */
        .floating-card {
            position: absolute;
            background: white;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 20px 50px rgba(0,0,0,0.3);
            display: flex; align-items: center; gap: 0.75rem;
            min-width: 220px;
            animation: float-card 6s ease-in-out infinite;
        }
        .floating-card.delay-1 { animation-delay: -2s; }
        .floating-card.delay-2 { animation-delay: -4s; }
        @keyframes float-card {
            0%, 100% { transform: translateY(0) rotate(-2deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        /* COUNTERS */
        .counter-number {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, var(--accent-light), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* MARQUEE */
        .marquee {
            overflow: hidden;
            position: relative;
            padding: 2rem 0;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }
        .marquee-track {
            display: flex; gap: 4rem;
            animation: marquee-scroll 30s linear infinite;
            white-space: nowrap;
        }
        @keyframes marquee-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .marquee-item {
            display: inline-flex; align-items: center; gap: 0.6rem;
            font-weight: 700; font-size: 1.5rem;
            color: var(--gray-500);
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        .marquee-item:hover { opacity: 1; color: var(--primary); }

        /* HOW IT WORKS STEPS */
        .step-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
        }
        .step-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
            border-color: var(--accent);
        }
        .step-number {
            position: absolute; top: -15px; right: 20px;
            width: 50px; height: 50px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            color: white;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800; font-size: 1.5rem;
            box-shadow: 0 10px 25px rgba(245,158,11,0.4);
        }
        .step-icon {
            width: 70px; height: 70px;
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.25rem;
            background: rgba(245,158,11,0.1);
            color: var(--accent-dark);
        }

        /* TESTIMONIAL CARD */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--gray-200);
            margin: 1rem 0;
            transition: all 0.4s;
        }
        .testimonial-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); }
        .testimonial-stars { color: var(--accent); margin-bottom: 1rem; }
        .testimonial-quote {
            font-size: 1.1rem; line-height: 1.6;
            color: var(--gray-900);
            font-style: italic;
            position: relative;
            padding-left: 1.5rem;
        }
        .testimonial-quote::before {
            content: '"'; position: absolute; left: 0; top: -10px;
            font-size: 3rem; color: var(--accent);
            font-family: serif; line-height: 1;
        }

        /* AGENT CARD */
        .agent-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid var(--gray-200);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .agent-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.15);
            border-color: var(--accent);
        }
        .agent-avatar {
            width: 100px; height: 100px;
            background: linear-gradient(135deg, var(--gradient-1));
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 1.5rem auto 1rem;
            color: white;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800; font-size: 2rem;
            box-shadow: 0 15px 30px rgba(102,126,234,0.4);
            position: relative;
        }
        .agent-avatar::after {
            content: ''; position: absolute; inset: -8px;
            border: 3px solid var(--accent);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .agent-card:hover .agent-avatar::after { opacity: 1; }

        /* STATS */
        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid var(--gray-200);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: ''; position: absolute; top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.05), transparent);
            transition: left 0.6s;
        }
        .stat-card:hover::before { left: 100%; }
        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-lg);
            border-color: var(--accent);
        }
        .stat-icon {
            width: 64px; height: 64px;
            border-radius: 16px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            transition: all 0.3s;
        }
        .stat-card:hover .stat-icon { transform: rotate(-5deg) scale(1.1); }
        .stat-icon.primary { background: rgba(15,23,42,0.08); color: var(--primary); }
        .stat-icon.warning { background: rgba(245,158,11,0.12); color: var(--accent-dark); }
        .stat-icon.success { background: rgba(16,185,129,0.12); color: var(--success); }
        .stat-icon.purple { background: rgba(139,92,246,0.12); color: #8b5cf6; }
        .stat-number {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -0.03em;
            line-height: 1;
        }

        /* SECTIONS */
        section { padding: 6rem 0; position: relative; }
        .section-tag {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(245,158,11,0.1);
            color: var(--accent-dark);
            border-radius: 100px;
            font-size: 0.85rem; font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 1rem;
        }
        .section-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 0.75rem;
            letter-spacing: -0.03em;
        }
        .section-subtitle {
            color: var(--gray-500);
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        /* FOOTER */
        footer {
            background: var(--primary);
            color: rgba(255,255,255,0.7);
            padding: 5rem 0 1.5rem;
            margin-top: 0;
            position: relative;
            overflow: hidden;
        }
        footer::before {
            content: ''; position: absolute; top: -50%; left: -10%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(245,158,11,0.1), transparent 70%);
            pointer-events: none;
        }
        footer h5, footer h6 { color: white; font-weight: 700; }
        footer .footer-brand {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800; font-size: 1.5rem; color: white;
            display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1rem;
        }
        footer ul { list-style: none; padding: 0; }
        footer ul li { margin-bottom: 0.5rem; }
        footer a { color: rgba(255,255,255,0.7); text-decoration: none; transition: all 0.3s; }
        footer a:hover { color: var(--accent); padding-left: 5px; }
        .social-links a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.08);
            border-radius: 12px;
            margin-right: 0.5rem;
            transition: all 0.3s;
        }
        .social-links a:hover {
            background: var(--accent); color: white;
            transform: translateY(-4px) rotate(-5deg);
            box-shadow: 0 10px 20px rgba(245,158,11,0.4);
            padding-left: 0;
        }

        /* CARDS GENERAL */
        .card { border: 1px solid var(--gray-200); border-radius: 16px; box-shadow: none; }
        .card-header { background: white; border-bottom: 1px solid var(--gray-200); font-weight: 600; padding: 1rem 1.5rem; border-radius: 16px 16px 0 0 !important; }

        /* ALERTS */
        .alert { border-radius: 12px; border: none; padding: 1rem 1.25rem; }
        .alert-success { background: rgba(16,185,129,0.1); color: #047857; }
        .alert-danger { background: rgba(239,68,68,0.1); color: #b91c1c; }
        .alert-info { background: rgba(59,130,246,0.1); color: #1e40af; }
        .alert-warning { background: rgba(245,158,11,0.1); color: #92400e; }

        /* FORMS */
        .form-control, .form-select {
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 0.7rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(245,158,11,0.12);
        }
        .form-label { font-weight: 600; color: var(--gray-900); margin-bottom: 0.4rem; }

        /* TABLES */
        .table { color: var(--gray-900); }
        .table thead th {
            background: var(--gray-50);
            font-weight: 700; font-size: 0.85rem;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: var(--gray-500); border: none;
        }

        /* BADGES */
        .badge { font-weight: 600; padding: 0.4rem 0.75rem; border-radius: 8px; }

        /* PAGINATION */
        .pagination .page-link {
            color: var(--gray-900); border: 1px solid var(--gray-200);
            border-radius: 10px !important; margin: 0 0.2rem;
            padding: 0.55rem 0.95rem; font-weight: 500;
            transition: all 0.3s;
        }
        .pagination .page-link:hover { background: var(--accent); color: white; border-color: var(--accent); transform: translateY(-2px); }
        .pagination .page-item.active .page-link {
            background: var(--primary); border-color: var(--primary); color: white;
            box-shadow: 0 6px 14px rgba(15,23,42,0.2);
        }

        /* UTILITIES */
        .text-accent { color: var(--accent) !important; }
        .text-gradient {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .bg-light-soft { background: var(--gray-50); }

        /* SCROLL TO TOP */
        .scroll-top {
            position: fixed; bottom: 30px; right: 30px;
            width: 50px; height: 50px;
            background: var(--primary); color: white;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            opacity: 0; visibility: hidden;
            transform: translateY(20px);
            transition: all 0.4s;
            z-index: 999;
            border: none;
        }
        .scroll-top.visible { opacity: 1; visibility: visible; transform: translateY(0); }
        .scroll-top:hover { background: var(--accent); transform: translateY(-5px); }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hero-spectacular { padding: 5rem 0 4rem; min-height: auto; }
            section { padding: 3.5rem 0; }
            .section-title { font-size: 1.85rem; }
            .floating-card { display: none; }
        }

        /* DROPDOWN MENU */
        .dropdown-menu {
            border-radius: 14px !important;
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow-lg);
            padding: 0.5rem;
        }
        .dropdown-item { border-radius: 8px; padding: 0.6rem 1rem; transition: all 0.2s; }
        .dropdown-item:hover { background: var(--gray-50); }

        /* AUTOCOMPLETE */
        .navbar-search {
            position: relative;
            min-width: 280px;
            max-width: 400px;
        }
        .navbar-search-input {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 0.55rem 1rem 0.55rem 2.5rem;
            font-size: 0.9rem;
            width: 100%;
            transition: all 0.3s;
            color: var(--text-primary);
        }
        .navbar-search-input:focus {
            background: var(--bg-secondary);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(245,158,11,0.12);
            outline: none;
        }
        .navbar-search-icon {
            position: absolute; left: 0.85rem; top: 50%; transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
        }
        .navbar-search-results {
            position: absolute; top: calc(100% + 8px); left: 0; right: 0;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            max-height: 480px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            padding: 0.5rem;
        }
        .navbar-search-results.show { display: block; animation: slideDown 0.25s ease; }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .autocomplete-item {
            display: flex; align-items: center; gap: 12px;
            padding: 0.75rem;
            border-radius: 10px;
            text-decoration: none;
            color: var(--text-primary);
            transition: all 0.2s;
            cursor: pointer;
        }
        .autocomplete-item:hover, .autocomplete-item.active {
            background: var(--bg-tertiary);
            color: var(--text-primary);
            transform: translateX(4px);
        }
        .autocomplete-icon {
            width: 44px; height: 44px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(245,158,11,0.12);
            color: var(--accent-dark);
            flex-shrink: 0;
            overflow: hidden;
        }
        .autocomplete-icon img { width: 100%; height: 100%; object-fit: cover; }
        .autocomplete-content { flex-grow: 1; min-width: 0; }
        .autocomplete-title {
            font-weight: 600; font-size: 0.9rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            margin: 0;
        }
        .autocomplete-subtitle {
            font-size: 0.78rem; color: var(--text-secondary);
            margin: 0;
        }
        .autocomplete-price {
            font-size: 0.8rem; font-weight: 700;
            color: var(--accent-dark);
            white-space: nowrap;
        }
        .autocomplete-section-title {
            font-size: 0.7rem; font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-secondary);
            padding: 0.5rem 0.75rem 0.25rem;
            margin: 0;
        }
        .autocomplete-empty {
            padding: 2rem 1rem; text-align: center; color: var(--text-secondary);
        }
        @media (max-width: 991px) {
            .navbar-search { display: none; }
        }

        /* LOADING SCREEN */
        .loading-screen {
            position: fixed;
            inset: 0;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.6s, visibility 0.6s;
        }
        .loading-screen.hidden {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }
        .loading-house {
            width: 100px; height: 100px;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            border-radius: 24px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 3rem;
            box-shadow: 0 20px 60px rgba(245,158,11,0.5);
            animation: bounce-house 1.5s ease-in-out infinite;
        }
        @keyframes bounce-house {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-15px) scale(1.05); }
        }
        .loading-text {
            color: white;
            font-family: 'Bricolage Grotesque', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            margin-top: 1.5rem;
            letter-spacing: 0.05em;
        }
        .loading-dots span {
            display: inline-block;
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            margin: 0 3px;
            animation: dot-bounce 1.4s ease-in-out infinite;
        }
        .loading-dots span:nth-child(2) { animation-delay: 0.2s; }
        .loading-dots span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes dot-bounce {
            0%, 80%, 100% { transform: scale(0.8); opacity: 0.5; }
            40% { transform: scale(1.2); opacity: 1; }
        }

        /* HEART ANIMATION (favoritos) */
        .heart-btn {
            background: white; border: 1px solid var(--gray-200);
            width: 44px; height: 44px;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--gray-500);
            position: relative;
            font-size: 1.1rem;
        }
        .heart-btn:hover { transform: scale(1.1); border-color: #ef4444; color: #ef4444; }
        .heart-btn.is-favorite {
            background: #ef4444; color: white; border-color: #ef4444;
            animation: heart-pop 0.5s;
        }
        @keyframes heart-pop {
            0% { transform: scale(1); }
            30% { transform: scale(1.4); }
            60% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
        .heart-btn.is-favorite::after {
            content: ''; position: absolute; inset: -4px;
            border-radius: 50%; border: 2px solid #ef4444;
            opacity: 0;
            animation: heart-ring 0.6s ease-out;
        }
        @keyframes heart-ring {
            0% { opacity: 1; transform: scale(0.8); }
            100% { opacity: 0; transform: scale(1.6); }
        }

        /* COMPARE BUTTON (en cards) */
        .compare-btn {
            background: white; border: 1px solid var(--gray-200);
            width: 44px; height: 44px;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--gray-500);
            font-size: 1rem;
        }
        .compare-btn:hover { transform: scale(1.1); border-color: var(--accent); color: var(--accent); }
        .compare-btn.is-comparing {
            background: var(--accent); color: white; border-color: var(--accent);
        }

        /* COMPARE WIDGET FLOATING */
        .compare-widget {
            position: fixed; bottom: 30px; left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            padding: 1rem 1.5rem;
            display: flex; align-items: center; gap: 1rem;
            z-index: 998;
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-width: 90vw;
        }
        .compare-widget.show { transform: translateX(-50%) translateY(0); }
        .compare-widget .compare-thumb {
            width: 50px; height: 50px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid var(--accent);
        }

        /* QUICK VIEW MODAL */
        .quick-view-modal .modal-content {
            border-radius: 20px; border: none;
            overflow: hidden;
            box-shadow: 0 50px 100px rgba(0,0,0,0.3);
        }
        .quick-view-modal .modal-body { padding: 0; }
        .quick-view-image {
            aspect-ratio: 16/9;
            background: var(--gray-100);
            position: relative; overflow: hidden;
        }
        .quick-view-image img { width: 100%; height: 100%; object-fit: cover; }

        /* SKELETON SCREEN */
        .skeleton {
            background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 8px;
        }
        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .skeleton-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 0;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        .skeleton-img {
            aspect-ratio: 4/3;
            background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        /* WHATSAPP FLOATING */
        .whatsapp-float {
            position: fixed;
            bottom: 30px; right: 30px;
            background: linear-gradient(135deg, #25d366, #128c7e);
            color: white;
            width: 60px; height: 60px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            text-decoration: none;
            box-shadow: 0 10px 30px rgba(37,211,102,0.5);
            z-index: 998;
            animation: whatsapp-pulse 2s infinite;
        }
        @keyframes whatsapp-pulse {
            0%, 100% { box-shadow: 0 10px 30px rgba(37,211,102,0.5), 0 0 0 0 rgba(37,211,102,0.7); }
            50% { box-shadow: 0 10px 30px rgba(37,211,102,0.5), 0 0 0 15px rgba(37,211,102,0); }
        }
        .whatsapp-float:hover {
            color: white;
            transform: scale(1.1) rotate(-5deg);
        }

        /* GRADIENT HOVER NAV LINKS */
        .navbar .nav-link::before {
            content: attr(data-text);
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            display: flex; align-items: center; justify-content: center;
            padding: inherit;
            background: linear-gradient(135deg, var(--accent), #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            transition: opacity 0.3s;
        }
        .navbar .nav-link:hover::before { opacity: 1; }

        /* READING PROGRESS (en articulos largos) */
        .reading-progress {
            position: fixed;
            top: 76px;
            left: 0; right: 0;
            height: 3px;
            background: rgba(245,158,11,0.15);
            z-index: 9000;
        }
        .reading-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--accent), #ec4899);
            width: 0;
            transition: width 0.1s;
            box-shadow: 0 0 10px rgba(245,158,11,0.6);
        }

        /* RATING STARS */
        .rating-stars { display: inline-flex; gap: 2px; }
        .rating-stars .fa-star { color: var(--gray-200); cursor: pointer; transition: all 0.2s; }
        .rating-stars .fa-star.filled { color: var(--accent); }
        .rating-stars.interactive .fa-star:hover { transform: scale(1.2); }

        /* PRICE SLIDER (noUiSlider override) */
        .noUi-target {
            background: var(--gray-200);
            border: none;
            box-shadow: none;
            height: 6px;
            border-radius: 3px;
        }
        .noUi-connect {
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
        }
        .noUi-handle {
            background: white;
            border: 3px solid var(--accent);
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(245,158,11,0.4);
            width: 22px !important;
            height: 22px !important;
            top: -8px !important;
            right: -11px !important;
            cursor: grab;
        }
        .noUi-handle::before, .noUi-handle::after { display: none; }
        .noUi-tooltip {
            border: none;
            background: var(--primary);
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
        }

        /* SWEETALERT2 OVERRIDE */
        .swal2-popup {
            border-radius: 20px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .swal2-styled.swal2-confirm {
            border-radius: 12px !important;
            background: var(--primary) !important;
        }
        .swal2-styled.swal2-cancel {
            border-radius: 12px !important;
        }
        [data-theme="dark"] .swal2-popup { background: var(--card-bg) !important; color: var(--text-primary) !important; }
        [data-theme="dark"] .swal2-title { color: var(--text-primary) !important; }
        [data-theme="dark"] .swal2-html-container { color: var(--text-secondary) !important; }

        /* NOTYF OVERRIDE */
        .notyf__toast {
            border-radius: 12px !important;
            font-family: 'Inter', sans-serif !important;
            font-weight: 600 !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- LOADING SCREEN -->
    <div class="loading-screen" id="loadingScreen">
        <div class="text-center">
            <div class="loading-house"><i class="fas fa-home"></i></div>
            <div class="loading-text">InmoTech</div>
            <div class="loading-dots mt-2">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>

    <div class="scroll-progress"></div>
    <div class="cursor-follower"></div>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="logo-icon"><i class="fas fa-home"></i></span>
                InmoTech
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('propiedades.*') ? 'active' : '' }}" href="{{ route('propiedades.buscar') }}">Propiedades</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('comparar') ? 'active' : '' }}" href="{{ route('comparar') }}">Comparar</a></li>
                </ul>

                <!-- SEARCH AUTOCOMPLETE -->
                <div class="navbar-search me-3" id="navbarSearch">
                    <i class="fas fa-search navbar-search-icon"></i>
                    <input type="text" class="navbar-search-input" id="searchInput" placeholder="Buscar propiedades, colonias..." autocomplete="off">
                    <div class="navbar-search-results" id="searchResults"></div>
                </div>

                <ul class="navbar-nav align-items-lg-center">
                    <li class="nav-item me-2">
                        <button class="theme-toggle" id="themeToggle" aria-label="Cambiar tema" title="Cambiar tema">
                            <i class="fas fa-moon sun-icon"></i>
                            <i class="fas fa-sun moon-icon"></i>
                        </button>
                    </li>
                    @auth
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-th-large me-1"></i> Mi Panel</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                                <span class="rounded-circle text-white d-inline-flex align-items-center justify-content-center me-2"
                                      style="width:36px; height:36px; font-weight:700; font-size:0.9rem; background: linear-gradient(135deg, var(--accent), var(--accent-dark)); box-shadow: 0 6px 14px rgba(245,158,11,0.4)">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <span class="d-none d-lg-inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Mi Panel</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2"></i>Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesion</a></li>
                        <li class="nav-item"><a class="btn btn-warning ms-2" href="{{ route('register') }}">Comenzar gratis <i class="fas fa-arrow-right ms-1"></i></a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="container mt-3" data-aos="fade-down">
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="container mt-3" data-aos="fade-down">
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <span class="logo-icon" style="background: linear-gradient(135deg, var(--accent), var(--accent-dark)); width:42px;height:42px;border-radius:12px;display:inline-flex;align-items:center;justify-content:center"><i class="fas fa-home text-white"></i></span>
                        InmoTech
                    </div>
                    <p>La plataforma inmobiliaria mas innovadora de Mexico. Tecnologia y experiencia para encontrar el hogar perfecto.</p>
                    <div class="social-links mt-3">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="mb-3">Plataforma</h6>
                    <ul>
                        <li><a href="{{ route('propiedades.buscar') }}">Buscar propiedades</a></li>
                        <li><a href="{{ route('comparar') }}">Comparador</a></li>
                        <li><a href="{{ route('register') }}">Crear cuenta</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="mb-3">Para profesionales</h6>
                    <ul>
                        <li><a href="{{ route('register') }}">Soy agente</a></li>
                        <li><a href="#">Planes de publicacion</a></li>
                        <li><a href="#">Soporte tecnico</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="mb-3">Contacto</h6>
                    <ul>
                        <li><i class="fas fa-envelope me-2 text-accent"></i> contacto@inmotech.com</li>
                        <li><i class="fas fa-phone me-2 text-accent"></i> 55 1234 5678</li>
                        <li><i class="fas fa-map-marker-alt me-2 text-accent"></i> Mexico</li>
                    </ul>
                </div>
            </div>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 2.5rem 0 1.5rem">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-0 small">&copy; {{ date('Y') }} InmoTech. Todos los derechos reservados.</p>
                <p class="mb-0 small mt-2 mt-md-0">Hecho con <span class="text-accent">♥</span> en Mexico</p>
            </div>
        </div>
    </footer>

    <button class="scroll-top" id="scrollTop" aria-label="Subir"><i class="fas fa-arrow-up"></i></button>

    <!-- WHATSAPP FLOATING BUTTON -->
    <a href="https://wa.me/525512345678?text=Hola,%20me%20interesa%20InmoTech"
       target="_blank"
       class="whatsapp-float"
       style="right: 100px"
       title="Contactanos por WhatsApp"
       aria-label="WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- QUICK VIEW MODAL -->
    <div class="modal fade quick-view-modal" id="quickViewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close position-absolute" style="top:15px;right:15px;background:white;border-radius:50%;padding:0.6rem;z-index:10;opacity:1" data-bs-dismiss="modal"></button>
                <div class="modal-body">
                    <div id="quickViewContent">
                        <div class="text-center py-5">
                            <div class="spinner-border text-warning"></div>
                            <p class="mt-2 text-muted">Cargando...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- COMPARE WIDGET -->
    <div class="compare-widget" id="compareWidget">
        <div id="compareItems" class="d-flex gap-2"></div>
        <div class="d-flex flex-column">
            <small class="text-muted">Propiedades a comparar</small>
            <strong id="compareCount">0 / 3</strong>
        </div>
        <button class="btn btn-warning btn-sm" id="compareGoBtn" disabled>
            <i class="fas fa-balance-scale me-1"></i> Comparar
        </button>
        <button class="btn btn-link btn-sm text-danger p-0" id="compareClearBtn" title="Limpiar">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nouislider@15.7.1/dist/nouislider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.2/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.3.1/dist/driver.js.iife.js"></script>
    <script>
        // LOADING SCREEN
        window.addEventListener('load', () => {
            setTimeout(() => {
                document.getElementById('loadingScreen').classList.add('hidden');
            }, 600);
        });

        // GLOBAL TOASTS (Notyf)
        window.toast = new Notyf({
            duration: 4000,
            position: { x: 'right', y: 'top' },
            ripple: true,
            dismissible: true,
            types: [
                { type: 'success', background: 'linear-gradient(135deg,#10b981,#059669)', icon: { className: 'fas fa-check-circle', tagName: 'i', color: 'white' } },
                { type: 'error', background: 'linear-gradient(135deg,#ef4444,#b91c1c)', icon: { className: 'fas fa-exclamation-circle', tagName: 'i', color: 'white' } },
                { type: 'info', background: 'linear-gradient(135deg,#3b82f6,#1e40af)', icon: { className: 'fas fa-info-circle', tagName: 'i', color: 'white' } },
                { type: 'warning', background: 'linear-gradient(135deg,#f59e0b,#d97706)', icon: { className: 'fas fa-exclamation-triangle', tagName: 'i', color: 'white' } }
            ]
        });

        // CONFIRMACION MODERNA con SweetAlert2
        window.confirmAction = (options = {}) => Swal.fire({
            title: options.title || '¿Estas seguro?',
            text: options.text || 'Esta accion no se puede deshacer',
            icon: options.icon || 'warning',
            showCancelButton: true,
            confirmButtonText: options.confirmText || 'Si, continuar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: options.danger ? '#ef4444' : '#0f172a',
            cancelButtonColor: '#9ca3af',
            reverseButtons: true,
        });

        // Convertir alerts de Bootstrap en toasts
        @if(session('success'))
            toast.success(@json(session('success')));
        @endif
        @if(session('error'))
            toast.error(@json(session('error')));
        @endif

        // DARK MODE TOGGLE
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);

        document.getElementById('themeToggle').addEventListener('click', () => {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
        });

        AOS.init({ duration: 900, once: true, offset: 80, easing: 'ease-out-cubic' });

        // SCROLL PROGRESS
        const scrollProgress = document.querySelector('.scroll-progress');
        window.addEventListener('scroll', () => {
            const scrolled = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
            scrollProgress.style.width = scrolled + '%';
        });

        // NAVBAR ON SCROLL
        const navbar = document.querySelector('.navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 50);
        });

        // CURSOR FOLLOWER
        const cursor = document.querySelector('.cursor-follower');
        if (window.innerWidth >= 992) {
            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });
            document.querySelectorAll('a, button, .property-card, .agent-card, .step-card').forEach(el => {
                el.addEventListener('mouseenter', () => cursor.classList.add('expand'));
                el.addEventListener('mouseleave', () => cursor.classList.remove('expand'));
            });
        }

        // SCROLL TO TOP
        const scrollTop = document.getElementById('scrollTop');
        if (scrollTop) {
            window.addEventListener('scroll', () => {
                scrollTop.classList.toggle('visible', window.scrollY > 500);
            });
            scrollTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
        }

        // VANILLA TILT (3D cards)
        if (typeof VanillaTilt !== 'undefined') {
            VanillaTilt.init(document.querySelectorAll('[data-tilt]'), {
                max: 8, speed: 600, glare: true, 'max-glare': 0.15
            });
        }

        // CONFETTI al completar registro
        @if(session('show_confetti'))
            setTimeout(() => {
                if (typeof confetti !== 'undefined') {
                    const duration = 3000;
                    const end = Date.now() + duration;
                    const colors = ['#f59e0b', '#d97706', '#fbbf24', '#ec4899', '#667eea'];
                    (function frame() {
                        confetti({ particleCount: 4, angle: 60, spread: 60, origin: { x: 0 }, colors });
                        confetti({ particleCount: 4, angle: 120, spread: 60, origin: { x: 1 }, colors });
                        if (Date.now() < end) requestAnimationFrame(frame);
                    })();
                    toast.success('¡Bienvenido a InmoTech! 🎉');
                }
            }, 800);
        @endif

        // TOUR GUIADO (primera visita)
        @auth
            @if(!session('tour_dismissed'))
                if (!localStorage.getItem('tour_completed') && typeof driver !== 'undefined') {
                    setTimeout(() => {
                        const driverObj = driver.driver({
                            showProgress: true,
                            allowClose: true,
                            nextBtnText: 'Siguiente →',
                            prevBtnText: '← Anterior',
                            doneBtnText: '¡Entendido!',
                            popoverClass: 'driverjs-theme',
                            steps: [
                                { element: '.navbar-brand', popover: { title: '👋 ¡Bienvenido a InmoTech!', description: 'Te mostraremos las funciones principales en 30 segundos.' } },
                                { element: '#searchInput', popover: { title: '🔍 Busqueda inteligente', description: 'Escribe aqui para encontrar propiedades, colonias o ciudades al instante.' } },
                                { element: '#themeToggle', popover: { title: '🌙 Tema oscuro', description: 'Cambia entre modo claro y oscuro segun tu preferencia.' } },
                                { element: '.nav-link[href*="propiedades"]', popover: { title: '🏠 Catalogo completo', description: 'Filtra por tipo, precio, zona y mas.' } },
                                { element: '.whatsapp-float', popover: { title: '💬 Soporte 24/7', description: 'Contactanos por WhatsApp cuando lo necesites.' } },
                            ],
                            onDestroyed: () => localStorage.setItem('tour_completed', '1')
                        });
                        driverObj.drive();
                    }, 1500);
                }
            @endif
        @endauth

        // QUICK VIEW MODAL
        window.openQuickView = async (id) => {
            const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
            document.getElementById('quickViewContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-warning"></div>
                    <p class="mt-2 text-muted">Cargando...</p>
                </div>
            `;
            modal.show();
            try {
                const res = await fetch(`/api/quick-view/${id}`);
                if (res.ok) {
                    document.getElementById('quickViewContent').innerHTML = await res.text();
                } else {
                    document.getElementById('quickViewContent').innerHTML = '<p class="text-center p-5 text-danger">Error al cargar</p>';
                }
            } catch (e) {
                document.getElementById('quickViewContent').innerHTML = '<p class="text-center p-5 text-danger">Error de conexion</p>';
            }
        };

        // SISTEMA DE COMPARADOR (localStorage)
        window.compareSystem = {
            key: 'compare_properties',
            get() { return JSON.parse(localStorage.getItem(this.key) || '[]'); },
            save(items) { localStorage.setItem(this.key, JSON.stringify(items)); this.render(); },
            add(prop) {
                let items = this.get();
                if (items.find(p => p.id === prop.id)) return false;
                if (items.length >= 3) {
                    toast.error('Solo puedes comparar hasta 3 propiedades');
                    return false;
                }
                items.push(prop);
                this.save(items);
                toast.success('Agregada al comparador');
                return true;
            },
            remove(id) {
                let items = this.get().filter(p => p.id !== id);
                this.save(items);
            },
            clear() { this.save([]); toast.success('Comparador limpiado'); },
            has(id) { return this.get().some(p => p.id === id); },
            render() {
                const widget = document.getElementById('compareWidget');
                const itemsBox = document.getElementById('compareItems');
                const count = document.getElementById('compareCount');
                const goBtn = document.getElementById('compareGoBtn');
                const items = this.get();
                if (items.length === 0) {
                    widget.classList.remove('show');
                    return;
                }
                widget.classList.add('show');
                itemsBox.innerHTML = items.map(p => `
                    <div class="position-relative" title="${p.titulo}">
                        <img src="${p.image}" class="compare-thumb">
                        <button class="position-absolute top-0 end-0 btn-close" onclick="compareSystem.remove(${p.id})" style="background:white;border-radius:50%;padding:2px;font-size:0.5rem;border:1px solid var(--border-color);transform:translate(30%,-30%)"></button>
                    </div>
                `).join('');
                count.textContent = `${items.length} / 3`;
                goBtn.disabled = items.length < 2;
                goBtn.onclick = () => {
                    const ids = items.map(p => p.id).join(',');
                    window.location = '{{ route("comparar") }}?ids=' + ids;
                };

                // Update card buttons
                document.querySelectorAll('[data-compare-id]').forEach(btn => {
                    const id = parseInt(btn.dataset.compareId);
                    btn.classList.toggle('is-comparing', this.has(id));
                });
            }
        };
        document.getElementById('compareClearBtn').onclick = () => compareSystem.clear();
        compareSystem.render();

        // SISTEMA DE FAVORITOS (animacion + AJAX)
        window.toggleFavorite = async (btn, propiedadId) => {
            @auth
                @if(auth()->user()->isCliente())
                    btn.classList.toggle('is-favorite');
                    const isFav = btn.classList.contains('is-favorite');
                    try {
                        const url = isFav
                            ? `/cliente/favoritos/${propiedadId}`
                            : `/cliente/favoritos/${propiedadId}`;
                        const method = isFav ? 'POST' : 'DELETE';
                        const res = await fetch(url, {
                            method,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                'Accept': 'application/json'
                            }
                        });
                        if (res.ok) {
                            toast.success(isFav ? 'Agregada a favoritos' : 'Eliminada de favoritos');
                        } else {
                            btn.classList.toggle('is-favorite');
                        }
                    } catch (e) {
                        btn.classList.toggle('is-favorite');
                        toast.error('Error de conexion');
                    }
                @else
                    toast.warning('Solo los clientes pueden guardar favoritos');
                @endif
            @else
                toast.info('Inicia sesion para guardar favoritos');
                setTimeout(() => window.location = '{{ route("login") }}', 1500);
            @endauth
        };

        window.toggleCompare = (btn, prop) => {
            if (compareSystem.has(prop.id)) {
                compareSystem.remove(prop.id);
                btn.classList.remove('is-comparing');
                toast.success('Eliminada del comparador');
            } else {
                if (compareSystem.add(prop)) btn.classList.add('is-comparing');
            }
        };

        // AUTOCOMPLETE NAVBAR
        (function() {
            const input = document.getElementById('searchInput');
            const results = document.getElementById('searchResults');
            const wrapper = document.getElementById('navbarSearch');
            if (!input) return;

            let debounceTimer;
            let currentResults = [];
            let activeIndex = -1;

            input.addEventListener('input', (e) => {
                clearTimeout(debounceTimer);
                const q = e.target.value.trim();
                if (q.length < 2) { results.classList.remove('show'); return; }
                debounceTimer = setTimeout(() => fetchResults(q), 250);
            });

            input.addEventListener('focus', () => {
                if (input.value.length >= 2 && currentResults.length) results.classList.add('show');
            });

            input.addEventListener('keydown', (e) => {
                const items = results.querySelectorAll('.autocomplete-item');
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    activeIndex = Math.min(activeIndex + 1, items.length - 1);
                    updateActive(items);
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    activeIndex = Math.max(activeIndex - 1, -1);
                    updateActive(items);
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (activeIndex >= 0 && items[activeIndex]) {
                        window.location = items[activeIndex].href;
                    } else if (input.value.trim()) {
                        window.location = '{{ route("propiedades.buscar") }}?busqueda=' + encodeURIComponent(input.value);
                    }
                } else if (e.key === 'Escape') {
                    results.classList.remove('show');
                    input.blur();
                }
            });

            function updateActive(items) {
                items.forEach((it, i) => it.classList.toggle('active', i === activeIndex));
                if (items[activeIndex]) items[activeIndex].scrollIntoView({ block: 'nearest' });
            }

            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) results.classList.remove('show');
            });

            async function fetchResults(q) {
                try {
                    const res = await fetch(`{{ route('api.autocomplete') }}?q=${encodeURIComponent(q)}`);
                    const data = await res.json();
                    currentResults = data.results;
                    activeIndex = -1;
                    renderResults(data.results, data.query);
                } catch (err) {
                    console.error(err);
                }
            }

            function renderResults(items, q) {
                if (!items.length) {
                    results.innerHTML = `<div class="autocomplete-empty"><i class="fas fa-search-minus mb-2 d-block" style="font-size:1.5rem; opacity:0.5"></i>Sin resultados para "<strong>${q}</strong>"</div>`;
                    results.classList.add('show');
                    return;
                }

                const grouped = items.reduce((acc, item) => {
                    if (!acc[item.type]) acc[item.type] = [];
                    acc[item.type].push(item);
                    return acc;
                }, {});

                const labels = { propiedad: 'Propiedades', colonia: 'Colonias', municipio: 'Ciudades' };

                let html = '';
                for (const type in grouped) {
                    html += `<p class="autocomplete-section-title">${labels[type] || type}</p>`;
                    grouped[type].forEach(item => {
                        html += `
                            <a href="${item.url}" class="autocomplete-item">
                                <div class="autocomplete-icon">
                                    ${item.image ? `<img src="${item.image}">` : `<i class="fas ${item.icon}"></i>`}
                                </div>
                                <div class="autocomplete-content">
                                    <p class="autocomplete-title">${item.title}</p>
                                    <p class="autocomplete-subtitle">${item.subtitle}</p>
                                </div>
                                <span class="autocomplete-price">${item.price}</span>
                            </a>
                        `;
                    });
                }
                html += `
                    <div style="border-top: 1px solid var(--border-color); margin-top: 0.5rem; padding-top: 0.5rem">
                        <a href="{{ route('propiedades.buscar') }}?busqueda=${encodeURIComponent(q)}" class="autocomplete-item" style="justify-content:center; color:var(--accent-dark); font-weight:600">
                            <i class="fas fa-arrow-right"></i> Ver todos los resultados
                        </a>
                    </div>
                `;

                results.innerHTML = html;
                results.classList.add('show');
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>