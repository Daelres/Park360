@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Programar mantenimiento</h1>
        <form method="POST" action="{{ route('maintenances.store') }}">
            @include('maintenances._form', ['maintenance' => new \App\Models\Maintenance(), 'attractions' => $attractions, 'employees' => $employees])
        </form>
    </div>
@endsection
