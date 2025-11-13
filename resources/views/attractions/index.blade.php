@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Atracciones</h1>
            <a class="btn" href="{{ route('attractions.create') }}">Nueva atracción</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Capacidad</th>
                    <th>Incidentes</th>
                    <th>Mantenimientos</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attractions as $attraction)
                    <tr>
                        <td>{{ $attraction->name }}</td>
                        <td><span class="badge">{{ ucfirst($attraction->status) }}</span></td>
                        <td>{{ $attraction->capacity }}</td>
                        <td>{{ $attraction->incidents_count }}</td>
                        <td>{{ $attraction->maintenances_count }}</td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('attractions.edit', $attraction) }}">Editar</a>
                            <a class="btn secondary" href="{{ route('attractions.show', $attraction) }}">Detalle</a>
                            <form method="POST" action="{{ route('attractions.destroy', $attraction) }}" onsubmit="return confirm('¿Eliminar atracción?');">
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
            {{ $attractions->links() }}
        </div>
    </div>
@endsection
