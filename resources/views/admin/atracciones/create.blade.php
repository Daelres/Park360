@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Nueva atracción</h1>
        <p style="color:#4b5563;">Registra una nueva atracción y asígnala a una sede.</p>
        <form method="POST" action="{{ route('admin.atracciones.store') }}" style="margin-top:1.5rem; display:grid; gap:1rem;">
            @include('admin.atracciones.form')
            <div style="display:flex; gap:1rem;">
                <button class="btn" type="submit">Guardar</button>
                <a class="btn secondary" href="{{ route('admin.atracciones.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
