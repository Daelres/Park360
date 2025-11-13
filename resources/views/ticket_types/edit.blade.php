@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar tipo de entrada</h1>
        <form method="POST" action="{{ route('ticket-types.update', $ticketType) }}">
            @method('PUT')
            @include('ticket_types._form', ['ticketType' => $ticketType])
        </form>
    </div>
@endsection
