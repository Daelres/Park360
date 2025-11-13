@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Nueva tarea</h1>
        <form method="POST" action="{{ route('tasks.store') }}">
            @include('tasks._form', ['task' => new \App\Models\Task(), 'attractions' => $attractions, 'employees' => $employees])
        </form>
    </div>
@endsection
