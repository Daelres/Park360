@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Registrar incidente</h1>
        <form method="POST" action="{{ route('incidents.store') }}">
            @include('incidents._form', ['incident' => new \App\Models\Incident(), 'attractions' => $attractions, 'employees' => $employees])
        </form>
    </div>
@endsection
