@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Nueva sede</h1>
        <p style="color:#4b5563;">Completa la información para registrar una nueva sede.</p>
        <form method="POST" action="{{ route('admin.sedes.store') }}" style="margin-top:1.5rem; display:grid; gap:1rem;">
            @include('admin.sedes.form')
            <div style="display:flex; gap:1rem;">
                <button class="btn" type="submit">Guardar</button>
                <a class="btn secondary" href="{{ route('admin.sedes.index') }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
