<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Park360') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
        }

        a { color: inherit; text-decoration: none; }

        header {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary);
        }

        nav a {
            margin-left: 1rem;
            font-weight: 600;
            color: var(--gray-600);
        }

        nav a:hover {
            color: var(--primary);
        }

        main {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
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
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="logo">PARK <span style="color: var(--primary-dark)">360</span></div>
        <nav>
            <a href="{{ route('public.home') }}">Atracciones</a>
            <a href="{{ route('public.plans') }}">Entradas</a>
            <a href="{{ route('payments.create') }}">Pagos</a>
            <a href="{{ route('admin.sedes.index') }}">Admin Sedes</a>
            <a href="{{ route('admin.atracciones.index') }}">Admin Atracciones</a>
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

    @stack('scripts')
</body>
</html>
