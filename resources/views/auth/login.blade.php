@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 480px; margin: 0 auto;">
        <h1 class="page-title" style="margin-top: 0; text-align:center;">Inicia sesión</h1>
        <p style="text-align: center; color: #475569; margin-bottom: 2rem;">
            Accede al panel administrativo para gestionar sedes y atracciones.
        </p>
        <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:1rem;">
            @csrf
            <div class="field">
                <label for="email">Correo electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Contraseña</label>
                <input id="password" type="password" name="password" required>
            </div>

            <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.95rem;">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Recordarme en este dispositivo
            </label>

            <button type="submit" class="btn" style="width:100%;">Ingresar</button>
        </form>
    </div>
@endsection
