@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Nueva atracción</h1>
        <form method="POST" action="{{ route('attractions.store') }}">
            @include('attractions._form', ['attraction' => new \App\Models\Attraction(), 'employees' => $employees])
        </form>
    </div>
@endsection
