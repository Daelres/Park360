@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Nuevo tipo de entrada</h1>
        <form method="POST" action="{{ route('ticket-types.store') }}">
            @include('ticket_types._form', ['ticketType' => new \App\Models\TicketType()])
        </form>
    </div>
@endsection
