@extends('layouts.app')

@section('content')
    <style>
        /* Animaciones para parque de diversiones */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        @keyframes bounce-gentle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes wiggle {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(-3deg); }
            75% { transform: rotate(3deg); }
        }

        @keyframes pulse-scale {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .animate-bounce-gentle {
            animation: bounce-gentle 2s ease-in-out infinite;
        }

        .animate-wiggle {
            animation: wiggle 1s ease-in-out infinite;
        }

        .animate-pulse-scale {
            animation: pulse-scale 2s ease-in-out infinite;
        }

        /* Efectos de texto 3D para títulos */
        .text-3d-primary {
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1), 6px 6px 0px rgba(0, 0, 0, 0.05);
        }

        .text-3d-bold {
            text-shadow: 2px 2px 0px rgba(0, 0, 0, 0.2), 4px 4px 0px rgba(0, 0, 0, 0.1), 6px 6px 0px rgba(0, 0, 0, 0.05);
        }

        .plans-hero {
            background: transparent;
            padding: 2rem 0 3rem 0;
            margin-bottom: 3rem;
            text-align: center;
        }

        .plans-hero h1 {
            font-size: 3rem;
            color: oklch(0.55 0.25 280);
            margin: 0 0 0.5rem 0;
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .plans-hero p {
            font-size: 1.2rem;
            color: #718096;
            margin: 0;
            line-height: 1.7;
            font-weight: 600;
        }
        
        .plans-hero img {
            display: none;
        }

        .plans-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
            gap: 2.5rem;
            margin-bottom: 3rem;
            align-items: stretch;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        .plan-card {
            background: white;
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
            cursor: pointer;
            height: auto;
        }

        .plan-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15) !important;
        }

        .plan-card.general {
            border: 6px solid #00BCD4; /* Cyan/Turquoise border */
            box-shadow: 0 10px 30px rgba(0, 188, 212, 0.15);
        }

        .plan-card.vip {
            border: 7px solid oklch(0.55 0.25 280); /* Purple border */
            box-shadow: 0 15px 40px rgba(147, 105, 245, 0.2);
            transform: scale(1.05);
            position: relative;
        }

        .plan-card.vip:hover {
            transform: translateY(-8px) scale(1.05);
        }

        .plan-card.pro {
            border: 6px solid #FF6B35; /* Orange border */
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.15);
        }

        .plan-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1.5px;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            width: fit-content;
            margin: 0 auto;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .plan-card.general .plan-badge {
            background: #00BCD4;
            color: white;
        }

        .plan-card.vip .plan-badge {
            background: oklch(0.55 0.25 280);
            color: white;
            font-size: 0.8rem;
            padding: 0.7rem 1.5rem;
        }

        .plan-card.pro .plan-badge {
            background: #FF6B35;
            color: white;
        }

        .plan-title {
            font-size: 1.8rem;
            margin: 0.5rem 0;
            text-align: center;
            font-weight: 900;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .plan-card.general .plan-title {
            color: #00BCD4;
        }

        .plan-card.vip .plan-title {
            color: oklch(0.55 0.25 280);
        }

        .plan-card.pro .plan-title {
            color: #FF6B35;
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 1.5rem 0;
        }

        .plan-features li {
            font-size: 1.05rem;
            line-height: 2;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 500;
        }

        .plan-features li::before {
            content: '✓';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            font-weight: 800;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .plan-card.general .plan-features {
            color: #4a5568;
        }

        .plan-card.general .plan-features li::before {
            background: #00BCD4;
            color: white;
        }

        .plan-card.vip .plan-features {
            color: #4a5568;
        }

        .plan-card.vip .plan-features li::before {
            background: oklch(0.55 0.25 280);
            color: white;
        }

        .plan-card.pro .plan-features {
            color: #4a5568;
        }

        .plan-card.pro .plan-features li::before {
            background: #FF6B35;
            color: white;
        }

        .plan-price {
            font-size: 3rem;
            font-weight: 900;
            text-align: center;
            margin: 1.5rem 0;
            line-height: 1;
        }

        .plan-card.general .plan-price {
            color: #000;
        }

        .plan-card.vip .plan-price {
            color: #000;
        }

        .plan-card.pro .plan-price {
            color: #000;
        }
        
        .plan-price-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #718096;
            margin-top: 0.5rem;
        }

        .plan-btn {
            display: inline-block;
            padding: 1.1rem 2.5rem;
            font-weight: 800;
            text-align: center;
            border: none;
            border-radius: 50px;
            font-size: 0.95rem;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 1rem;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .plan-card.general .plan-btn {
            background: #00BCD4;
            color: white;
        }

        .plan-card.general .plan-btn:hover {
            background: #0097A7;
            box-shadow: 0 8px 30px rgba(0, 188, 212, 0.4);
            transform: translateY(-3px);
        }

        .plan-card.vip .plan-btn {
            background: oklch(0.55 0.25 280);
            color: white;
        }

        .plan-card.vip .plan-btn:hover {
            background: oklch(0.50 0.25 280);
            box-shadow: 0 8px 30px rgba(147, 105, 245, 0.4);
            transform: translateY(-3px);
        }

        .plan-card.pro .plan-btn {
            background: #FF6B35;
            color: white;
        }

        .plan-card.pro .plan-btn:hover {
            background: #E5572E;
            box-shadow: 0 8px 30px rgba(255, 107, 53, 0.4);
            transform: translateY(-3px);
        }

        .additional-section {
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .additional-section h2 {
            text-align: center;
            font-size: 2.5rem;
            color: oklch(0.55 0.25 280); /* Purple */
            margin-bottom: 2rem;
            font-weight: 900;
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1);
        }

        .additional-cards {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 2rem;
            max-width: 100%;
            margin: 0 auto;
        }

        .addon-card {
            background: white;
            border-radius: 1.5rem;
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
            transition: all 0.3s ease;
            height: auto;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .addon-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
        }

        /* Colores de fondo específicos para cada addon */
        .addon-card.fastpass {
            background: oklch(0.55 0.25 280); /* Purple */
        }

        .addon-card.lluvia {
            background: #00BCD4; /* Cyan */
        }

        .addon-card.parqueadero {
            background: #FF6B35; /* Orange */
        }

        .addon-card.chocones {
            background: #FF1493; /* Hot Pink */
        }

        .addon-card.karts {
            background: oklch(0.82 0.25 130); /* Lime Green */
        }

        .addon-card.castillo {
            background: #9C27B0; /* Deep Purple */
        }

        .addon-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .addon-title {
            font-size: 1rem;
            font-weight: 800;
            color: white;
            text-transform: uppercase;
            margin: 0;
        }

        .addon-description {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.95);
            line-height: 1.4;
            margin: 0;
        }

        .addon-prices {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: left;
            font-size: 0.75rem;
        }

        .addon-prices li {
            padding: 0.25rem 0;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .addon-prices li:last-child {
            border-bottom: none;
        }

        .addon-prices strong {
            color: white;
            font-weight: 700;
        }

        .addon-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: white;
            margin: 0;
        }
        
        .addon-card p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.75rem;
            margin: 0;
            line-height: 1.3;
        }

        .addon-btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            background: white;
            color: oklch(0.55 0.25 280);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 800;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
        }

        .addon-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .plans-hero {
                grid-template-columns: 1fr;
                padding: 2rem 1.5rem;
            }

            .plans-hero h1 {
                font-size: 2rem;
            }

            .plan-card.vip {
                transform: scale(1);
            }

            .plan-card.vip:hover {
                transform: translateY(-8px) scale(1);
            }

            .additional-cards {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="plans-hero">
        <div>
            <h1>ELIGE TU PASAPORTE</h1>
            <p>Precios especiales para toda la familia</p>
        </div>
        <img src="https://xn--stdtereise-hamburg-mtb.de/wp-content/uploads/2023/08/hamburger-dom.jpg" alt="Planes" />
    </div>

    <div class="plans-container">
        <!-- Plan General -->
        <div class="plan-card general">
            <span class="plan-badge">PASAPORTE DÍA</span>
            <h2 class="plan-title">General</h2>
            <div class="plan-price">
                $100.000
                <span class="plan-price-label">por persona</span>
            </div>
            <ul class="plan-features">
                <li>Acceso a todas las atracciones</li>
                <li>Válido por 1 día</li>
                <li>Incluye shows</li>
            </ul>
            <a href="{{ route('payments.create', ['plan' => 'GENERAL']) }}" class="plan-btn">Comprar</a>
        </div>

        <!-- Plan VIP -->
        <div class="plan-card vip">
            <span class="plan-badge"><i class="fas fa-star"></i> MÁS POPULAR</span>
            <h2 class="plan-title">Pasaporte Pro</h2>
            <div class="plan-price">
                $150.000
                <span class="plan-price-label">por persona</span>
            </div>
            <ul class="plan-features">
                <li>FastPass incluido</li>
                <li>Estacionamiento gratis</li>
                <li>Cupón de comida</li>
                <li>Descuento en tienda</li>
            </ul>
            <a href="{{ route('payments.create', ['plan' => 'VIP']) }}" class="plan-btn">Comprar</a>
        </div>

        <!-- Plan PRO -->
        <div class="plan-card pro">
            <span class="plan-badge">PASAPORTE ANUAL</span>
            <h2 class="plan-title">Anual</h2>
            <div class="plan-price">
                $250.000
                <span class="plan-price-label">por persona</span>
            </div>
            <ul class="plan-features">
                <li>Visitas ilimitadas</li>
                <li>Eventos exclusivos</li>
                <li>20% descuento tienda</li>
                <li>Trae un amigo gratis</li>
            </ul>
            <a href="{{ route('payments.create', ['plan' => 'PRO']) }}" class="plan-btn">Comprar</a>
        </div>
    </div>

<!-- Opciones Adicionales -->
    <div class="additional-section">
        <h2>Opciones Adicionales</h2>
        
        <div class="additional-cards">
            <!-- Fast Pass -->
            <div class="addon-card fastpass">
                <div class="addon-icon">🚀</div>
                <h3 class="addon-title">Fast Pass</h3>
                <div class="addon-description">Salta filas en todas las atracciones</div>
                <ul class="addon-prices">
                    <li><strong>General:</strong> $60.000</li>
                    <li><strong>VIP:</strong> $80.000</li>
                    <li><strong>Pro:</strong> Incluido</li>
                </ul>
                <p style="font-size: 0.85rem; margin-top: 1rem;">Producto adicional a tu pasaporte.</p>
            </div>

            <!-- Bono de Lluvia -->
            <div class="addon-card lluvia">
                <div class="addon-icon">🌧️</div>
                <h3 class="addon-title">Bono de Lluvia</h3>
                <div class="addon-description">Válido si llueve durante tu visita</div>
                <ul class="addon-prices">
                    <li><strong>General:</strong> $10.000</li>
                    <li><strong>VIP:</strong> $12.000</li>
                    <li><strong>Pro:</strong> Incluido</li>
                </ul>
                <p style="font-size: 0.85rem; margin-top: 1rem;">*Vigencia de un mes para hacerse efectivo.</p>
            </div>

            <!-- Parqueadero -->
            <div class="addon-card parqueadero">
                <div class="addon-icon">🚗</div>
                <h3 class="addon-title">Parqueadero</h3>
                <div class="addon-description">Estacionamiento seguro para tu vehículo</div>
                <p style="font-size: 0.9rem; margin: 1rem 0;">Contamos con parqueadero con capacidad para más de 1200 vehículos (motos y automóviles).</p>
                <ul class="addon-prices" style="text-align: center;">
                    <li style="border: none;"><strong>Autos:</strong> $25.000</li>
                    <li style="border: none;"><strong>Motos/Bicicletas:</strong> $5.000</li>
                </ul>
            </div>

            <!-- Carros Chocones -->
            <div class="addon-card chocones">
                <div class="addon-icon">🎪</div>
                <h3 class="addon-title">Carros Chocones</h3>
                <div class="addon-price">$12.000</div>
                <div class="addon-description">Déjate llevar por las risas</div>
            </div>

            <!-- Pista de Karts -->
            <div class="addon-card karts">
                <div class="addon-icon">🏎️</div>
                <h3 class="addon-title">Pista de Karts</h3>
                <div class="addon-price">$18.000</div>
                <div class="addon-description">Déjate llevar por la velocidad</div>
            </div>

            <!-- Castillo 3D -->
            <div class="addon-card castillo">
                <div class="addon-icon">🏰</div>
                <h3 class="addon-title">Castillo 3D</h3>
                <div class="addon-price">$15.000</div>
                <div class="addon-description">Déjate llevar del miedo</div>
            </div>
        </div>
    </div>
@endsection
