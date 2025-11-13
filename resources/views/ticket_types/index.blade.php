@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Tipos de entrada</h1>
            <a class="btn" href="{{ route('ticket-types.create') }}">Nuevo tipo</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Días</th>
                    <th>Activo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ticketTypes as $ticketType)
                    <tr>
                        <td>{{ $ticketType->name }}</td>
                        <td>${{ number_format($ticketType->price, 0, ',', '.') }}</td>
                        <td>{{ $ticketType->validity_days }}</td>
                        <td>{{ $ticketType->is_active ? 'Sí' : 'No' }}</td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('ticket-types.edit', $ticketType) }}">Editar</a>
                            <form method="POST" action="{{ route('ticket-types.destroy', $ticketType) }}" onsubmit="return confirm('¿Eliminar tipo de entrada?');">
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
            {{ $ticketTypes->links() }}
        </div>
    </div>
@endsection
