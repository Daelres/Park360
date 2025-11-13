<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Park360') }}</title>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                background: oklch(0.55 0.25 280);
                background-image: 
                    radial-circle at 20% 30%, oklch(0.7 0.25 40) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, oklch(0.82 0.25 130) 0%, transparent 50%);
                font-family: 'Fredoka', 'Nunito', Arial, sans-serif;
                position: relative;
                overflow: hidden;
            }

            body::before,
            body::after {
                content: '';
                position: fixed;
                border-radius: 50%;
                opacity: 0.15;
                pointer-events: none;
            }

            .decorative-circle {
                position: fixed;
                border-radius: 50%;
                opacity: 0.12;
                pointer-events: none;
            }

            @keyframes float-slow {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-25px); }
            }

            .circle-1 {
                width: 150px;
                height: 150px;
                background: oklch(0.82 0.25 130);
                top: 10%;
                left: 5%;
                animation: float-slow 8s ease-in-out infinite;
            }

            .circle-2 {
                width: 200px;
                height: 200px;
                background: #00BCD4;
                bottom: 15%;
                right: 10%;
                animation: float-slow 10s ease-in-out infinite 1s;
            }

            .circle-3 {
                width: 100px;
                height: 100px;
                background: #FF6B35;
                top: 60%;
                right: 8%;
                animation: float-slow 9s ease-in-out infinite 2s;
            }

            .circle-4 {
                width: 120px;
                height: 120px;
                background: #FF1493;
                top: 20%;
                right: 15%;
                animation: float-slow 11s ease-in-out infinite 0.5s;
            }

            .circle-5 {
                width: 80px;
                height: 80px;
                background: #00A6E0;
                bottom: 20%;
                left: 12%;
                animation: float-slow 8.5s ease-in-out infinite 1.5s;
            }

            .circle-6 {
                width: 140px;
                height: 140px;
                background: oklch(0.82 0.25 130);
                bottom: 5%;
                right: 25%;
                animation: float-slow 10.5s ease-in-out infinite 2.5s;
            }
            
            .auth-container {
                background: white;
                border-radius: 1.25rem;
                padding: 2rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                border: 4px solid oklch(0.82 0.25 130);
                position: relative;
                z-index: 10;
            }
            
            .auth-logo {
                animation: bounce-gentle 3s ease-in-out infinite;
                filter: drop-shadow(3px 3px 0px rgba(0, 0, 0, 0.2));
            }
            
            @keyframes bounce-gentle {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-10px); }
            }
        </style>
    </head>
    <body class="font-sans antialiased" style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
        <!-- Círculos decorativos -->
        <div class="decorative-circle circle-1"></div>
        <div class="decorative-circle circle-2"></div>
        <div class="decorative-circle circle-3"></div>
        <div class="decorative-circle circle-4"></div>
        <div class="decorative-circle circle-5"></div>
        <div class="decorative-circle circle-6"></div>

        <div class="auth-container" style="max-width: 450px; width: 100%; margin: 0 auto; padding: 0 1rem;">
            {{ $slot }}
        </div>
    </body>
</html>
