<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Park360</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #1d4ed8;
            --primary-dark: #1e3a8a;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-600: #4b5563;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Nunito', Arial, sans-serif;
            background: var(--gray-100);
            color: #111827;
            display: flex;
            min-height: 100vh;
        }

        a { color: inherit; text-decoration: none; }

        header {
            background: white;
            border-right: 1px solid var(--gray-200);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 260px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary);
            margin-bottom: 2rem;
            width: 100%;
        }

        nav {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        nav a {
            margin-left: 0;
            margin-bottom: 0.75rem;
            font-weight: 600;
            color: var(--gray-600);
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        nav a i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        nav a:hover {
            color: var(--primary);
            background: rgba(29, 78, 216, 0.1);
        }

        main {
            padding: 2rem;
            margin-left: 260px;
            flex: 1;
            width: calc(100% - 260px);
        }

        .card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            background: var(--primary);
            color: white;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn.secondary {
            background: var(--gray-200);
            color: #111827;
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        .flash-message {
            background: #ecfccb;
            color: #3f6212;
            border: 1px solid #a3e635;
            padding: 1rem 1.5rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
        }

        form .field {
            margin-bottom: 1rem;
        }

        form label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        form input,
        form select,
        form textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid var(--gray-200);
            font-size: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 1rem;
            overflow: hidden;
        }

        th, td {
            padding: 1rem;
            text-align: left;
        }

        th {
            background: var(--gray-100);
            font-size: 0.95rem;
        }

        tr + tr {
            border-top: 1px solid var(--gray-200);
        }

        .table-actions {
            display: flex;
            gap: 0.75rem;
        }

        .badge {
            display: inline-flex;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            background: rgba(29, 78, 216, 0.12);
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 0.85rem;
        }

        .grid {
            display: grid;
            gap: 1.5rem;
        }

        .grid-3 {
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        }

        .grid-2 {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .hero {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            align-items: center;
            margin-bottom: 2rem;
        }

        .hero h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
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

        @media (max-width: 768px) {
            header {
                width: 100%;
                height: auto;
                position: static;
                border-right: none;
                border-bottom: 1px solid var(--gray-200);
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
            }

            nav {
                flex-direction: row;
            }

            nav a {
                margin-bottom: 0;
                margin-left: 1rem;
            }

            main {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="logo">PARK <span style="color: var(--primary-dark)">360</span></div>
        <nav>
            <a href="{{ route('public.home') }}"><i class="fas fa-star"></i> Atracciones</a>
            <a href="{{ route('public.plans') }}"><i class="fas fa-ticket"></i> Entradas</a>
            <a href="{{ route('payments.create') }}"><i class="fas fa-credit-card"></i> Pagos</a>
            <a href="{{ route('admin.sedes.index') }}"><i class="fas fa-building"></i> Admin Sedes</a>
            <a href="{{ route('admin.atracciones.index') }}"><i class="fas fa-sliders-h"></i> Admin Atracciones</a>
        </nav>
    </header>
    <main>
        @if (session('status'))
            <div class="flash-message">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
