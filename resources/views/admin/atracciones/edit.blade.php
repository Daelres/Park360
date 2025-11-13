@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar atracción</h1>
        <p style="color:#4b5563;">Actualiza los datos de la atracción.</p>
        <form method="POST" action="{{ route('admin.atracciones.update', $atraccion) }}" style="margin-top:1.5rem; display:grid; gap:1rem;">
            @method('PUT')
            @include('admin.atracciones.form')
            <div style="display:flex; gap:1rem;">
                <button class="btn" type="submit">Actualizar</button>
                <a class="btn secondary" href="{{ route('admin.atracciones.show', $atraccion) }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
