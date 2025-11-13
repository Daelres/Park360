@extends('layouts.app')

@section('content')
    <div class="hero">
        <div>
            <h1 class="text-3d-bold">Analítica de aplicación</h1>
            <p>Gestiona la aplicación</p>
        </div>
    </div>

    <div class="grid grid-3" style="margin-bottom:1.5rem;">
        <div class="card">
            <h3 style="margin:0 0 .35rem 0;">Usuarios</h3>
            <div style="display:flex; gap:1rem; align-items:center;">
                <div class="badge">Totales</div>
                <strong style="font-size:1.6rem;">{{ number_format($kpis['usuariosTotales']) }}</strong>
            </div>
            <p style="margin:.5rem 0 0 0; color:#4b5563;">Activos (30 días): <strong>{{ number_format($kpis['usuariosActivos30d']) }}</strong></p>
        </div>
        <div class="card">
            <h3 style="margin:0 0 .35rem 0;">Sedes y atracciones</h3>
            <p style="margin:.25rem 0;">Sedes: <strong>{{ number_format($kpis['sedesTotales']) }}</strong></p>
            <p style="margin:.25rem 0;">Atracciones: <strong>{{ number_format($kpis['atraccionesTotales']) }}</strong></p>
        </div>
        <div class="card">
            <h3 style="margin:0 0 .35rem 0;">Incidentes</h3>
            <p style="margin:0;">Últimos 90 días: <strong>{{ number_format($kpis['incidentesTotales90d']) }}</strong></p>
        </div>
    </div>

    <div class="grid grid-2" style="margin-bottom:1.5rem;">
        <div class="card">
            <h3 style="margin-top:0;">Incidentes por tipo (90 días)</h3>
            @if($incidentesPorTipo->isEmpty())
                <p style="color:#6b7280;">Sin datos.</p>
            @else
                <ul style="margin:0; padding-left:1rem;">
                    @foreach($incidentesPorTipo as $tipo => $total)
                        <li><strong>{{ $tipo ?? 'N/D' }}</strong>: {{ $total }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="card">
            <h3 style="margin-top:0;">Incidentes por severidad (90 días)</h3>
            @if($incidentesPorSeveridad->isEmpty())
                <p style="color:#6b7280;">Sin datos.</p>
            @else
                <ul style="margin:0; padding-left:1rem;">
                    @foreach($incidentesPorSeveridad as $sev => $total)
                        <li><strong>{{ $sev ?? 'N/D' }}</strong>: {{ $total }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="grid grid-2">
        <div class="card">
            <h3 style="margin-top:0;">Incidentes por mes (6 meses)</h3>
            @if($incidentesPorMes->isEmpty())
                <p style="color:#6b7280;">Sin datos.</p>
            @else
                <table>
                    <thead>
                    <tr><th>Mes</th><th>Total</th></tr>
                    </thead>
                    <tbody>
                    @foreach($incidentesPorMes as $mes => $total)
                        <tr>
                            <td>{{ $mes }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div class="card">
            <h3 style="margin-top:0;">Atracciones por sede</h3>
            @if($atraccionesPorSede->isEmpty())
                <p style="color:#6b7280;">Sin datos.</p>
            @else
                <table>
                    <thead>
                    <tr><th>Sede</th><th>Atracciones</th></tr>
                    </thead>
                    <tbody>
                    @foreach($atraccionesPorSede as $sede => $total)
                        <tr>
                            <td>{{ $sede }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
