@extends('layouts.app')

@section('content')
    <!-- Sección de Promoción -->
    <style>
        .promo-section {
            position: relative;
            overflow: hidden;
            background: oklch(0.55 0.25 280);
            min-height: 500px;
            border-radius: 2rem;
            padding: 3rem 2rem;
            margin: 2rem 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
        }

        .promo-section::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .promo-decorative {
            position: absolute;
            border-radius: 50%;
            opacity: 0.25;
        }

        @keyframes float-animation {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes bounce-animation {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float-1 { animation: float-animation 6s ease-in-out infinite; }
        .float-2 { animation: float-animation 8s ease-in-out infinite 1s; }
        .float-3 { animation: bounce-animation 4s ease-in-out infinite 0.5s; }
        .float-4 { animation: float-animation 7s ease-in-out infinite 1.5s; }
        .float-5 { animation: float-animation 9s ease-in-out infinite 2s; }

        .promo-content {
            position: relative;
            z-index: 10;
        }

        .promo-badge {
            display: inline-block;
            background: oklch(0.82 0.25 130);
            color: oklch(0.55 0.25 280);
            padding: 0.875rem 1.5rem;
            border-radius: 50px;
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 0.95rem;
            border: 3px solid white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            animation: bounce-animation 3s ease-in-out infinite;
        }

        .promo-title {
            font-size: 4rem;
            font-weight: 900;
            color: oklch(0.82 0.25 130);
            margin: 0 0 0.5rem 0;
            text-transform: uppercase;
            letter-spacing: 2px;
            line-height: 1;
            text-shadow: 4px 4px 0px rgba(0, 0, 0, 0.3);
        }

        .promo-subtitle {
            font-size: 2.5rem;
            font-weight: 900;
            color: white;
            margin: 0 0 1.5rem 0;
            line-height: 1.2;
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2);
        }

        .promo-subtitle span {
            color: oklch(0.82 0.25 130);
        }

        .promo-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            padding: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            border: 4px solid white;
        }

        .promo-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .promo-card-icon {
            width: 60px;
            height: 60px;
            background: oklch(0.82 0.25 130);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            animation: bounce-animation 2s ease-in-out infinite;
        }

        .promo-card-title {
            color: oklch(0.55 0.25 280);
            font-size: 1.5rem;
            font-weight: 900;
            margin: 0;
        }

        .promo-card-text {
            color: oklch(0.55 0.25 280);
            font-size: 1rem;
            margin: 0;
        }

        .promo-buttons {
            display: flex;
            gap: 1rem;
            margin: 1.5rem 0;
            flex-wrap: wrap;
        }

        .promo-btn {
            padding: 1rem 1.8rem;
            border-radius: 0.875rem;
            text-decoration: none;
            font-weight: 800;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .promo-btn-primary {
            background: oklch(0.82 0.25 130);
            color: oklch(0.55 0.25 280);
        }

        .promo-btn-primary:hover {
            background: oklch(0.75 0.25 130);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .promo-btn-secondary {
            background: #FF6B35;
            color: white;
            border: 3px solid #FF6B35;
        }

        .promo-btn-secondary:hover {
            background: transparent;
            color: #FF6B35;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .promo-stats {
            display: flex;
            gap: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
        }

        .promo-stat {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: oklch(0.55 0.25 280);
            font-weight: 700;
        }

        .promo-stat i {
            color: oklch(0.82 0.25 130);
        }

        .promo-image {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .promo-image-container {
            position: relative;
            width: 80%;
            max-width: 450px;
        }

        .promo-image img {
            width: 100%;
            border-radius: 1.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border: 4px solid white;
            transform: rotate(-8deg);
            transition: transform 0.3s ease;
        }

        .promo-image img:hover {
            transform: rotate(-8deg) scale(1.05);
        }

        .promo-badge-fire {
            position: absolute;
            top: -1.5rem;
            right: -1.5rem;
            background: oklch(0.82 0.25 130);
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: float-animation 4s ease-in-out infinite;
        }

        .promo-icon-badge {
            position: absolute;
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            border: 4px solid white;
            animation: float-animation 5s ease-in-out infinite;
        }

        .promo-icon-badge.top-left {
            top: -40px;
            left: -40px;
            background: #00A6E0;
            color: white;
            animation-delay: 0.5s;
        }

        .promo-icon-badge.top-right {
            top: -35px;
            right: -35px;
            background: oklch(0.82 0.25 130);
            color: white;
            animation-delay: 1s;
        }

        .promo-icon-badge.bottom-left {
            bottom: -35px;
            left: -35px;
            background: #FF6B35;
            color: white;
            animation-delay: 1.5s;
        }

        .promo-icon-badge.bottom-right {
            bottom: -35px;
            right: -35px;
            background: #FF1493;
            color: white;
            animation-delay: 2s;
        }

        @media (max-width: 768px) {
            .promo-section {
                grid-template-columns: 1fr;
                padding: 2rem 1.5rem;
                min-height: auto;
            }

            .promo-title {
                font-size: 2.5rem;
            }

            .promo-subtitle {
                font-size: 1.8rem;
            }

            .promo-image {
                order: -1;
            }
        }
    </style>

    <div class="promo-section">
        <!-- Decorativos de fondo -->
        <div class="promo-decorative float-1" style="top: 20px; left: 40px; width: 120px; height: 120px; background: oklch(0.82 0.25 130);"></div>
        <div class="promo-decorative float-2" style="top: 100px; right: 80px; width: 100px; height: 100px; background: white;"></div>
        <div class="promo-decorative float-3" style="bottom: 150px; left: 100px; width: 80px; height: 80px; background: #FF6B35;"></div>
        <div class="promo-decorative float-4" style="top: 200px; right: 30%; width: 60px; height: 60px; background: #FF1493;"></div>
        <div class="promo-decorative float-5" style="bottom: 50px; right: 40px; width: 100px; height: 100px; background: oklch(0.82 0.25 130);"></div>

        <!-- Contenido -->
        <div class="promo-content">
            <div class="promo-badge">
                <i class="fas fa-star"></i> ¡OFERTAS ESPECIALES!
                <i class="fas fa-star"></i>
            </div>

            <h2 class="promo-title">
                ¡BAJARON<br>NUESTROS<br>PRECIOS!
            </h2>

            <h3 class="promo-subtitle">
                Disfruta con <span>tu familia</span>
                <i class="fas fa-bolt" style="animation: bounce-animation 1s ease-in-out infinite; display: inline-block; margin-left: 0.5rem;"></i>
            </h3>

            <div class="promo-card">
                <div class="promo-card-header">
                    <div class="promo-card-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <div>
                        <p class="promo-card-title">Solo por</p>
                        <p class="promo-card-text">Park360.com</p>
                    </div>
                </div>

                <div class="promo-buttons">
                    <a href="{{ route('public.plans') }}" class="promo-btn promo-btn-primary">
                        <i class="fas fa-ticket-alt"></i> Comprar Ahora
                    </a>
                    <div style="display: inline-block; background: transparent; padding: 0.75rem 1rem; border-radius: 50px; border: 3px solid #FF6B35;">
                        <p style="color: #FF6B35; font-weight: 700; font-size: 0.9rem; margin: 0;">Aplican T&C</p>
                    </div>
                </div>

                <div class="promo-stats">
                    <div class="promo-stat">
                        <i class="fas fa-users"></i>
                        <span>+1000 visitantes</span>
                    </div>
                    <div class="promo-stat">
                        <i class="fas fa-star"></i>
                        <span>4.9 estrellas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imagen -->
        <div class="promo-image">
            <div class="promo-image-container">
                <img src="https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1c/e8/7c/02/dragon-khan.jpg?w=500&h=500&s=1" alt="Familia en el parque">
                <div class="promo-badge-fire">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="promo-icon-badge top-left">
                    <i class="fas fa-child"></i>
                </div>
                <div class="promo-icon-badge top-right">
                    <i class="fas fa-users"></i>
                </div>
                <div class="promo-icon-badge bottom-left">
                    <i class="fas fa-home"></i>
                </div>
                <div class="promo-icon-badge bottom-right">
                    <i class="fas fa-heart"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Selector de Sede -->
    <div style="margin: 3rem 0 2rem 0; display: flex; align-items: center; justify-content: center;">
        <form method="GET" action="{{ route('public.home') }}" style="display: flex; align-items: center; gap: 1rem;">
            <label for="sede_id" style="font-weight: 700; font-size: 1.1rem; color: #000;">
                <i class="fas fa-map-marker-alt" style="color: oklch(0.55 0.25 280); margin-right: 0.5rem;"></i>
                Seleccionar sede:
            </label>
            <select id="sede_id" name="sede_id" 
                    style="padding: 0.875rem 1rem; border: 2px solid oklch(0.55 0.25 280); border-radius: 0.875rem; font-size: 1rem; min-width: 250px; color: #000; background: white; cursor: pointer; transition: all 0.3s ease;"
                    onchange="this.form.submit()"
                    onmouseover="this.style.borderColor='oklch(0.50 0.25 280)'; this.style.boxShadow='0 0 0 3px rgba(147, 105, 245, 0.1)';"
                    onmouseout="this.style.borderColor='oklch(0.55 0.25 280)'; this.style.boxShadow='none';">
                <option value="" disabled @selected(!$selectedSedeId)>
                    -- Seleccione una sede --
                </option>
                @foreach($sedes as $sede)
                    <option value="{{ $sede->id }}" @selected($sede->id == $selectedSedeId)>
                        {{ $sede->nombre }} - {{ $sede->ciudad }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

    @if($atracciones->isEmpty())
        <div class="card">
            <p>No hay atracciones registradas para esta sede todavía.</p>
        </div>
    @else
        <div class="grid grid-3">
            @foreach($atracciones as $atraccion)
                <div class="card">
                    <img
                        src="{{ $atraccion->imagen_url ?? 'https://images.unsplash.com/photo-1520880867055-1e30d1cb001c?auto=format&fit=crop&w=800&q=80' }}"
                        alt="{{ $atraccion->nombre }}"
                        style="width: 100%; height: 180px; object-fit: cover; border-radius: 1rem;">
                    <h2 style="margin-top: 1rem; margin-bottom: 0.5rem;">{{ $atraccion->nombre }}</h2>
                    <p style="color: #4b5563;">{{ \Illuminate\Support\Str::limit($atraccion->descripcion, 110) }}</p>
                    <div style="margin: 1rem 0; display:flex; justify-content: space-between;">
                        <span class="badge">Tipo: {{ $atraccion->tipo ?? 'General' }}</span>
                        @if($atraccion->altura_minima)
                            <span class="badge">Estatura mínima: {{ $atraccion->altura_minima }} cm</span>
                        @endif
                    </div>
                    <a class="btn" href="{{ route('public.atracciones.show', $atraccion) }}">Ver detalles</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
