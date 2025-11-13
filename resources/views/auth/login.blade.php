@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 480px; margin: 0 auto;">
        <h1 style="margin-bottom: 1rem;">Iniciar sesión</h1>
        @include('partials.errors')
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="field">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="field" style="display:flex; align-items:center; gap:0.5rem;">
                <input type="checkbox" id="remember" name="remember" style="width:auto;">
                <label for="remember" style="margin:0;">Mantener sesión iniciada</label>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Ingresar</button>
        </form>
    </div>
@endsection
