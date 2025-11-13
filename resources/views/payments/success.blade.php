@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 style="margin:0;font-size:2rem;color:#1B5E20;">¡Compra exitosa!</h1>
                <p style="margin:0;color:#6B5B8F;max-width:640px;">Hemos confirmado tu pago y enviamos un correo con el pase digital y tus comprobantes.</p>
            </div>

            <a href="{{ route('payments.create') }}" class="btn btn-secondary">Planear otra visita</a>
        </div>

        <div class="grid" style="grid-template-columns: minmax(0, 1.7fr) minmax(320px, 1fr); gap:2rem; align-items:flex-start;">
            <section class="card" style="display:flex;flex-direction:column;gap:1.5rem;padding:2rem;">
                <div style="display:flex;flex-direction:column;gap:0.4rem;background:rgba(76,175,80,0.08);border-radius:1rem;border:1px solid rgba(76,175,80,0.2);padding:1.1rem 1.3rem;">
                    <strong style="color:#1B5E20;font-size:1.1rem;">Orden #{{ strtoupper($order->uuid) }}</strong>
                    <span style="color:#388E3C;font-size:0.95rem;">Pago registrado el {{ optional($order->paid_at, fn ($date) => $date->timezone(config('app.timezone'))->translatedFormat('l j \d\e F Y \a \l\a\s H:i')) }}</span>
                    <p style="margin:0;color:#2D1B69;font-size:0.95rem;">Presenta el código QR para agilizar el ingreso. Si lo necesitas, descarga el pase desde el panel lateral.</p>
                </div>

                <div style="display:grid;grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));gap:1.25rem;">
                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;">Visita agendada</span>
                        <strong style="color:#2D1B69;font-size:1.15rem;">{{ optional($order->visitDate?->visit_date, fn ($date) => $date->translatedFormat('l j \d\e F Y')) }}</strong>
                    </div>
                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;">Importe total</span>
                        <strong style="color:#2D1B69;font-size:1.15rem;">${{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </div>
                </div>

                <div style="display:flex;flex-direction:column;gap:0.75rem;">
                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;margin-bottom:0.35rem;">Entradas</span>
                        <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:0.35rem;color:#2D1B69;font-size:0.95rem;">
                            @foreach($order->items->where('item_type', 'ticket') as $item)
                                <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <span style="display:block;color:#6B5B8F;font-weight:600;margin-bottom:0.35rem;">Adicionales</span>
                        <ul style="list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:0.35rem;color:#2D1B69;font-size:0.95rem;">
                            @forelse($order->items->where('item_type', 'addon') as $item)
                                <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                            @empty
                                <li style="color:#9CA3AF;">Sin productos adicionales</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div style="padding:1.25rem;border-radius:1rem;background:rgba(147,181,245,0.08);border:1px dashed rgba(147,181,245,0.3);">
                    <h3 style="margin-top:0;margin-bottom:0.75rem;color:#2D1B69;font-size:1.1rem;">Recomendaciones</h3>
                    <ul style="margin:0;padding-left:1.1rem;color:#6B5B8F;font-size:0.9rem;display:flex;flex-direction:column;gap:0.35rem;">
                        <li>Presenta el código QR desde tu móvil o impreso al ingresar.</li>
                        <li>Llega 15 minutos antes de la hora planificada para agilizar tu check-in.</li>
                        <li>Para cualquier cambio usa tu número de orden y comunícate con soporte.</li>
                    </ul>
                </div>
            </section>

            <aside class="card" style="position:sticky;top:1rem;display:flex;flex-direction:column;gap:1.25rem;padding:2rem;text-align:center;">
                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;margin-bottom:0.35rem;">Tu pase digital</span>
                    @if($order->qr_code_path)
                        <img src="{{ asset('storage/'.$order->qr_code_path) }}"
                             alt="Código QR de la visita"
                             style="width:100%;max-width:260px;border-radius:1.25rem;border:1px solid rgba(147,181,245,0.25);background:white;padding:0.85rem;margin:0 auto 1rem;display:block;">
                    @else
                        <div style="width:100%;max-width:260px;height:260px;border-radius:1.25rem;border:1px dashed rgba(147,181,245,0.5);color:#9CA3AF;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                            QR no disponible
                        </div>
                    @endif
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-size:0.85rem;">Código de verificación</span>
                    <strong style="color:#2D1B69;font-size:1.25rem;">{{ $order->qr_code_token }}</strong>
                </div>

                @if($order->qr_code_path)
                    <a href="{{ asset('storage/'.$order->qr_code_path) }}" class="btn btn-primary" download style="width:100%;">
                        Descargar QR
                    </a>
                @endif

                <p style="margin:0;color:#9CA3AF;font-size:0.85rem;">Guarda el pase para controles aleatorios dentro del parque.</p>
            </aside>
        </div>
    </div>
@endsection
