@extends('layouts.app')

@section('content')
    <div class="hero">
        <div>
            <h1>Bienvenido a Park360</h1>
            <p>Explora nuestras atracciones y descubre experiencias inolvidables para toda la familia.</p>

            <div class="select-inline mt-4">
                <form method="GET" action="{{ route('public.home') }}">
                    <label for="sede_id" class="fw-semibold me-2">Seleccionar sede</label>

                    <select id="sede_id" name="sede_id" class="form-select d-inline-block w-auto"
                            style="min-width: 220px; color: #0a0a0a"
                            onchange="this.form.submit()">

                        {{-- Valor por defecto --}}
                        <option value="" disabled @selected(!$selectedSedeId)>
                            -- Seleccione --
                        </option>

                        {{-- Opciones reales --}}
                        @foreach($sedes as $sede)
                            <option value="{{ $sede->id }}" @selected($sede->id == $selectedSedeId)>
                                {{ $sede->nombre }} - {{ $sede->ciudad }}
                            </option>
                        @endforeach

                    </select>
                </form>
            </div>
        </div>

        <img src="https://images.unsplash.com/photo-1534447677768-be436bb09401?auto=format&fit=crop&w=800&q=80"
             alt="Parque de atracciones"
             style="width: 100%; border-radius: 1rem; object-fit: cover; max-height: 260px;">
    </div>

    @if($atracciones->isEmpty())
        <div class="card">
            <p>No hay atracciones registradas para esta sede todavía.</p>
        </div>
    @else
        <div class="grid grid-3">
            @foreach($atracciones as $atraccion)
                <div class="card">
                    <img
                        src="{{ $atraccion->imagen_url ?? 'https://images.unsplash.com/photo-1520880867055-1e30d1cb001c?auto=format&fit=crop&w=800&q=80' }}"
                        alt="{{ $atraccion->nombre }}"
                        style="width: 100%; height: 180px; object-fit: cover; border-radius: 1rem;">
                    <h2 style="margin-top: 1rem; margin-bottom: 0.5rem;">{{ $atraccion->nombre }}</h2>
                    <p style="color: #4b5563;">{{ \Illuminate\Support\Str::limit($atraccion->descripcion, 110) }}</p>
                    <div style="margin: 1rem 0; display:flex; justify-content: space-between;">
                        <span class="badge">Tipo: {{ $atraccion->tipo ?? 'General' }}</span>
                        @if($atraccion->altura_minima)
                            <span class="badge">Estatura mínima: {{ $atraccion->altura_minima }} cm</span>
                        @endif
                    </div>
                    <a class="btn" href="{{ route('public.atracciones.show', $atraccion) }}">Ver detalles</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
