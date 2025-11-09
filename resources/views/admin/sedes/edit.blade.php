@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Editar sede</h1>
        <p style="color:#4b5563;">Actualiza la información de la sede.</p>
        <form method="POST" action="{{ route('admin.sedes.update', $sede) }}" style="margin-top:1.5rem; display:grid; gap:1rem;">
            @method('PUT')
            @include('admin.sedes.form', ['sede' => $sede])
            <div style="display:flex; gap:1rem;">
                <button class="btn" type="submit">Actualizar</button>
                <a class="btn secondary" href="{{ route('admin.sedes.show', $sede) }}">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
