@extends('layouts.app')

@section('content')
    <div class="grid grid-2">
        <div class="card">
            <h2>Resumen de ventas</h2>
            <p><strong>Total vendido:</strong> ${{ number_format($sales['total_amount'] ?? 0, 0, ',', '.') }}</p>
            <p><strong>Boletos vendidos:</strong> {{ $sales['tickets_sold'] ?? 0 }}</p>
            <a class="btn" href="{{ route('reports.sales', request()->only(['from', 'to'])) }}">Descargar CSV</a>
        </div>
        <div class="card">
            <h2>Asistencia del personal ({{ $attendance['date'] ?? '' }})</h2>
            <p><strong>Presentes:</strong> {{ $attendance['present'] ?? 0 }}</p>
            <p><strong>Ausentes:</strong> {{ $attendance['absent'] ?? 0 }}</p>
        </div>
    </div>

    <div class="card" style="margin-top:2rem;">
        <h2>Desempeño de atracciones</h2>
        <p><strong>Fecha:</strong> {{ $attractions['date'] ?? '' }}</p>
        <p><strong>Satisfacción promedio:</strong> {{ number_format($attractions['average_satisfaction'] ?? 0, 2) }}</p>
        <table>
            <thead>
                <tr>
                    <th>Atracción</th>
                    <th>Visitantes</th>
                    <th>Incidentes</th>
                    <th>Mantenimientos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attractions['metrics'] ?? [] as $metric)
                    <tr>
                        <td>{{ $metric->attraction->name }}</td>
                        <td>{{ $metric->visitors_count }}</td>
                        <td>{{ $metric->incidents_count }}</td>
                        <td>{{ $metric->maintenance_count }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn secondary" href="{{ route('reports.attractions', request()->only(['metrics_date'])) }}">Exportar PDF</a>
    </div>
@endsection
