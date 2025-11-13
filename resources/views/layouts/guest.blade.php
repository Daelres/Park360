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
            }
            
            .auth-container {
                background: white;
                border-radius: 1.25rem;
                padding: 2.5rem;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                border: 4px solid oklch(0.82 0.25 130);
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
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="auth-logo">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current" style="color: white; width: 160px; height: 160px;" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 auth-container">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
