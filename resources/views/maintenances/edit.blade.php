@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar mantenimiento</h1>
        <form method="POST" action="{{ route('maintenances.update', $maintenance) }}">
            @method('PUT')
            @include('maintenances._form', ['maintenance' => $maintenance, 'attractions' => $attractions, 'employees' => $employees])
        </form>
    </div>
@endsection
