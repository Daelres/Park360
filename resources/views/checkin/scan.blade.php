@extends('layouts.app')

@section('content')
    <div class="card" style="max-width:600px;">
        <h1>Check-in de visitantes</h1>
        @include('partials.errors')
        <form method="POST" action="{{ route('check-in.store') }}">
            @csrf
            <div class="field">
                <label>Código de ticket</label>
                <input type="text" name="code" required autofocus>
            </div>
            <div class="field">
                <label>Ubicación</label>
                <input type="text" name="location" value="{{ old('location') }}">
            </div>
            <div class="field">
                <label>Dispositivo</label>
                <input type="text" name="device" value="{{ old('device') }}">
            </div>
            <button type="submit" class="btn">Registrar ingreso</button>
        </form>
    </div>
@endsection
