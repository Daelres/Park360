@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
            <h1>{{ $sede->nombre }}</h1>
            <p style="color:#4b5563;">Código {{ $sede->codigo }} · {{ $sede->ciudad }}</p>
        </div>
        <div style="display:flex; gap:0.75rem;">
            <a class="btn secondary" href="{{ route('admin.sedes.edit', $sede) }}">Editar</a>
            <form method="POST" action="{{ route('admin.sedes.destroy', $sede) }}" onsubmit="return confirm('¿Deseas eliminar esta sede?');">
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
                <li><strong>Dirección:</strong> {{ $sede->direccion }}</li>
                <li><strong>Teléfono:</strong> {{ $sede->telefono ?? 'No registrado' }}</li>
                <li><strong>Correo:</strong> {{ $sede->correo_contacto ?? 'No registrado' }}</li>
                <li><strong>Gerente:</strong> {{ $sede->gerente ?? 'No registrado' }}</li>
            </ul>
            <p>{{ $sede->descripcion ?? 'Sin descripción detallada.' }}</p>
        </div>
        <div class="card">
            <h2>Atracciones registradas</h2>
            @if($sede->atracciones->isEmpty())
                <p>No hay atracciones asignadas aún.</p>
            @else
                <ul style="list-style:none; padding:0; margin:1rem 0; line-height:2;">
                    @foreach($sede->atracciones as $atraccion)
                        <li>
                            <a href="{{ route('admin.atracciones.show', $atraccion) }}">{{ $atraccion->nombre }}</a>
                            <span class="badge" style="margin-left:0.5rem;">{{ $atraccion->estado_operativo }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
            <a class="btn" href="{{ route('admin.atracciones.create', ['sede_id' => $sede->id]) }}">Añadir atracción</a>
        </div>
    </div>
@endsection
