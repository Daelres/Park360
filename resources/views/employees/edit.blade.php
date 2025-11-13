@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar empleado</h1>
        <form method="POST" action="{{ route('employees.update', $employee) }}">
            @method('PUT')
            @include('employees._form', ['employee' => $employee, 'attractions' => $attractions])
        </form>
    </div>
@endsection
