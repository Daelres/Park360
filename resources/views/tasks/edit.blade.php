@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar tarea</h1>
        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @method('PUT')
            @include('tasks._form', ['task' => $task, 'attractions' => $attractions, 'employees' => $employees])
        </form>
    </div>
@endsection
