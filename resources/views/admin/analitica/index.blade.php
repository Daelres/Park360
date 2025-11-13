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
                <div style="height:320px;">
                    <canvas id="chartIncidentesTipo" aria-label="Gráfico de barras de incidentes por tipo" role="img"></canvas>
                </div>
            @endif
        </div>
        <div class="card">
            <h3 style="margin-top:0;">Incidentes por severidad (90 días)</h3>
            @if($incidentesPorSeveridad->isEmpty())
                <p style="color:#6b7280;">Sin datos.</p>
            @else
                <div style="height:320px;">
                    <canvas id="chartIncidentesSeveridad" aria-label="Gráfico de dona de incidentes por severidad" role="img"></canvas>
                </div>
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
    @push('scripts')
        <!-- Cargar Chart.js desde CDN. Nota: se omite SRI para evitar bloqueos por hash desalineado en algunos mirrors/CDN. -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Si Chart.js no cargó, evitamos fallos y dejamos registro en consola
                if (!window.Chart) {
                    console.warn('Chart.js no se pudo cargar. Verifique conectividad o CDN.');
                    return;
                }
                // Datos desde el servidor
                const datosPorTipo = @json($incidentesPorTipo ?? collect());
                const datosPorSeveridad = @json($incidentesPorSeveridad ?? collect());

                // Utilidad para generar colores
                const palette = [
                    '#6366F1', '#22C55E', '#F59E0B', '#EF4444', '#06B6D4', '#84CC16', '#A855F7', '#14B8A6', '#E11D48', '#F97316'
                ];

                if (Object.keys(datosPorTipo).length) {
                    const ctxTipo = document.getElementById('chartIncidentesTipo');
                    if (ctxTipo) {
                        new Chart(ctxTipo, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(datosPorTipo),
                            datasets: [{
                                label: 'Incidentes',
                                data: Object.values(datosPorTipo),
                                backgroundColor: Object.keys(datosPorTipo).map((_, i) => palette[i % palette.length]),
                                borderRadius: 6,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: { enabled: true }
                            },
                            scales: {
                                x: { ticks: { autoSkip: false } },
                                y: { beginAtZero: true, precision: 0 }
                            }
                        }
                    });
                    }
                }

                if (Object.keys(datosPorSeveridad).length) {
                    const ctxSev = document.getElementById('chartIncidentesSeveridad');
                    if (ctxSev) {
                        new Chart(ctxSev, {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(datosPorSeveridad),
                            datasets: [{
                                label: 'Incidentes',
                                data: Object.values(datosPorSeveridad),
                                backgroundColor: ['#DC2626','#F59E0B','#22C55E','#3B82F6','#A855F7','#0EA5E9']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' }
                            },
                            cutout: '60%'
                        }
                    });
                    }
                }
            });
        </script>
    @endpush
@endsection
