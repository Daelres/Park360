@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Mantenimientos</h1>
            <a class="btn" href="{{ route('maintenances.create') }}">Programar mantenimiento</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Atracción</th>
                    <th>Estado</th>
                    <th>Programado</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($maintenances as $maintenance)
                    <tr>
                        <td>{{ $maintenance->attraction->name }}</td>
                        <td><span class="badge">{{ $maintenance->status }}</span></td>
                        <td>{{ $maintenance->scheduled_for?->format('Y-m-d H:i') }}</td>
                        <td>{{ $maintenance->started_at?->format('Y-m-d H:i') }}</td>
                        <td>{{ $maintenance->completed_at?->format('Y-m-d H:i') }}</td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('maintenances.edit', $maintenance) }}">Editar</a>
                            <form method="POST" action="{{ route('maintenances.destroy', $maintenance) }}" onsubmit="return confirm('¿Eliminar mantenimiento?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn secondary">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">
            {{ $maintenances->links() }}
        </div>
    </div>
@endsection
