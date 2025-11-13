@extends('layouts.app')

@section('content')
    <style>
        .attractions-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .attractions-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            color: oklch(0.55 0.25 280);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .attractions-header p {
            color: #718096;
            font-size: 1.1rem;
            margin: 0.5rem 0 0 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 1.5rem;
            padding: 1.5rem;
            border: 3px solid;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card.operational {
            border-color: oklch(0.82 0.25 130);
        }

        .stat-card.maintenance {
            border-color: #FF6B35;
        }

        .stat-card.closed {
            border-color: #E0E0E0;
        }

        .stat-card.riders {
            border-color: oklch(0.55 0.25 280);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
        }

        .stat-card.operational .stat-icon {
            background: oklch(0.82 0.25 130);
        }

        .stat-card.maintenance .stat-icon {
            background: #FF6B35;
        }

        .stat-card.closed .stat-icon {
            background: #E8E8E8;
        }

        .stat-card.riders .stat-icon {
            background: oklch(0.55 0.25 280);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 900;
            margin: 0;
            color: #000;
        }

        .stat-info p {
            font-size: 0.85rem;
            color: #718096;
            margin: 0.25rem 0 0 0;
        }

        .search-section {
            margin-bottom: 2rem;
        }

        .search-section input {
            width: 100%;
            padding: 1rem;
            border: 2px solid oklch(0.9 0.02 280);
            border-radius: 1rem;
            font-size: 1rem;
        }

        .search-section input:focus {
            outline: none;
            border-color: oklch(0.55 0.25 280);
        }

        .attractions-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .attraction-item {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .attraction-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .attraction-item.maintenance {
            border-color: #FF6B35;
        }

        .attraction-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .attraction-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0;
            color: #000;
        }

        .attraction-type {
            display: inline-block;
            background: white;
            border: 2px solid #E8E8E8;
            color: #718096;
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .attraction-status {
            display: inline-block;
            background: #FF6B35;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .attraction-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
            margin-top: 1rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-icon {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }

        .info-content p {
            margin: 0;
            font-size: 0.9rem;
            color: #718096;
        }

        .info-content strong {
            display: block;
            font-size: 1.1rem;
            color: #000;
            font-weight: 700;
        }

        .add-btn {
            background: oklch(0.55 0.25 280);
            color: white;
            padding: 1rem 1.8rem;
            border-radius: 50px;
            border: none;
            font-weight: 800;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .add-btn:hover {
            background: oklch(0.50 0.25 280);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .actions-menu {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .actions-menu a, .actions-menu button {
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            background: oklch(0.96 0.03 300);
            color: oklch(0.55 0.25 280);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .actions-menu a:hover, .actions-menu button:hover {
            background: oklch(0.82 0.25 130);
            color: white;
        }

        @media (max-width: 768px) {
            .attractions-header {
                flex-direction: column;
                gap: 1rem;
            }

            .attractions-header h1 {
                font-size: 2rem;
            }

            .attraction-info {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }
    </style>

    <div class="attractions-header">
        <div>
            <h1>Atracciones</h1>
            <p>Gestiona rides, shows y atracciones del parque</p>
        </div>
        <a href="{{ route('admin.atracciones.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Agregar
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card operational">
            <div class="stat-icon"><i class="fas fa-power-off"></i></div>
            <div class="stat-info">
                <h3>{{ $atracciones->where('estado_operativo', 'Operacional')->count() }}</h3>
                <p>Operacionales</p>
            </div>
        </div>

        <div class="stat-card maintenance">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-info">
                <h3>{{ $atracciones->where('estado_operativo', 'Mantenimiento')->count() }}</h3>
                <p>Mantenimiento</p>
            </div>
        </div>

        <div class="stat-card closed">
            <div class="stat-icon"><i class="fas fa-power-off"></i></div>
            <div class="stat-info">
                <h3>{{ $atracciones->whereIn('estado_operativo', ['Mantenimiento', 'Cerrada', 'Inoperativa'])->count() }}</h3>
                <p>Cerradas</p>
            </div>
        </div>

        <div class="stat-card riders">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <h3>{{ $atracciones->sum('capacidad') }}K</h3>
                <p>Riders Hoy</p>
            </div>
        </div>
    </div>

    <!-- Búsqueda -->
    <div class="search-section">
        <form method="GET" action="{{ route('admin.atracciones.index') }}" style="display: flex; gap: 1rem; align-items: center;">
            <div style="flex: 1; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-search" style="color: #718096; font-size: 1.2rem;"></i>
                <input type="text" name="search" placeholder="Buscar atracciones..." value="{{ $search }}" style="border: none; background: transparent; flex: 1;">
            </div>
            <button type="submit" style="background: oklch(0.55 0.25 280); color: white; padding: 0.6rem 1.2rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: 600;">Buscar</button>
            @if($search)
                <a href="{{ route('admin.atracciones.index') }}" style="color: #718096; text-decoration: none; cursor: pointer; font-weight: 600;">✕ Limpiar</a>
            @endif
        </form>
    </div>

    <!-- Listado de Atracciones -->
    <div class="attractions-list">
        @forelse($atracciones as $atraccion)
            <div class="attraction-item {{ $atraccion->estado_operativo === 'Mantenimiento' ? 'maintenance' : '' }}">
                <div class="attraction-header">
                    <h2 class="attraction-title">{{ $atraccion->nombre }}</h2>
                    <span class="attraction-type">{{ $atraccion->tipo ?? 'General' }}</span>
                    <span class="attraction-type" style="background: oklch(0.82 0.25 130); color: white; border: none;">🏢 {{ $atraccion->sede->nombre ?? 'N/A' }}</span>
                    @if($atraccion->estado_operativo !== 'Operacional')
                        <span class="attraction-status">{{ $atraccion->estado_operativo }}</span>
                    @endif
                </div>

                <div class="attraction-info">
                    <div class="info-item">
                        <div class="info-icon">👥</div>
                        <div class="info-content">
                            <p>Capacidad</p>
                            <strong>{{ $atraccion->capacidad }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📏</div>
                        <div class="info-content">
                            <p>Altura Mínima</p>
                            <strong>{{ $atraccion->altura_minima ?? 'N/A' }} cm</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📊</div>
                        <div class="info-content">
                            <p>Hoy</p>
                            <strong>{{ rand(100, 5000) }}</strong>
                        </div>
                    </div>
                </div>

                <div class="actions-menu">
                    <a href="{{ route('admin.atracciones.show', $atraccion) }}">👁️ Ver</a>
                    <a href="{{ route('admin.atracciones.edit', $atraccion) }}">✏️ Editar</a>
                    <form method="POST" action="{{ route('admin.atracciones.destroy', $atraccion) }}" style="display: inline;" onsubmit="return confirm('¿Eliminar esta atracción?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #FFE8E8; color: #FF6B35;">🗑️ Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="attraction-item" style="text-align: center; padding: 3rem;">
                <p style="color: #718096; font-size: 1.1rem;">No hay atracciones registradas.</p>
            </div>
        @endforelse
    </div>

    @if($atracciones->hasPages())
        {{ $atracciones->links('vendor.pagination.custom') }}
    @endif
@endsection
