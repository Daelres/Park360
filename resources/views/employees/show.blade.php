@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>{{ $employee->full_name }}</h1>
        <p><strong>Correo:</strong> {{ $employee->email }}</p>
        <p><strong>Teléfono:</strong> {{ $employee->phone }}</p>
        <p><strong>Cargo:</strong> {{ $employee->position }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($employee->status) }}</p>
        <p><strong>Atracciones:</strong> {{ $employee->attractions->pluck('name')->join(', ') ?: 'Sin asignar' }}</p>
        <p><strong>Tareas:</strong> {{ $employee->tasks->pluck('title')->join(', ') ?: 'Sin tareas asignadas' }}</p>
        <p><strong>Notas:</strong> {{ $employee->notes ?: 'N/A' }}</p>
        <a class="btn secondary" href="{{ route('employees.index') }}">Volver</a>
    </div>
@endsection
