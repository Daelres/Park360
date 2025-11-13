<x-guest-layout>
    <style>
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: oklch(0.55 0.25 280);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-subtitle {
            color: #718096;
            font-size: 0.95rem;
            margin: 0.5rem 0 0 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: oklch(0.55 0.25 280);
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 0.875rem;
            border: 2px solid oklch(0.9 0.02 280);
            border-radius: 0.875rem;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            outline: none;
            border-color: oklch(0.55 0.25 280);
            box-shadow: inset 0 0 0 1px rgba(147, 105, 245, 0.2);
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1.5rem 0;
            font-size: 0.85rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-me label {
            cursor: pointer;
            margin: 0;
            color: #4b5563;
        }

        .forgot-password {
            color: oklch(0.55 0.25 280);
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 1rem;
            background: oklch(0.55 0.25 280);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 900;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
        }

        .login-button:hover {
            background: oklch(0.50 0.25 280);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0;
            color: #cbd5e0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #cbd5e0;
        }

        .quick-access {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .quick-access-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            border: 3px solid;
            border-radius: 1rem;
            background: white;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .quick-access-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .quick-access-btn i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .quick-access-btn.admin {
            background: oklch(0.92 0.08 130);
            border: 3px solid oklch(0.82 0.25 130);
        }

        .quick-access-btn.admin i {
            background: oklch(0.82 0.25 130);
            color: white;
        }

        .quick-access-btn.admin:hover {
            background: oklch(0.88 0.1 130);
        }

        .quick-access-btn.visitor {
            background: #FFE8E0;
            border: 3px solid #FF6B35;
        }

        .quick-access-btn.visitor i {
            background: #FF6B35;
            color: white;
        }

        .quick-access-btn.visitor:hover {
            background: #FFD9CC;
        }

        .back-home {
            text-align: center;
            margin-top: 2rem;
        }

        .back-home a {
            color: oklch(0.55 0.25 280);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .back-home a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #FF6B35;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .auth-link p {
            margin: 0 0 0.5rem 0;
            color: #4b5563;
            font-size: 0.9rem;
        }

        .auth-link a {
            color: oklch(0.55 0.25 280);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }
    </style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-header">
        <div style="margin-bottom: 1rem;">
            <img src="{{ asset('images/ChatGPT Image 12 nov 2025, 23_37_27.png') }}" alt="Park360 Logo" style="max-width: 120px; height: auto; margin: 0 auto; display: block;">
        </div>
        <p class="login-subtitle">Inicio de sesión - Park360</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-envelope"></i>
                {{ __('Correo Electrónico') }}
            </label>
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-lock"></i>
                {{ __('Contraseña') }}
            </label>
            <x-text-input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-actions">
            <label class="remember-me">
                <input id="remember_me" type="checkbox" name="remember">
                <span>{{ __('Recuérdame') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <button type="submit" class="login-button">
            <i class="fas fa-sign-in-alt"></i> Entrar
        </button>
    </form>

    <div class="auth-link">
        <p style="margin: 0; color: #4b5563; font-size: 0.9rem;">¿Aún no tienes cuenta?</p>
        <a href="{{ route('register') }}">
            Regístrate aquí
        </a>
    </div>

    <div class="back-home">
        <a href="/">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>
    </div>
</x-guest-layout>
