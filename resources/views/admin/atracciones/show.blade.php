@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
            <h1>{{ $atraccion->nombre }}</h1>
            <p style="color:#4b5563;">{{ $atraccion->sede->nombre ?? 'Sede no asignada' }}</p>
        </div>
        <div style="display:flex; gap:0.75rem;">
            <a class="btn secondary" href="{{ route('admin.atracciones.edit', $atraccion) }}">Editar</a>
            <form method="POST" action="{{ route('admin.atracciones.destroy', $atraccion) }}" onsubmit="return confirm('¿Eliminar atracción?');">
                @csrf
                @method('DELETE')
                <button class="btn secondary" type="submit">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h2>Información general</h2>
            <ul style="list-style:none; padding:0; margin:1rem 0; line-height:2;">
                <li><strong>Tipo:</strong> {{ $atraccion->tipo ?? 'General' }}</li>
                <li><strong>Capacidad:</strong> {{ $atraccion->capacidad }} personas</li>
                <li><strong>Estado:</strong> {{ $atraccion->estado_operativo }}</li>
                <li><strong>Estatura mínima:</strong> {{ $atraccion->altura_minima ? $atraccion->altura_minima . ' cm' : 'Sin restricción' }}</li>
            </ul>
            <p>{{ $atraccion->descripcion ?? 'Sin descripción adicional.' }}</p>
        </div>
        <div class="card">
            <h2>Vista previa</h2>
            <img src="{{ $atraccion->imagen_url ?? 'https://images.unsplash.com/photo-1542317854-0d6bd4aea02b?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $atraccion->nombre }}" style="width:100%; border-radius:1rem; max-height:320px; object-fit:cover;">
            <div style="margin-top:1.5rem; display:flex; gap:1rem;">
                <a class="btn" href="{{ route('public.atracciones.show', $atraccion) }}">Ver como cliente</a>
                <a class="btn secondary" href="{{ route('admin.atracciones.index') }}">Volver al listado</a>
            </div>
        </div>
    </div>
@endsection
