@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Incidentes</h1>
            <a class="btn" href="{{ route('incidents.create') }}">Registrar incidente</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Título</th>
                    <th>Atracción</th>
                    <th>Severidad</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($incidents as $incident)
                    <tr>
                        <td>{{ $incident->reported_at?->format('Y-m-d H:i') }}</td>
                        <td>{{ $incident->title }}</td>
                        <td>{{ $incident->attraction->name }}</td>
                        <td>{{ ucfirst($incident->severity) }}</td>
                        <td><span class="badge">{{ ucfirst($incident->status) }}</span></td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('incidents.edit', $incident) }}">Editar</a>
                            <form method="POST" action="{{ route('incidents.destroy', $incident) }}" onsubmit="return confirm('¿Eliminar incidente?');">
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
            {{ $incidents->links() }}
        </div>
    </div>
@endsection
