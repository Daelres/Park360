<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Park360') }}</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animaciones para parque de diversiones */
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes bounce-gentle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes wiggle {
            0%, 100% {
                transform: rotate(0deg);
            }
            25% {
                transform: rotate(-3deg);
            }
            75% {
                transform: rotate(3deg);
            }
        }

        @keyframes pulse-scale {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        /* Variables del sistema de diseño del parque */
        :root {
            /* Purple primary */
            --primary: oklch(0.55 0.25 280);
            --primary-dark: oklch(0.50 0.25 280);
            /* Lime green secondary */
            --secondary: oklch(0.82 0.25 130);
            --secondary-dark: oklch(0.78 0.25 130);
            /* Orange accent */
            --accent: oklch(0.7 0.25 40);
            --accent-dark: oklch(0.65 0.25 40);
            /* Additional colors */
            --success: oklch(0.82 0.25 130);
            --warning: oklch(0.88 0.22 100);
            --muted: oklch(0.96 0.03 300);
            --muted-dark: oklch(0.9 0.02 280);
            --text-dark: oklch(0.2 0.05 280);
            --text-muted: oklch(0.5 0.05 280);
            --border: oklch(0.9 0.02 280);
            --radius: 1.25rem;
            --logout-btn-size: 2.75rem;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Fredoka', 'Nunito', Arial, sans-serif;
            background: oklch(0.99 0.015 85);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* Header/Sidebar con estilo de parque */
        header {
            background: var(--primary);
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 320px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        }

        .logo {
            margin-bottom: 2rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce-gentle 3s ease-in-out infinite;
            background: white;
            padding: 1.5rem;
            border-radius: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .logo img {
            width: 100%;
            height: auto;
            max-width: 240px;
            filter: drop-shadow(3px 3px 0px rgba(0, 0, 0, 0.2));
            object-fit: contain;
        }

        nav {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        nav a {
            margin-left: 0;
            margin-bottom: 0.75rem;
            font-weight: 700;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid transparent;
            font-size: 1rem;
        }

        nav a i {
            width: 24px;
            text-align: center;
            font-size: 1.2rem;
        }

        nav a:hover {
            color: var(--text-dark);
            background: var(--secondary);
            transform: translateX(8px) scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        main {
            padding: 2rem;
            margin-left: 320px;
            flex: 1;
            width: calc(100% - 320px);
        }

        .card {
            background: white;
            border-radius: var(--radius);
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 3px solid var(--border);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            transform: translateY(-4px);
            border-color: var(--secondary);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            background: var(--primary);
            color: white;
            font-weight: 800;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            letter-spacing: 0.5px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }

        .btn.secondary {
            background: var(--secondary);
            color: var(--text-dark);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .btn.accent {
            background: var(--accent);
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .btn.secondary:hover {
            background: var(--secondary-dark);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .btn.accent:hover {
            background: var(--accent-dark);
        }

        .flash-message {
            background: var(--secondary);
            color: var(--text-dark);
            border: 3px solid var(--accent);
            padding: 1rem 1.5rem;
            border-radius: var(--radius);
            margin-bottom: 1.5rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-footer {
            margin-top: auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
            position: relative;
        }


        .user-card {
            width: 100%;
            padding: 1rem 1.25rem;
            border-radius: var(--radius);
            background: rgba(255, 255, 255, 0.12);
            border: 2px solid rgba(255, 255, 255, 0.25);
            color: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            gap: 1rem;
            position: relative;
            overflow: visible;
        }

        .user-card__avatar {
            flex-shrink: 0;
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            background: white;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .user-card__info {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
            flex: 1;
        }

        .user-card__label {
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.8;
            margin: 0;
        }

        .user-card__name {
            font-size: 1.05rem;
            font-weight: 800;
            margin: 0;
        }

        .user-card__email {
            font-size: 0.8rem;
            opacity: 0.85;
            margin: 0;
        }

        .user-card__links {
            margin-top: 0.4rem;
            font-size: 0.75rem;
            opacity: 0.9;
            display: flex;
            flex-wrap: wrap;
            gap: 0.35rem;
        }

        .user-card__links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: underline;
        }

        .user-card__links a:hover {
            color: white;
        }

        .user-card__actions {
            margin: 0;
            position: absolute;
            top: 50%;
            right: calc(-1 * var(--logout-btn-size) / 2);
            transform: translateY(-50%);
        }

        .auth-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: var(--logout-btn-size);
            height: var(--logout-btn-size);
            border-radius: 999px;
            background: white;
            color: var(--primary);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            font-size: 1.1rem;
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.25);
            background: var(--secondary);
            color: var(--text-dark);
        }

        .auth-btn--login {
            background: var(--secondary);
            color: var(--text-dark);
        }

        .auth-btn--login:hover {
            background: var(--secondary-dark);
        }

        .sidebar-toast {
            background: rgba(255, 255, 255, 0.12);
            border: 2px solid rgba(255, 255, 255, 0.25);
            color: white;
            border-radius: var(--radius);
            padding: 0.9rem 1.1rem;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.18);
            backdrop-filter: blur(6px);
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .sidebar-toast.sidebar-toast--hide {
            opacity: 0;
            transform: translateY(12px);
            pointer-events: none;
        }

        form .field {
            margin-bottom: 1rem;
        }

        form label {
            display: block;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: var(--radius);
            border: 2px solid var(--border);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        form input:focus,
        form select:focus,
        form textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(147, 105, 245, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }

        th {
            background: var(--primary);
            color: white;
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        tr + tr {
            border-top: 2px solid var(--border);
        }

        tbody tr:hover {
            background: var(--muted);
        }

        .table-actions {
            display: flex;
            gap: 0.75rem;
        }

        .badge {
            display: inline-flex;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            background: var(--accent);
            color: white;
            font-weight: 800;
            font-size: 0.8rem;
            border: 2px solid transparent;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.success {
            background: var(--success);
            color: var(--text-dark);
        }

        .badge.warning {
            background: var(--warning);
            color: var(--text-dark);
        }

        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        @media (max-width: 1024px) {
            .grid-3 {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 640px) {
            .grid-3 {
                grid-template-columns: 1fr;
            }
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .hero {
            background: var(--primary);
            border-radius: var(--radius);
            padding: 3rem 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            align-items: center;
            margin-bottom: 2rem;
            color: white;
            border: 4px solid var(--accent);
        }

        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 900;
            letter-spacing: 1px;
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.2), 6px 6px 0px rgba(0, 0, 0, 0.1);
        }

        .hero p {
            font-size: 1.1rem;
            line-height: 1.7;
            color: white;
            font-weight: 500;
        }

        .select-inline {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .select-inline select {
            width: auto;
            min-width: 200px;
        }

        /* Utilidades de animación */
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-bounce-gentle {
            animation: bounce-gentle 2s ease-in-out infinite;
        }

        .animate-wiggle {
            animation: wiggle 1s ease-in-out infinite;
        }

        .animate-pulse-scale {
            animation: pulse-scale 2s ease-in-out infinite;
        }

        /* Efectos de texto 3D */
        .text-3d-primary {
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1), 6px 6px 0px rgba(0, 0, 0, 0.05);
        }

        .text-3d-bold {
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2), 4px 4px 0px rgba(0, 0, 0, 0.1), 6px 6px 0px rgba(0, 0, 0, 0.05);
        }

        @media (max-width: 768px) {
            header {
                width: 100%;
                height: auto;
                position: static;
                border-right: none;
                border-bottom: 5px solid var(--accent);
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            .logo {
                animation: none;
            }

            nav {
                flex-direction: row;
                flex-wrap: wrap;
            }

            nav a {
                margin-bottom: 0;
                margin-left: 0.5rem;
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
            }

            nav a:hover {
                transform: translateY(-3px) scale(1.05);
            }

            header {
                border-bottom: none;
            }

            main {
                margin-left: 0;
                width: 100%;
            }

            .user-card {
                margin-top: 1.5rem;
                padding: 0.9rem 1rem;
            }

            .user-card__avatar {
                width: 2.6rem;
                height: 2.6rem;
                font-size: 1.1rem;
            }

            .user-card__actions {
                position: static;
                transform: none;
                right: auto;
                margin-left: auto;
            }

            .user-card__links {
                justify-content: flex-start;
            }

            .auth-btn {
                width: 2.5rem;
                height: 2.5rem;
            }

            .sidebar-footer {
                gap: 0.75rem;
                width: 100%;
            }

            .sidebar-toast {
                font-size: 0.85rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<header>
    <div class="logo">
        <img src="{{ asset('images/ChatGPT Image 12 nov 2025, 23_37_27.png') }}" alt="Park360 Logo"/>
    </div>
    <nav>
        @php
            $user = auth()->user();
            $isAdmin = $user && method_exists($user, 'hasRole') && $user->hasRole('admin');
            $isEmployee = $user && method_exists($user, 'hasRole') && $user->hasRole('employee');
            $isStaff = $isAdmin || $isEmployee;
        @endphp

        @if ($isStaff)
            <a href="{{ route('dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a>
        @endif

        @if ($isAdmin)
            <a href="{{ route('admin.sedes.index') }}"><i class="fas fa-map-marked-alt"></i> Admin Sedes</a>
            <a href="{{ route('admin.atracciones.index') }}"><i class="fas fa-gamepad"></i> Admin Atracciones</a>
            <a href="{{ route('admin.reportes.index') }}"><i class="fas fa-chart-bar"></i> Reportes</a>

        @else
            <a href="{{ route('public.home') }}"><i class="fas fa-rocket"></i> Atracciones</a>
            <a href="{{ route('public.plans') }}"><i class="fas fa-ticket-alt"></i> Entradas</a>
            <a href="{{ route('payments.create') }}"><i class="fas fa-shopping-cart"></i> Carrito</a>
            <a href="{{ route('admin.reportes.index') }}"><i class="fas fa-chart-bar"></i> Reportes</a>

        @endif
    </nav>
    <div class="sidebar-footer">
        @auth
            <div class="user-card">
                <div class="user-card__avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-card__info">
                    <p class="user-card__label">Conectado como</p>
                    <p class="user-card__name">{{ auth()->user()->name }}</p>
                    <p class="user-card__email">{{ auth()->user()->email }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="user-card__actions">
                    @csrf
                    <button type="submit" class="auth-btn auth-btn--logout" title="Cerrar sesión">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        @else
            <div class="user-card user-card--guest">
                <div class="user-card__avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-card__info">
                    <p class="user-card__label">Bienvenido</p>
                    <p class="user-card__name">Iniciar sesión</p>
                    <p class="user-card__email">Accede para administrar tu experiencia</p>
                    @if (Route::has('register'))
                        <div class="user-card__links">
                            <a href="{{ route('register') }}">¿Aún sin cuenta? Regístrate</a>
                        </div>
                    @endif
                </div>
                @if (Route::has('login'))
                    <div class="user-card__actions">
                        <a href="{{ route('login') }}" class="auth-btn auth-btn--login" title="Iniciar sesión">
                            <i class="fas fa-arrow-right-to-bracket"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endauth

        @if (session('logout_message'))
            <div class="sidebar-toast" role="status" aria-live="polite">
                {{ session('logout_message') }}
            </div>
        @endif
    </div>
</header>
<main>
    @if (session('status'))
        <div class="flash-message">
            {{ session('status') }}
        </div>
    @endif

    @yield('content')
</main>

@stack('scripts')
@if (session('logout_message'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toast = document.querySelector('.sidebar-toast');
            if (!toast) {
                return;
            }

            setTimeout(() => {
                toast.classList.add('sidebar-toast--hide');
            }, 3500);
        });
    </script>
@endif
</body>
</html>
