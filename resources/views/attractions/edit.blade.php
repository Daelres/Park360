@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar atracción</h1>
        <form method="POST" action="{{ route('attractions.update', $attraction) }}">
            @method('PUT')
            @include('attractions._form', ['attraction' => $attraction, 'employees' => $employees])
        </form>
    </div>
@endsection
