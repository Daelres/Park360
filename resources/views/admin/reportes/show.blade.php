@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
        <h1>Detalle del Reporte</h1>
        <div class="table-actions">
            <a class="btn secondary" href="{{ route('admin.reportes.edit', $reporte) }}">Editar</a>
            <a class="btn secondary" href="{{ route('admin.reportes.index') }}">Volver</a>
        </div>
    </div>

    <div class="card" style="display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap:1rem;">
        <div>
            <strong>Código</strong>
            <div>{{ str_pad($reporte->id, 3, '0', STR_PAD_LEFT) }}</div>
        </div>
        <div>
            <strong>Fecha</strong>
            <div>{{ optional($reporte->inicio_at)->format('Y-m-d H:i') }}</div>
        </div>
        <div>
            <strong>Creado por</strong>
            <div>{{ $reporte->reportadoPor->name ?? $reporte->reportadoPor->email ?? 'N/D' }}</div>
        </div>
        <div>
            <strong>Tipo</strong>
            <div>{{ $reporte->tipo }}</div>
        </div>
        <div>
            <strong>Atracción</strong>
            <div>{{ $reporte->atraccion->nombre ?? '—' }}</div>
        </div>
        <div>
            <strong>Severidad</strong>
            <div>{{ $reporte->severidad ?? '—' }}</div>
        </div>
        <div>
            <strong>Estado</strong>
            <div>{{ $reporte->estado ?? '—' }}</div>
        </div>
        <div>
            <strong>Fin</strong>
            <div>{{ optional($reporte->fin_at)->format('Y-m-d H:i') ?? '—' }}</div>
        </div>
        <div style="grid-column: 1 / -1;">
            <strong>Descripción</strong>
            <div style="white-space:pre-wrap;">{{ $reporte->descripcion ?? '—' }}</div>
        </div>
    </div>
@endsection
