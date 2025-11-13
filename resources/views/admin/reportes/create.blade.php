@extends('layouts.app')

@section('content')
    <h1>Nuevo Reporte</h1>
    <p style="color:#4b5563; margin-bottom:1rem;">Agrega un nuevo reporte.</p>

    <form method="POST" action="{{ route('admin.reportes.store') }}">
        @include('admin.reportes.form', ['reporte' => null])
    </form>
@endsection
