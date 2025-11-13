@extends('layouts.app')

@section('content')
    <style>
        .success-wrapper { display:flex; flex-direction:column; gap:2rem; }
        .success-header { display:flex; justify-content:space-between; align-items:flex-start; gap:1.5rem; flex-wrap:wrap; }
        .success-header h1 { margin:0; font-size:2.1rem; color:#2D1B69; }
        .success-header p { margin:0; color:#6B5B8F; max-width:640px; }
        .success-grid { display:grid; grid-template-columns:minmax(0, 2fr) minmax(320px, 1fr); gap:2rem; align-items:flex-start; }
        .success-details { display:flex; flex-direction:column; gap:1.5rem; }
        .success-meta { display:flex; flex-wrap:wrap; gap:1.5rem; }
        .success-meta-block { flex:1 1 240px; }
        .success-meta-label { display:block; color:#6B5B8F; font-weight:600; margin-bottom:0.35rem; }
        .success-meta-value { color:#2D1B69; font-size:1.2rem; margin:0; }
        .success-summary-box { border:1px solid rgba(147,181,245,0.2); border-radius:1rem; padding:1.3rem; display:flex; flex-direction:column; gap:1.2rem; background:white; }
        .success-summary-row { display:flex; justify-content:space-between; gap:1rem; flex-wrap:wrap; }
        .success-summary-row > div { flex:1 1 220px; }
        .success-amount { color:#2D1B69; font-size:1.2rem; font-weight:700; }
        .success-list { list-style:none; margin:0; padding:0; display:flex; flex-direction:column; gap:0.45rem; color:#2D1B69; font-size:0.95rem; }
        .success-list--empty { color:#9CA3AF; }
        .success-tips { background:rgba(147,181,245,0.08); border:1px dashed rgba(147,181,245,0.3); }
        .success-tips h3 { margin:0 0 0.5rem; color:#2D1B69; }
        .success-tips ul { margin:0; padding-left:1rem; color:#6B5B8F; font-size:0.9rem; display:flex; flex-direction:column; gap:0.4rem; }
        .success-qr-card { position:sticky; top:1rem; display:flex; flex-direction:column; gap:1rem; align-items:center; text-align:center; }
        .success-qr-card img { width:240px; max-width:100%; height:auto; border-radius:1rem; border:1px solid rgba(147,181,245,0.25); background:white; padding:0.75rem; }
        .success-qr-fallback { width:240px; height:240px; border-radius:1rem; border:1px dashed rgba(147,181,245,0.5); display:flex; align-items:center; justify-content:center; color:#9CA3AF; font-size:0.9rem; }
        .success-code-label { display:block; color:#6B5B8F; font-size:0.85rem; }
        .success-code-value { color:#2D1B69; font-size:1.1rem; font-weight:700; }
        .success-qr-card .btn { width:100%; justify-content:center; }
        @media (max-width: 1024px) {
            .success-grid { grid-template-columns:1fr; }
            .success-qr-card { position:static; width:100%; }
        }
    </style>

    <div class="success-wrapper">
        <div class="success-header">
            <div>
                <h1>¡Compra exitosa!</h1>
                <p>Estos son los detalles de tu visita. Presenta el código QR en la entrada del parque para agilizar tu ingreso.</p>
            </div>
            <a href="{{ route('payments.create') }}" class="btn btn-secondary">Planear otra visita</a>
        </div>

        <div class="success-grid">
            <section class="card success-details">
                <div class="success-meta">
                    <div class="success-meta-block">
                        <span class="success-meta-label">Número de orden</span>
                        <p class="success-meta-value">#{{ strtoupper($order->uuid) }}</p>
                    </div>
                    <div class="success-meta-block" style="text-align:right;">
                        <span class="success-meta-label" style="font-size:0.85rem;">Fecha de compra</span>
                        <p class="success-meta-value" style="font-size:1rem;">
                            {{ optional($order->paid_at, fn ($date) => $date->timezone(config('app.timezone'))->translatedFormat('l j \d\e F Y H:i')) }}
                        </p>
                    </div>
                </div>

                <article class="success-summary-box">
                    <div class="success-summary-row">
                        <div>
                            <span class="success-meta-label">Visita agendada</span>
                            <p class="success-meta-value" style="font-size:1.1rem;">
                                {{ optional($order->visitDate?->visit_date, fn ($date) => $date->translatedFormat('l j \d\e F Y')) }}
                            </p>
                        </div>
                        <div style="text-align:right;">
                            <span class="success-meta-label">Importe total</span>
                            <span class="success-amount">${{ number_format($order->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="success-meta-label" style="margin-bottom:0.4rem;">Entradas</span>
                        <ul class="success-list">
                            @foreach($order->items->where('item_type', 'ticket') as $item)
                                <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span class="success-meta-label" style="margin-bottom:0.4rem;">Adicionales</span>
                        <ul class="success-list">
                            @forelse($order->items->where('item_type', 'addon') as $item)
                                <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                            @empty
                                <li class="success-list--empty">Sin productos adicionales</li>
                            @endforelse
                        </ul>
                    </div>
                </article>

                <div class="card success-tips">
                    <h3>Recomendaciones</h3>
                    <ul>
                        <li>Presenta el código QR desde tu móvil o impreso al ingresar.</li>
                        <li>Llega 15 minutos antes de la hora planificada para agilizar tu check-in.</li>
                        <li>Si necesitas cambiar la fecha, contáctanos con el número de orden.</li>
                    </ul>
                </div>
            </section>

            <aside class="card success-qr-card">
                <span style="color:#6B5B8F;font-weight:600;">Tu pase digital</span>
                @if($order->qr_code_path)
                    <img src="{{ asset('storage/'.$order->qr_code_path) }}" alt="Código QR de la visita" />
                @else
                    <div class="success-qr-fallback">QR no disponible</div>
                @endif
                <div>
                    <span class="success-code-label">Código de verificación</span>
                    <span class="success-code-value">{{ $order->qr_code_token }}</span>
                </div>
                @if($order->qr_code_path)
                    <a href="{{ asset('storage/'.$order->qr_code_path) }}" class="btn" download>Descargar QR</a>
                @endif
                <p style="margin:0;color:#9CA3AF;font-size:0.8rem;">Conserva el QR para cualquier control durante tu visita.</p>
            </aside>
        </div>
    </div>
@endsection
