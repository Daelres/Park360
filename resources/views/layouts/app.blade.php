<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park360</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e3a8a;
            --secondary: #f97316;
            --gray-50: #f8fafc;
            --gray-100: #e2e8f0;
            --gray-600: #475569;
            --card-radius: 1.25rem;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Manrope', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(180deg, #eff6ff 0%, #fff 35%, #f8fafc 100%);
            color: #0f172a;
            min-height: 100vh;
            display: flex;
        }

        .app-shell {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .logo {
            font-weight: 700;
            font-size: 1.35rem;
            letter-spacing: 0.02em;
            color: var(--primary-dark);
        }

        .logo span {
            color: var(--secondary);
        }

        nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        nav a {
            font-weight: 500;
            color: var(--gray-600);
            padding-bottom: 0.25rem;
            border-bottom: 2px solid transparent;
            transition: all 0.2s ease;
        }

        nav a:hover,
        nav a:focus-visible {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .auth-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-pill {
            background: #1d4ed8;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 999px;
            display: flex;
            flex-direction: column;
            line-height: 1.25;
            font-size: 0.85rem;
        }

        main {
            flex: 1;
            padding: 3rem 1.5rem 4rem;
        }

        .site-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border-radius: var(--card-radius);
            padding: 1.75rem;
            box-shadow: 0 30px 60px rgba(15, 23, 42, 0.08);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            padding: 0.75rem 1.5rem;
            border-radius: 999px;
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn:hover,
        .btn:focus-visible {
            background: var(--primary-dark);
        }

        .btn.ghost {
            background: rgba(37, 99, 235, 0.12);
            color: var(--primary);
            border: 1px solid rgba(37, 99, 235, 0.3);
        }

        .btn.ghost:hover,
        .btn.ghost:focus-visible {
            background: rgba(37, 99, 235, 0.2);
        }

        .flash-message {
            background: #ecfccb;
            color: #1a2e05;
            border: 1px solid #bef264;
            padding: 1rem 1.5rem;
            border-radius: 0.85rem;
            margin-bottom: 1.5rem;
        }

        .flash-error {
            background: #fee2e2;
            border-color: #fecaca;
            color: #7f1d1d;
        }

        form .field {
            margin-bottom: 1rem;
        }

        form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 0.85rem 1rem;
            border-radius: 0.85rem;
            border: 1px solid var(--gray-100);
            font-size: 1rem;
            background: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: var(--card-radius);
            overflow: hidden;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
        }

        th {
            background: var(--gray-50);
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        tr + tr {
            border-top: 1px solid var(--gray-100);
        }

        .page-title {
            margin-bottom: 1.5rem;
        }

        footer {
            padding: 2rem;
            border-top: 1px solid rgba(226, 232, 240, 0.8);
            background: #fff;
            text-align: center;
            color: var(--gray-600);
        }

        @media (max-width: 900px) {
            header {
                flex-direction: column;
                gap: 1rem;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-shell">
        <header>
            <div class="logo">PARK<span>360</span></div>
            <nav>
                <a href="{{ route('public.home') }}">Atracciones</a>
                <a href="{{ route('public.plans') }}">Planes</a>
                <a href="{{ route('payments.create') }}">Pagos</a>
                <a href="{{ route('admin.sedes.index') }}">Sedes</a>
                <a href="{{ route('admin.atracciones.index') }}">Panel</a>
            </nav>
            <div class="auth-actions">
                @auth
                    <div class="user-pill">
                        <strong>{{ auth()->user()->name }}</strong>
                        <span>{{ auth()->user()->email }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn ghost">Cerrar sesión</button>
                    </form>
                @else
                    <a class="btn ghost" href="{{ route('login') }}">Iniciar sesión</a>
                @endauth
            </div>
        </header>
        <main>
            <div class="site-container">
                @if (session('status'))
                    <div class="flash-message">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="flash-message flash-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
        <footer>
            © {{ date('Y') }} Park360. Crea experiencias memorables con una vista 360° del parque.
        </footer>
    </div>
</body>
</html>
