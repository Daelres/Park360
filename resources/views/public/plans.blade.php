@extends('layouts.app')

@section('content')
    <style>
        .plans-hero {
            background: linear-gradient(135deg, #93B5F5 0%, #AF93F5 50%, #9396F5 100%);
            border-radius: 1.5rem;
            padding: 3rem 2rem;
            margin-bottom: 3rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: center;
            box-shadow: 0 20px 60px rgba(147, 181, 245, 0.3);
        }

        .plans-hero h1 {
            font-size: 2.8rem;
            color: white;
            margin: 0 0 1rem 0;
            font-weight: 900;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
            letter-spacing: 1px;
        }

        .plans-hero p {
            font-size: 1.15rem;
            color: rgba(255, 255, 255, 0.95);
            margin: 0;
            line-height: 1.7;
            font-weight: 500;
        }

        .plans-hero img {
            width: 100%;
            border-radius: 1rem;
            max-height: 300px;
            object-fit: cover;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .plans-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .plan-card {
            border-radius: 1.5rem;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, currentColor, transparent);
        }

        .plan-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15) !important;
        }

        .plan-card.general {
            background: linear-gradient(135deg, #f5f3ff 0%, #e8e4f3 100%);
            box-shadow: 0 15px 40px rgba(147, 181, 245, 0.15);
            border: 2px solid rgba(147, 181, 245, 0.2);
        }

        .plan-card.vip {
            background: linear-gradient(135deg, #FF6B9D 0%, #FF8C42 100%);
            box-shadow: 0 20px 50px rgba(255, 107, 157, 0.25);
            transform: scale(1.08);
            border: none;
        }

        .plan-card.pro {
            background: linear-gradient(135deg, #4ECDC4 0%, #44A08D 100%);
            box-shadow: 0 20px 50px rgba(78, 205, 196, 0.2);
            border: none;
        }

        .plan-card.vip:hover {
            transform: translateY(-8px) scale(1.08);
        }

        .plan-badge {
            display: inline-block;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 2px;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            width: fit-content;
            margin: 0 auto;
            margin-bottom: 0.5rem;
        }

        .plan-card.general .plan-badge {
            background: rgba(147, 181, 245, 0.2);
            color: #2D1B69;
        }

        .plan-card.vip .plan-badge {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .plan-card.pro .plan-badge {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .plan-title {
            font-size: 2rem;
            margin: 0;
            text-align: center;
            font-weight: 900;
            letter-spacing: 1.5px;
        }

        .plan-card.general .plan-title {
            color: #93B5F5;
        }

        .plan-card.vip .plan-title {
            color: white;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        .plan-card.pro .plan-title {
            color: white;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
            flex-grow: 1;
        }

        .plan-features li {
            font-size: 0.95rem;
            line-height: 1.8;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .plan-features li::before {
            content: '✓';
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-weight: 800;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .plan-card.general .plan-features {
            color: #333;
        }

        .plan-card.general .plan-features li::before {
            background: rgba(102, 126, 234, 0.2);
            color: #667eea;
        }

        .plan-card.vip .plan-features {
            color: rgba(255, 255, 255, 0.95);
        }

        .plan-card.vip .plan-features li::before {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .plan-card.pro .plan-features {
            color: rgba(255, 215, 0, 0.95);
        }

        .plan-card.pro .plan-features li::before {
            background: rgba(255, 215, 0, 0.2);
            color: #ffd700;
        }

        .plan-price {
            font-size: 2.4rem;
            font-weight: 900;
            text-align: center;
            margin: 1rem 0;
        }

        .plan-card.general .plan-price {
            color: #93B5F5;
        }

        .plan-card.vip .plan-price {
            color: white;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }

        .plan-card.pro .plan-price {
            color: white;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
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
            margin-top: auto;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .plan-card.general .plan-btn {
            background: linear-gradient(135deg, #93B5F5 0%, #AF93F5 100%);
            color: white;
        }

        .plan-card.general .plan-btn:hover {
            box-shadow: 0 8px 30px rgba(147, 181, 245, 0.4);
            transform: translateY(-3px);
        }

        .plan-card.vip .plan-btn {
            background: white;
            color: #FF6B9D;
        }

        .plan-card.vip .plan-btn:hover {
            box-shadow: 0 8px 30px rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
        }

        .plan-card.pro .plan-btn {
            background: white;
            color: #4ECDC4;
        }

        .plan-card.pro .plan-btn:hover {
            box-shadow: 0 8px 30px rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
        }

        .additional-section {
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .additional-section h2 {
            text-align: center;
            font-size: 2rem;
            color: #2D1B69;
            margin-bottom: 2rem;
            font-weight: 800;
        }

        .additional-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .addon-card {
            background: white;
            border-radius: 1.2rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(147, 181, 245, 0.12);
            border: 2px solid rgba(147, 181, 245, 0.1);
            transition: all 0.3s ease;
        }

        .addon-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(147, 181, 245, 0.2);
            border-color: rgba(147, 181, 245, 0.3);
        }

        .addon-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #93B5F5 0%, #AF93F5 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
        }

        .addon-title {
            font-size: 1.4rem;
            font-weight: 800;
            color: #93B5F5;
            margin-bottom: 1rem;
        }

        .addon-description {
            font-size: 0.9rem;
            color: #6B5B8F;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .addon-prices {
            list-style: none;
            padding: 0;
            margin: 1rem 0;
            text-align: left;
        }

        .addon-prices li {
            padding: 0.5rem 0;
            font-size: 0.9rem;
            color: #4B5563;
            border-bottom: 1px solid #E8E4F3;
        }

        .addon-prices li:last-child {
            border-bottom: none;
        }

        .addon-prices strong {
            color: #93B5F5;
            font-weight: 700;
        }

        .addon-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: #93B5F5;
            margin: 1rem 0;
        }

        .addon-btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            background: linear-gradient(135deg, #93B5F5 0%, #AF93F5 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
        }

        .addon-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(147, 181, 245, 0.3);
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
            <h1>Elige tu experiencia</h1>
            <p>Selecciona el pase ideal y prepárate para disfrutar sin límites en Park360. Cada nivel te ofrece beneficios exclusivos diseñados para ti.</p>
        </div>
        <img src="https://xn--stdtereise-hamburg-mtb.de/wp-content/uploads/2023/08/hamburger-dom.jpg" alt="Planes" />
    </div>

    <div class="plans-container">
        <!-- Plan General -->
        <div class="plan-card general">
            <span class="plan-badge">ENTRADA BÁSICA</span>
            <h2 class="plan-title">GENERAL</h2>
            <ul class="plan-features">
                <li>Acceso ilimitado a todas las atracciones estándar</li>
                <li>Shows en vivo disponibles</li>
                <li>Zonas comunes y áreas de descanso</li>
                <li>Estacionamiento incluido</li>
            </ul>
            <div class="plan-price">$100K</div>
            <a href="{{ route('payments.create', ['plan' => 'GENERAL']) }}" class="plan-btn">Comprar entrada</a>
        </div>

        <!-- Plan VIP -->
        <div class="plan-card vip">
            <span class="plan-badge">⭐ MÁS POPULAR</span>
            <h2 class="plan-title">VIP</h2>
            <ul class="plan-features">
                <li>Todo lo del plan General</li>
                <li>Acceso prioritario a atracciones</li>
                <li>Preferencia de asientos en shows</li>
                <li>Zona VIP con bebidas complimentarias</li>
                <li>Descuento 20% en tienda oficial</li>
            </ul>
            <div class="plan-price">$150K</div>
            <a href="{{ route('payments.create', ['plan' => 'VIP']) }}" class="plan-btn">Comprar entrada</a>
        </div>

        <!-- Plan PRO -->
        <div class="plan-card pro">
            <span class="plan-badge">👑 EXPERIENCIA PREMIUM</span>
            <h2 class="plan-title">PRO</h2>
            <ul class="plan-features">
                <li>Todo lo del plan VIP</li>
                <li>Fast Pass ilimitado (sin filas)</li>
                <li>Acceso prioritario a eventos especiales</li>
                <li>Comidas y bebidas incluidas</li>
                <li>Fotos profesionales gratuitas</li>
                <li>Kit de bienvenida VIP premium</li>
            </ul>
            <div class="plan-price">$250K</div>
            <a href="{{ route('payments.create', ['plan' => 'PRO']) }}" class="plan-btn">Comprar entrada</a>
        </div>
    </div>

<!-- Opciones Adicionales -->
    <div class="additional-section">
        <h2>Opciones Adicionales</h2>
        
        <div class="additional-cards">
            <!-- Fast Pass -->
            <div class="addon-card">
                <div class="addon-icon">🚀</div>
                <h3 class="addon-title">Fast Pass</h3>
                <div class="addon-description">Salta filas en todas las atracciones</div>
                <ul class="addon-prices">
                    <li><strong>General:</strong> $60.000</li>
                    <li><strong>VIP:</strong> $80.000</li>
                    <li><strong>Pro:</strong> Incluido</li>
                </ul>
                <p style="font-size: 0.85rem; color: #6B5B8F; margin-top: 1rem;">Producto adicional a tu pasaporte.</p>
            </div>

            <!-- Bono de Lluvia -->
            <div class="addon-card">
                <div class="addon-icon">🌧️</div>
                <h3 class="addon-title">Bono de Lluvia</h3>
                <div class="addon-description">Válido si llueve durante tu visita</div>
                <ul class="addon-prices">
                    <li><strong>General:</strong> $10.000</li>
                    <li><strong>VIP:</strong> $12.000</li>
                    <li><strong>Pro:</strong> Incluido</li>
                </ul>
                <p style="font-size: 0.85rem; color: #6B5B8F; margin-top: 1rem;">*Vigencia de un mes para hacerse efectivo.</p>
            </div>

            <!-- Parqueadero -->
            <div class="addon-card">
                <div class="addon-icon">🚗</div>
                <h3 class="addon-title">Parqueadero</h3>
                <div class="addon-description">Estacionamiento seguro para tu vehículo</div>
                <p style="font-size: 0.9rem; color: #4B5563; margin: 1rem 0;">Contamos con parqueadero con capacidad para más de 1200 vehículos (motos y automóviles).</p>
                <ul class="addon-prices" style="text-align: center;">
                    <li style="border: none;"><strong>Autos:</strong> $25.000</li>
                    <li style="border: none;"><strong>Motos/Bicicletas:</strong> $5.000</li>
                </ul>
            </div>

            <!-- Carros Chocones -->
            <div class="addon-card">
                <div class="addon-icon">🎪</div>
                <h3 class="addon-title">Carros Chocones</h3>
                <div class="addon-price">$12.000</div>
                <div class="addon-description">Déjate llevar por las risas</div>
            </div>

            <!-- Pista de Karts -->
            <div class="addon-card">
                <div class="addon-icon">🏎️</div>
                <h3 class="addon-title">Pista de Karts</h3>
                <div class="addon-price">$18.000</div>
                <div class="addon-description">Déjate llevar por la velocidad</div>
            </div>

            <!-- Castillo 3D -->
            <div class="addon-card">
                <div class="addon-icon">🏰</div>
                <h3 class="addon-title">Castillo 3D</h3>
                <div class="addon-price">$15.000</div>
                <div class="addon-description">Déjate llevar del miedo</div>
            </div>
        </div>
    </div>
@endsection
