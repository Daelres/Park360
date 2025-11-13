@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar incidente</h1>
        <form method="POST" action="{{ route('incidents.update', $incident) }}">
            @method('PUT')
            @include('incidents._form', ['incident' => $incident, 'attractions' => $attractions, 'employees' => $employees])
        </form>
    </div>
@endsection
