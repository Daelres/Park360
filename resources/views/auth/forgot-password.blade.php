<x-guest-layout>
    <style>
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.8rem;
            font-weight: 900;
            color: oklch(0.55 0.25 280);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .auth-subtitle {
            color: #718096;
            font-size: 0.95rem;
            margin: 0.5rem 0 0 0;
        }

        .info-message {
            background: oklch(0.96 0.03 300);
            border-left: 4px solid oklch(0.82 0.25 130);
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #4b5563;
            line-height: 1.6;
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

        .submit-button {
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

        .submit-button:hover {
            background: oklch(0.50 0.25 280);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
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

        .error-message {
            color: #FF6B35;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        .back-home {
            text-align: center;
            margin-top: 1rem;
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
    </style>

    <div class="auth-header">
        <div style="margin-bottom: 1rem;">
            <img src="{{ asset('images/ChatGPT Image 12 nov 2025, 23_37_27.png') }}" alt="Park360 Logo" style="max-width: 120px; height: auto; margin: 0 auto; display: block;">
        </div>
        <p class="auth-subtitle">Recuperar contraseña - Park360</p>
    </div>

    <div class="info-message">
        <i class="fas fa-info-circle"></i> Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-envelope"></i>
                {{ __('Correo Electrónico') }}
            </label>
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus />
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-button">
            <i class="fas fa-paper-plane"></i> Enviar enlace
        </button>

        <div class="auth-link">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left"></i> Volver a iniciar sesión
            </a>
        </div>

        <div class="back-home">
            <a href="/">
                <i class="fas fa-arrow-left"></i> Volver al inicio
            </a>
        </div>
    </form>
</x-guest-layout>
