@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>{{ $attraction->name }}</h1>
        <p><strong>Estado:</strong> {{ ucfirst($attraction->status) }}</p>
        <p><strong>Capacidad:</strong> {{ $attraction->capacity }}</p>
        <p><strong>Descripción:</strong> {{ $attraction->description }}</p>
        <p><strong>Personal asignado:</strong> {{ $attraction->employees->pluck('full_name')->join(', ') ?: 'Sin asignar' }}</p>
        <h3>Incidentes</h3>
        <ul>
            @forelse ($attraction->incidents as $incident)
                <li>{{ $incident->reported_at?->format('Y-m-d') }} - {{ $incident->title }} ({{ $incident->severity }})</li>
            @empty
                <li>No hay incidentes registrados.</li>
            @endforelse
        </ul>
        <h3>Mantenimientos</h3>
        <ul>
            @forelse ($attraction->maintenances as $maintenance)
                <li>{{ $maintenance->scheduled_for?->format('Y-m-d') }} - {{ $maintenance->status }}</li>
            @empty
                <li>No hay mantenimientos programados.</li>
            @endforelse
        </ul>
        <a class="btn secondary" href="{{ route('attractions.index') }}">Volver</a>
    </div>
@endsection
