@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Nuevo empleado</h1>
        <form method="POST" action="{{ route('employees.store') }}">
            @include('employees._form', ['employee' => new \App\Models\Employee(), 'attractions' => $attractions])
        </form>
    </div>
@endsection
