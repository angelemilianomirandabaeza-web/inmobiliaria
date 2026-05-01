<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="InmoTech - La plataforma inmobiliaria mas completa de Mexico. Encuentra casas, departamentos y locales en venta o renta.">
    <title>@yield('title', 'Inicio') | InmoTech</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,600;12..96,700;12..96,800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet">

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
        }
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            overflow-x: hidden;
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
    </style>
    @stack('styles')
</head>
<body>
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
                <ul class="navbar-nav align-items-lg-center">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.1.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/countup.js@2.8.0/dist/countUp.umd.js"></script>
    <script>
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
    </script>
    @stack('scripts')
</body>
</html>
