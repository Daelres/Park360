@extends('layouts.app')

@section('content')
    <div class="hero">
        <div>
            <h1>Elige tu experiencia</h1>
            <p>Selecciona el pase ideal y prepárate para disfrutar sin límites.</p>
        </div>
        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80" alt="Planes" style="width: 100%; border-radius: 1rem; max-height: 240px; object-fit: cover;">
    </div>

    <div class="grid grid-3">
        @forelse($planes as $plan)
            <div class="card" style="display:flex; flex-direction:column; gap:1rem;">
                <h2 style="font-size:1.5rem;">{{ $plan->tipoTicket->nombre ?? 'Plan Park360' }}</h2>
                <p style="color:#4b5563;">{{ data_get($plan->regla, 'descripcion', 'Acceso ilimitado a las principales atracciones.') }}</p>
                <div style="font-size:2rem; font-weight:700;">${{ number_format($plan->precio, 0, ',', '.') }}</div>
                <a class="btn" href="{{ route('payments.create', ['plan' => $plan->tipoTicket->nombre ?? 'Plan Park360']) }}">Comprar</a>
            </div>
        @empty
            <div class="card">
                <p>Aún no hay planes de entradas configurados.</p>
            </div>
        @endforelse
    </div>
@endsection
