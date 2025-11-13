@extends('layouts.app')

@section('content')
    <div class="card" style="max-width: 520px; margin: 0 auto;">
        <h1 style="margin-bottom: 1rem;">Crear cuenta</h1>
        @include('partials.errors')
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="field">
                <label for="name">Nombre completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="field">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="field">
                <label for="password_confirmation">Confirmar contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Registrarme</button>
        </form>
    </div>
@endsection
