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
            --primary: #93B5F5;
            --primary-dark: #7B9FF5;
            --secondary: #AF93F5;
            --tertiary: #9396F5;
            --accent: #FF6B9D;
            --success: #4ECDC4;
            --warning: #FFE66D;
            --gray-100: #F5F3FF;
            --gray-200: #E8E4F3;
            --gray-600: #6B5B8F;
            --dark: #2D1B69;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Nunito', Arial, sans-serif;
            background: linear-gradient(135deg, #F5F3FF 0%, #F0E6FF 100%);
            color: #2D1B69;
            display: flex;
            min-height: 100vh;
        }

        a { color: inherit; text-decoration: none; }

        header {
            background: linear-gradient(135deg, white 0%, #F5F3FF 100%);
            border-right: 3px solid var(--primary);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 260px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 20px rgba(147, 181, 245, 0.15);
        }

        .logo {
            margin-bottom: 2rem;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo svg {
            width: 100%;
            height: auto;
            max-width: 200px;
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
            transition: all 0.3s ease;
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
            color: white;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(147, 181, 245, 0.3);
        }

        main {
            padding: 2rem;
            margin-left: 260px;
            flex: 1;
            width: calc(100% - 260px);
        }

        .card {
            background: white;
            border-radius: 1.2rem;
            padding: 1.5rem;
            box-shadow: 0 10px 40px rgba(147, 181, 245, 0.12);
            border: 1px solid rgba(147, 181, 245, 0.1);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 15px 50px rgba(147, 181, 245, 0.18);
            transform: translateY(-2px);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(147, 181, 245, 0.3);
        }

        .btn.secondary {
            background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-100) 100%);
            color: var(--dark);
            box-shadow: 0 2px 8px rgba(147, 181, 245, 0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(147, 181, 245, 0.4);
        }

        .btn.secondary:hover {
            box-shadow: 0 4px 15px rgba(147, 181, 245, 0.2);
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
            background: linear-gradient(135deg, rgba(147, 181, 245, 0.15) 0%, rgba(175, 147, 245, 0.15) 100%);
            color: var(--dark);
            font-weight: 700;
            font-size: 0.85rem;
            border: 1px solid rgba(147, 181, 245, 0.3);
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
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--tertiary) 100%);
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            box-shadow: 0 30px 80px rgba(147, 181, 245, 0.2);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 2rem;
            align-items: center;
            margin-bottom: 2rem;
            color: white;
        }

        .hero h1 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            font-weight: 800;
            letter-spacing: 0.5px;
        }

        .hero p {
            font-size: 1.05rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.95);
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
        <div class="logo">
            <svg viewBox="0 0 300 280" xmlns="http://www.w3.org/2000/svg">
                <!-- Ferris Wheel Main Circle -->
                <circle cx="150" cy="90" r="70" fill="none" stroke="#7B68D9" stroke-width="5"/>
                
                <!-- Ferris Wheel Spokes (8 main spokes) -->
                <g stroke="#7B68D9" stroke-width="3">
                    <line x1="150" y1="20" x2="150" y2="90"/>
                    <line x1="150" y1="160" x2="150" y2="90"/>
                    <line x1="80" y1="90" x2="150" y2="90"/>
                    <line x1="220" y1="90" x2="150" y2="90"/>
                    
                    <!-- Diagonal spokes -->
                    <line x1="100" y1="40" x2="150" y2="90"/>
                    <line x1="200" y1="40" x2="150" y2="90"/>
                    <line x1="100" y1="140" x2="150" y2="90"/>
                    <line x1="200" y1="140" x2="150" y2="90"/>
                </g>
                
                <!-- Ferris Wheel Cabins - Top -->
                <circle cx="150" cy="20" r="10" fill="url(#grad1)"/>
                <circle cx="185" cy="35" r="10" fill="#FFD700"/>
                <circle cx="205" cy="60" r="10" fill="#FF6B6B"/>
                <circle cx="205" cy="120" r="10" fill="#4ECDC4"/>
                <circle cx="185" cy="145" r="10" fill="#FFD700"/>
                <circle cx="150" cy="160" r="10" fill="#00BCD4"/>
                <circle cx="115" cy="145" r="10" fill="#4ECDC4"/>
                <circle cx="95" cy="120" r="10" fill="#FF6B6B"/>
                <circle cx="95" cy="60" r="10" fill="#FFD700"/>
                <circle cx="115" cy="35" r="10" fill="#4ECDC4"/>
                
                <!-- Ferris Wheel Center -->
                <circle cx="150" cy="90" r="12" fill="#7B68D9" stroke="#9B88E9" stroke-width="2"/>
                
                <!-- Gradients for cabins -->
                <defs>
                    <linearGradient id="grad1">
                        <stop offset="0%" style="stop-color:#00BCD4;stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#4ECDC4;stop-opacity:1" />
                    </linearGradient>
                </defs>
                
                <!-- Roller Coaster Left (Red) -->
                <path d="M 30 180 Q 70 130 90 160 Q 100 180 110 190" fill="none" stroke="#FF6B6B" stroke-width="6" stroke-linecap="round"/>
                <path d="M 35 188 Q 70 145 95 168" fill="none" stroke="#FFD700" stroke-width="3" stroke-linecap="round"/>
                
                <!-- Roller Coaster Right (Turquesa/Verde) -->
                <path d="M 270 180 Q 230 130 210 160 Q 200 180 190 190" fill="none" stroke="#00BCD4" stroke-width="6" stroke-linecap="round"/>
                <path d="M 265 188 Q 230 145 205 168" fill="none" stroke="#4ECDC4" stroke-width="3" stroke-linecap="round"/>
                
                <!-- Park Text with multiple colors -->
                <text x="60" y="260" font-size="50" font-weight="900" fill="#FF6B6B">P</text>
                <text x="95" y="260" font-size="50" font-weight="900" fill="#FFD700">a</text>
                <text x="125" y="260" font-size="50" font-weight="900" fill="#4ECDC4">r</text>
                <text x="150" y="260" font-size="50" font-weight="900" fill="#00BCD4">k</text>
                <text x="185" y="260" font-size="50" font-weight="900" fill="#93B5F5">3</text>
                <text x="215" y="260" font-size="50" font-weight="900" fill="#7B68D9">6</text>
                <text x="240" y="260" font-size="50" font-weight="900" fill="#AF93F5">0</text>
                
                <!-- Decorative Stars -->
                <path d="M 20 50 L 25 60 L 35 60 L 27 67 L 30 77 L 20 70 L 10 77 L 13 67 L 5 60 L 15 60 Z" fill="#FFD700"/>
                <path d="M 280 60 L 283 68 L 291 68 L 285 73 L 287 81 L 280 76 L 273 81 L 275 73 L 269 68 L 277 68 Z" fill="#4ECDC4"/>
                <path d="M 18 200 L 20 205 L 25 205 L 21 209 L 23 214 L 18 210 L 13 214 L 15 209 L 11 205 L 16 205 Z" fill="#FF6B6B"/>
                <path d="M 280 200 L 283 207 L 290 207 L 284 212 L 287 219 L 280 214 L 273 219 L 276 212 L 270 207 L 277 207 Z" fill="#4ECDC4"/>
                
                <!-- Small circles decoration -->
                <circle cx="45" cy="40" r="3" fill="#FFD700"/>
                <circle cx="250" cy="220" r="3" fill="#4ECDC4"/>
                <circle cx="280" cy="250" r="2" fill="#FF6B6B"/>
            </svg>
        </div>
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

    @stack('scripts')
</body>
</html>
