@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 style="margin:0;font-size:2.1rem;color:#2D1B69;">¡Compra exitosa!</h1>
                <p style="margin:0;color:#6B5B8F;max-width:640px;">Estos son los detalles de tu visita. Presenta el código QR en la entrada del parque para agilizar tu ingreso.</p>
            </div>
            <a href="{{ route('payments.create') }}" class="btn btn-secondary">Planear otra visita</a>
        </div>

        <div class="grid" style="grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr); gap:2rem; align-items:flex-start;">
            <section class="card" style="display:flex;flex-direction:column;gap:1.25rem;">
                <header style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;">
                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;">Número de orden</span>
                        <h2 style="margin:0;color:#2D1B69;">#{{ strtoupper($order->uuid) }}</h2>
                    </div>
                        <div style="text-align:right;">
                            <span style="display:block;color:#6B5B8F;font-size:0.85rem;">Fecha de compra</span>
                            <strong style="color:#2D1B69;">
                                {{ optional($order->paid_at, fn ($date) => $date->timezone(config('app.timezone'))->translatedFormat('l j \d\e F Y H:i')) }}
                            </strong>
                        </div>
                </header>

                <article style="border:1px solid rgba(147,181,245,0.2);border-radius:1rem;padding:1.2rem;display:flex;flex-direction:column;gap:0.75rem;">
                    <div style="display:flex;justify-content:space-between;">
                        <div>
                            <span style="display:block;color:#6B5B8F;font-weight:600;">Visita agendada</span>
                            <strong style="color:#2D1B69;font-size:1.1rem;">
                                {{ optional($order->visitDate?->visit_date, fn ($date) => $date->translatedFormat('l j \d\e F Y')) }}
                            </strong>
                        </div>
                        <div style="text-align:right;">
                            <span style="display:block;color:#6B5B8F;font-weight:600;">Importe total</span>
                            <strong style="color:#2D1B69;font-size:1.2rem;">${{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                        </div>
                    </div>

                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;margin-bottom:0.4rem;">Entradas</span>
                        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.45rem;color:#2D1B69;font-size:0.95rem;">
                            @foreach($order->items->where('item_type', 'ticket') as $item)
                                <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;margin-bottom:0.4rem;">Adicionales</span>
                        <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:0.45rem;color:#2D1B69;font-size:0.95rem;">
                            @forelse($order->items->where('item_type', 'addon') as $item)
                                <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                            @empty
                                <li style="color:#9CA3AF;">Sin productos adicionales</li>
                            @endforelse
                        </ul>
                    </div>
                </article>

                <div class="card" style="background:rgba(147,181,245,0.08);border:1px dashed rgba(147,181,245,0.3);">
                    <h3 style="margin:0 0 0.5rem 0;color:#2D1B69;">Recomendaciones</h3>
                    <ul style="margin:0;padding-left:1rem;color:#6B5B8F;font-size:0.9rem;display:flex;flex-direction:column;gap:0.4rem;">
                        <li>Presenta el código QR desde tu móvil o impreso al ingresar.</li>
                        <li>Llega 15 minutos antes de la hora planificada para agilizar tu check-in.</li>
                        <li>Si necesitas cambiar la fecha, contáctanos con el número de orden.</li>
                    </ul>
                </div>
            </section>

            <aside class="card" style="position:sticky;top:1rem;display:flex;flex-direction:column;gap:1rem;align-items:center;text-align:center;">
                <span style="display:block;color:#6B5B8F;font-weight:600;">Tu pase digital</span>
                @if($order->qr_code_path)
                    <img src="{{ asset('storage/'.$order->qr_code_path) }}" alt="Código QR de la visita" style="width:240px;height:auto;border-radius:1rem;border:1px solid rgba(147,181,245,0.25);background:white;padding:0.75rem;" />
                @else
                    <div style="width:240px;height:240px;border-radius:1rem;border:1px dashed rgba(147,181,245,0.5);display:flex;align-items:center;justify-content:center;color:#9CA3AF;font-size:0.9rem;">QR no disponible</div>
                @endif
                <div>
                    <span style="display:block;color:#6B5B8F;font-size:0.85rem;">Código de verificación</span>
                    <strong style="color:#2D1B69;font-size:1.1rem;">{{ $order->qr_code_token }}</strong>
                </div>
                @if($order->qr_code_path)
                    <a href="{{ asset('storage/'.$order->qr_code_path) }}" class="btn" download>Descargar QR</a>
                @endif
                <p style="margin:0;color:#9CA3AF;font-size:0.8rem;">Conserva el QR para cualquier control durante tu visita.</p>
            </aside>
        </div>
    </div>
@endsection
