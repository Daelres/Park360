@extends('layouts.app')

@section('content')
    <section class="hero">
        <div>
            <h1>Bienvenido, {{ $user->name }}</h1>
            <p>Gestiona las operaciones del parque desde un único panel seguro.</p>
        </div>
        <div class="card" style="background: linear-gradient(135deg, #1d4ed8, #1e3a8a); color: white;">
            <h2>Ventas recientes</h2>
            <p style="font-size: 2rem; font-weight: 700;">${{ number_format($sales['total_amount'] ?? 0, 0, ',', '.') }}</p>
            <p>{{ $sales['tickets_sold'] ?? 0 }} boletos vendidos en la última semana.</p>
        </div>
    </section>

    <div class="grid grid-3">
        <div class="card">
            <h3>Asistencia hoy ({{ $attendance['date'] }})</h3>
            <p><strong>Presentes:</strong> {{ $attendance['present'] }}</p>
            <p><strong>Ausentes:</strong> {{ $attendance['absent'] }}</p>
        </div>
        <div class="card">
            <h3>Promedio de satisfacción</h3>
            <p style="font-size: 2rem;">{{ number_format($attractions['average_satisfaction'] ?? 0, 2) }}</p>
        </div>
        <div class="card">
            <h3>Atajos rápidos</h3>
            <p><a class="btn" href="{{ route('orders.create') }}">Registrar venta</a></p>
            <p><a class="btn secondary" href="{{ route('check-in.create') }}">Check-in visitantes</a></p>
        </div>
    </div>
@endsection
