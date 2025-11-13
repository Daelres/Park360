@extends('layouts.app')

@section('content')
<style>
    .dashboard-hero {
        background: oklch(0.55 0.25 280);
        border-radius: 1.5rem;
        padding: 2.5rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .dashboard-hero h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dashboard-hero p {
        font-size: 1.1rem;
        margin: 0;
        opacity: 0.95;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: white;
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
    }

    .stat-icon.purple { background: oklch(0.55 0.25 280); }
    .stat-icon.cyan { background: #00BCD4; }
    .stat-icon.lime { background: oklch(0.82 0.25 130); }
    .stat-icon.orange { background: #FF6B35; }

    .stat-badge {
        padding: 0.5rem 0.875rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .stat-badge.positive {
        background: rgba(110, 231, 183, 0.2);
        color: oklch(0.82 0.25 130);
    }

    .stat-badge.negative {
        background: rgba(255, 107, 53, 0.2);
        color: #FF6B35;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: #000;
        margin: 0 0 0.5rem 0;
    }

    .stat-label {
        color: #6b7280;
        font-size: 0.95rem;
        font-weight: 600;
        margin: 0;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 900;
        color: oklch(0.55 0.25 280);
        margin: 0 0 1.5rem 0;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .tools-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .tool-card {
        background: white;
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .tool-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .tool-icon {
        width: 80px;
        height: 80px;
        border-radius: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: white;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .tool-icon.purple {
        background: oklch(0.55 0.25 280);
    }

    .tool-icon.cyan {
        background: #00BCD4;
    }

    .tool-icon.orange {
        background: #FF6B35;
    }

    .tool-icon.lime {
        background: oklch(0.82 0.25 130);
    }

    .tool-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #000;
        margin: 0 0 0.5rem 0;
    }

    .tool-description {
        color: #6b7280;
        font-size: 0.95rem;
        margin: 0;
    }

    .bottom-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .alerts-card, .activity-card {
        background: white;
        border-radius: 1.25rem;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .alerts-card {
        border: 3px solid #FF6B35;
    }

    .activity-card {
        border: 3px solid oklch(0.55 0.25 280);
    }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .card-icon {
        width: 50px;
        height: 50px;
        border-radius: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }

    .card-icon.orange { background: #FF6B35; }
    .card-icon.purple { background: oklch(0.55 0.25 280); }

    .card-title {
        font-size: 1.5rem;
        font-weight: 900;
        color: #000;
        margin: 0;
    }

    .alert-item, .activity-item {
        padding: 1.25rem;
        background: #f9fafb;
        border-radius: 0.875rem;
        margin-bottom: 1rem;
        border-left: 4px solid;
    }

    .alert-item {
        border-left-color: oklch(0.82 0.25 130);
    }

    .alert-item.warning {
        border-left-color: #00BCD4;
    }

    .activity-item {
        border-left-color: oklch(0.55 0.25 280);
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .activity-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: white;
        flex-shrink: 0;
    }

    .alert-title {
        font-weight: 700;
        color: #000;
        margin: 0 0 0.25rem 0;
        font-size: 0.95rem;
    }

    .alert-time {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    .activity-content {
        flex: 1;
    }

    .activity-user {
        font-weight: 700;
        color: oklch(0.55 0.25 280);
    }

    .activity-text {
        color: #000;
        margin: 0 0 0.25rem 0;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .bottom-section {
            grid-template-columns: 1fr;
        }

        .dashboard-hero h1 {
            font-size: 2rem;
        }

        .stat-value {
            font-size: 2rem;
        }
    }
</style>

<!-- Hero Dashboard -->
<div class="dashboard-hero">
    <h1>
        <i class="fas fa-chart-line"></i>
        Dashboard
    </h1>
    <p>Bienvenido! Aquí está lo que está pasando en el parque hoy.</p>
</div>

@php
    // Obtener datos reales de pagos de hoy
    $hoyInicio = \Carbon\Carbon::today();
    $hoyFin = \Carbon\Carbon::tomorrow();
    
    // Tickets vendidos hoy (pagos aprobados)
    $ticketsHoy = \App\Models\Pago::where('estado', 'aprobado')
        ->whereBetween('paid_at', [$hoyInicio, $hoyFin])
        ->count();
    
    // Ingresos totales de hoy (pagos aprobados)
    $ingresosHoy = \App\Models\Pago::where('estado', 'aprobado')
        ->whereBetween('paid_at', [$hoyInicio, $hoyFin])
        ->sum('monto');
    
    // Calcular visitantes basado en boletos
    $visitantesHoy = \App\Models\Boleto::whereHas('orden.pagos', function($query) use ($hoyInicio, $hoyFin) {
        $query->where('estado', 'aprobado')
              ->whereBetween('paid_at', [$hoyInicio, $hoyFin]);
    })->count();
    
    // Formatear ingresos
    $ingresosFormateados = number_format($ingresosHoy / 1000, 1) . 'K';
    if ($ingresosHoy >= 1000000) {
        $ingresosFormateados = number_format($ingresosHoy / 1000000, 1) . 'M';
    }
    
    // Calcular porcentajes de crecimiento (comparar con ayer)
    $ayerInicio = \Carbon\Carbon::yesterday();
    $ayerFin = \Carbon\Carbon::today();
    
    $ticketsAyer = \App\Models\Pago::where('estado', 'aprobado')
        ->whereBetween('paid_at', [$ayerInicio, $ayerFin])
        ->count();
    
    $ingresosAyer = \App\Models\Pago::where('estado', 'aprobado')
        ->whereBetween('paid_at', [$ayerInicio, $ayerFin])
        ->sum('monto');
    
    $visitantesAyer = \App\Models\Boleto::whereHas('orden.pagos', function($query) use ($ayerInicio, $ayerFin) {
        $query->where('estado', 'aprobado')
              ->whereBetween('paid_at', [$ayerInicio, $ayerFin]);
    })->count();
    
    // Calcular porcentajes
    $porcentajeVisitantes = $visitantesAyer > 0 ? round((($visitantesHoy - $visitantesAyer) / $visitantesAyer) * 100) : 0;
    $porcentajeTickets = $ticketsAyer > 0 ? round((($ticketsHoy - $ticketsAyer) / $ticketsAyer) * 100) : 0;
    $porcentajeIngresos = $ingresosAyer > 0 ? round((($ingresosHoy - $ingresosAyer) / $ingresosAyer) * 100) : 0;
    
    // Estadísticas de atracciones
    $atraccionesOperacionales = \App\Models\Atraccion::where('estado_operativo', 'Operacional')->count();
    $atraccionesTotales = \App\Models\Atraccion::count();
    $porcentajeOperacional = $atraccionesTotales > 0 ? round(($atraccionesOperacionales / $atraccionesTotales) * 100) : 0;
@endphp

<!-- Estadísticas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon purple">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-badge {{ $porcentajeVisitantes >= 0 ? 'positive' : 'negative' }}">
                {{ $porcentajeVisitantes >= 0 ? '+' : '' }}{{ $porcentajeVisitantes }}%
            </div>
        </div>
        <h3 class="stat-value">{{ number_format($visitantesHoy) }}</h3>
        <p class="stat-label">Visitantes Hoy</p>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon cyan">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-badge {{ $porcentajeTickets >= 0 ? 'positive' : 'negative' }}">
                {{ $porcentajeTickets >= 0 ? '+' : '' }}{{ $porcentajeTickets }}%
            </div>
        </div>
        <h3 class="stat-value">{{ number_format($ticketsHoy) }}</h3>
        <p class="stat-label">Tickets Vendidos</p>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon lime">
                <i class="fas fa-gamepad"></i>
            </div>
            <div class="stat-badge positive">{{ $porcentajeOperacional }}%</div>
        </div>
        <h3 class="stat-value">{{ $atraccionesOperacionales }}/{{ $atraccionesTotales }}</h3>
        <p class="stat-label">Atracciones Activas</p>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <div class="stat-icon orange">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-badge {{ $porcentajeIngresos >= 0 ? 'positive' : 'negative' }}">
                {{ $porcentajeIngresos >= 0 ? '+' : '' }}{{ $porcentajeIngresos }}%
            </div>
        </div>
        <h3 class="stat-value">${{ $ingresosFormateados }}</h3>
        <p class="stat-label">Ingresos Hoy</p>
    </div>
</div>

<!-- Herramientas de Gestión -->
<h2 class="section-title">Herramientas de Gestión</h2>

<div class="tools-grid">
    <a href="{{ route('admin.atracciones.index') }}" class="tool-card">
        <div class="tool-icon purple">
            <i class="fas fa-gamepad"></i>
        </div>
        <h3 class="tool-title">Atracciones</h3>
        <p class="tool-description">Gestiona rides, shows y atracciones</p>
    </a>

    <a href="{{ route('admin.sedes.index') }}" class="tool-card">
        <div class="tool-icon cyan">
            <i class="fas fa-map-marker-alt"></i>
        </div>
        <h3 class="tool-title">Ubicaciones</h3>
        <p class="tool-description">Mapas, zonas y puntos de interés</p>
    </a>

    <a href="{{ route('admin.reportes.index') }}" class="tool-card">
        <div class="tool-icon orange">
            <i class="fas fa-chart-bar"></i>
        </div>
        <h3 class="tool-title">Reportes</h3>
        <p class="tool-description">Análisis, asistencia y datos</p>
    </a>
</div>

<!-- Alertas y Actividad -->
<div class="bottom-section">
    <!-- Alertas Activas -->
    <div class="alerts-card">
        <div class="card-header">
            <div class="card-icon orange">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h3 class="card-title">Alertas Activas</h3>
        </div>

        @php
            $alertas = [
                [
                    'titulo' => 'Thunder Mountain - Mantenimiento programado en 2 horas',
                    'tiempo' => 'hace 10 mins',
                    'tipo' => 'success'
                ],
                [
                    'titulo' => 'Alta capacidad esperada este fin de semana',
                    'tiempo' => 'hace 1 hora',
                    'tipo' => 'warning'
                ],
                [
                    'titulo' => 'Todas las inspecciones de seguridad completadas',
                    'tiempo' => 'hace 2 horas',
                    'tipo' => 'success'
                ]
            ];
        @endphp

        @foreach($alertas as $alerta)
            <div class="alert-item {{ $alerta['tipo'] }}">
                <p class="alert-title">{{ $alerta['titulo'] }}</p>
                <p class="alert-time">{{ $alerta['tiempo'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Actividad Reciente -->
    <div class="activity-card">
        <div class="card-header">
            <div class="card-icon purple">
                <i class="fas fa-bolt"></i>
            </div>
            <h3 class="card-title">Actividad Reciente</h3>
        </div>

        @php
            $actividades = [
                [
                    'usuario' => 'Juan Pérez',
                    'accion' => 'Actualizó estado de Space Spinner',
                    'tiempo' => 'hace 5 mins',
                    'color' => 'oklch(0.55 0.25 280)'
                ],
                [
                    'usuario' => 'María López',
                    'accion' => 'Agregó nueva ubicación: Food Court Zona 3',
                    'tiempo' => 'hace 15 mins',
                    'color' => '#00BCD4'
                ],
                [
                    'usuario' => 'Carlos Ruiz',
                    'accion' => 'Generó reporte mensual de asistencia',
                    'tiempo' => 'hace 32 mins',
                    'color' => '#FF6B35'
                ],
                [
                    'usuario' => 'Ana García',
                    'accion' => 'Creó nueva cuenta de staff',
                    'tiempo' => 'hace 1 hora',
                    'color' => 'oklch(0.82 0.25 130)'
                ]
            ];
        @endphp

        @foreach($actividades as $actividad)
            <div class="activity-item">
                <div class="activity-avatar" style="background: {{ $actividad['color'] }};">
                    <i class="fas fa-user"></i>
                </div>
                <div class="activity-content">
                    <p class="activity-text">
                        <span class="activity-user">{{ $actividad['usuario'] }}</span>
                        {{ $actividad['accion'] }}
                    </p>
                    <p class="alert-time">{{ $actividad['tiempo'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
