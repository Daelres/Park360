@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Tareas operativas</h1>
            <a class="btn" href="{{ route('tasks.create') }}">Nueva tarea</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Atracción</th>
                    <th>Frecuencia</th>
                    <th>Estado</th>
                    <th>Programada</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->attraction->name }}</td>
                        <td>{{ $task->frequency }}</td>
                        <td><span class="badge">{{ $task->status }}</span></td>
                        <td>{{ $task->scheduled_for?->format('Y-m-d H:i') }}</td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('tasks.edit', $task) }}">Editar</a>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('¿Eliminar tarea?');">
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
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
