@extends('layouts.app')

@section('content')
    <h1>Editar Reporte</h1>
    <p style="color:#4b5563; margin-bottom:1rem;">Actualiza la información del reporte.</p>

    <form method="POST" action="{{ route('admin.reportes.update', $reporte) }}">
        @method('PUT')
        @include('admin.reportes.form', ['reporte' => $reporte])
    </form>
@endsection
