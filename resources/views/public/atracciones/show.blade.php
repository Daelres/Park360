@extends('layouts.app')

@section('content')
    <div class="grid grid-2">
        <div class="card">
            <img src="{{ $atraccion->imagen_url ?? 'https://images.unsplash.com/photo-1542317854-0d6bd4aea02b?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $atraccion->nombre }}" style="width: 100%; border-radius: 1rem; max-height: 320px; object-fit: cover;">
        </div>
        <div class="card">
            <h1>{{ $atraccion->nombre }}</h1>
            @if($atraccion->sede)
                <p style="color:#4b5563;">Ubicada en la sede {{ $atraccion->sede->nombre }} ({{ $atraccion->sede->ciudad }})</p>
            @endif
            <p style="margin-top: 1rem;">{{ $atraccion->descripcion ?? 'Próximamente más información.' }}</p>
            <div style="margin-top: 1.5rem; display:grid; gap:0.5rem;">
                <span class="badge">Tipo: {{ $atraccion->tipo ?? 'General' }}</span>
                <span class="badge">Capacidad: {{ $atraccion->capacidad }} personas</span>
                <span class="badge">Estado: {{ $atraccion->estado_operativo }}</span>
                @if($atraccion->altura_minima)
                    <span class="badge">Estatura mínima: {{ $atraccion->altura_minima }} cm</span>
                @endif
            </div>
            <div style="margin-top: 2rem; display:flex; gap: 1rem;">
                <a class="btn" href="{{ route('public.plans') }}">Comprar entradas</a>
                <a class="btn secondary" href="{{ route('public.home', ['sede_id' => $atraccion->sede_id]) }}">Volver</a>
            </div>
        </div>
    </div>
@endsection
