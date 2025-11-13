@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Empleados</h1>
            <a class="btn" href="{{ route('employees.create') }}">Nuevo empleado</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th>Atracciones</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->full_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->position }}</td>
                        <td><span class="badge">{{ ucfirst($employee->status) }}</span></td>
                        <td>{{ $employee->attractions->pluck('name')->join(', ') ?: 'Sin asignar' }}</td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('employees.edit', $employee) }}">Editar</a>
                            <a class="btn secondary" href="{{ route('employees.show', $employee) }}">Detalles</a>
                            <form method="POST" action="{{ route('employees.destroy', $employee) }}" onsubmit="return confirm('¿Eliminar empleado?');">
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
            {{ $employees->links() }}
        </div>
    </div>
@endsection
