@extends('layouts.app')

@section('content')
    <style>
        .sedes-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .sedes-header h1 {
            font-size: 2.5rem;
            font-weight: 900;
            color: oklch(0.55 0.25 280);
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .sedes-header p {
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

        .stat-card.total {
            border-color: oklch(0.82 0.25 130);
        }

        .stat-card.cities {
            border-color: #FF6B35;
        }

        .stat-card.attractions {
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

        .stat-card.total .stat-icon {
            background: oklch(0.82 0.25 130);
        }

        .stat-card.cities .stat-icon {
            background: #FF6B35;
        }

        .stat-card.attractions .stat-icon {
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

        .sedes-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .sede-item {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem;
            border: 3px solid white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .sede-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .sede-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .sede-title {
            font-size: 1.3rem;
            font-weight: 800;
            margin: 0;
            color: #000;
        }

        .sede-code {
            display: inline-block;
            background: oklch(0.96 0.03 300);
            color: oklch(0.55 0.25 280);
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .sede-info {
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
            .sedes-header {
                flex-direction: column;
                gap: 1rem;
            }

            .sedes-header h1 {
                font-size: 2rem;
            }

            .sede-info {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }
    </style>

    <div class="sedes-header">
        <div>
            <h1>Sedes</h1>
            <p>Gestiona las ubicaciones del parque y su información clave</p>
        </div>
        <a href="{{ route('admin.sedes.create') }}" class="add-btn">
            <i class="fas fa-plus"></i> Agregar
        </a>
    </div>

    <!-- Estadísticas -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div class="stat-info">
                <h3>{{ $sedes->total() }}</h3>
                <p>Sedes Totales</p>
            </div>
        </div>

        <div class="stat-card cities">
            <div class="stat-icon"><i class="fas fa-city"></i></div>
            <div class="stat-info">
                <h3>{{ count($sedes->pluck('ciudad')->unique()) }}</h3>
                <p>Ciudades</p>
            </div>
        </div>

        <div class="stat-card attractions">
            <div class="stat-icon"><i class="fas fa-gamepad"></i></div>
            <div class="stat-info">
                <h3>{{ $sedes->sum('atracciones_count') }}</h3>
                <p>Total Atracciones</p>
            </div>
        </div>
    </div>

    <!-- Búsqueda -->
    <div class="search-section">
        <form method="GET" action="{{ route('admin.sedes.index') }}" style="display: flex; gap: 1rem; align-items: center;">
            <div style="flex: 1; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-search" style="color: #718096; font-size: 1.2rem;"></i>
                <input type="text" name="search" placeholder="Buscar sedes..." value="{{ $search }}" style="border: none; background: transparent; flex: 1;">
            </div>
            <button type="submit" style="background: oklch(0.55 0.25 280); color: white; padding: 0.6rem 1.2rem; border-radius: 0.5rem; border: none; cursor: pointer; font-weight: 600;">Buscar</button>
            @if($search)
                <a href="{{ route('admin.sedes.index') }}" style="color: #718096; text-decoration: none; cursor: pointer; font-weight: 600;">✕ Limpiar</a>
            @endif
        </form>
    </div>

    <!-- Listado de Sedes -->
    <div class="sedes-list">
        @forelse($sedes as $sede)
            <div class="sede-item">
                <div class="sede-header">
                    <h2 class="sede-title">{{ $sede->nombre }}</h2>
                    <span class="sede-code">{{ $sede->codigo }}</span>
                </div>

                <div class="sede-info">
                    <div class="info-item">
                        <div class="info-icon">🏙️</div>
                        <div class="info-content">
                            <p>Ciudad</p>
                            <strong>{{ $sede->ciudad }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📍</div>
                        <div class="info-content">
                            <p>Dirección</p>
                            <strong>{{ $sede->direccion ?? 'N/A' }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">📱</div>
                        <div class="info-content">
                            <p>Teléfono</p>
                            <strong>{{ $sede->telefono ?? 'N/A' }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">🎢</div>
                        <div class="info-content">
                            <p>Atracciones</p>
                            <strong>{{ $sede->atracciones_count }}</strong>
                        </div>
                    </div>
                </div>

                <div class="actions-menu">
                    <a href="{{ route('admin.sedes.show', $sede) }}">👁️ Ver</a>
                    <a href="{{ route('admin.sedes.edit', $sede) }}">✏️ Editar</a>
                    <form method="POST" action="{{ route('admin.sedes.destroy', $sede) }}" style="display: inline;" onsubmit="return confirm('¿Eliminar esta sede?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: #FFE8E8; color: #FF6B35;">🗑️ Eliminar</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="sede-item" style="text-align: center; padding: 3rem;">
                <p style="color: #718096; font-size: 1.1rem;">No hay sedes registradas.</p>
            </div>
        @endforelse
    </div>

    @if($sedes->hasPages())
        {{ $sedes->links('vendor.pagination.custom') }}
    @endif
@endsection
