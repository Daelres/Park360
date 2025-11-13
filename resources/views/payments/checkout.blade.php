@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h1 style="margin:0;font-size:2rem;color:#2D1B69;">Completa tu pago</h1>
                <p style="margin:0;color:#6B5B8F;max-width:640px;">Revisa el resumen de tu compra y finaliza el pago seguro sin salir de Park360.</p>
            </div>
            <a href="{{ route('payments.create') }}" class="btn btn-secondary">Volver a editar selección</a>
        </div>

        <div class="grid" style="grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr); gap:2rem; align-items:flex-start;">
            <section class="card" style="min-height:520px;display:flex;flex-direction:column;gap:1.5rem;padding:2rem;">
                <div style="display:flex;align-items:center;gap:0.75rem;background:rgba(76,175,80,0.08);padding:0.85rem 1rem;border-radius:0.75rem;border:1px solid rgba(76,175,80,0.2);">
                    <span style="display:inline-flex;width:40px;height:40px;border-radius:50%;background:#4CAF50;color:white;align-items:center;justify-content:center;font-weight:700;">SSL</span>
                    <div>
                        <strong style="display:block;color:#1B5E20;font-size:0.95rem;">Conexión cifrada y verificada</strong>
                        <small style="color:#388E3C;">Procesamos pagos mediante Stripe sin guardar los datos de tu tarjeta.</small>
                    </div>
                </div>

                <div id="checkout-status" style="color:#6B5B8F;font-size:0.95rem;">Preparando el formulario…</div>

                <div id="embedded-checkout" style="flex:1;min-height:480px;border:1px solid rgba(45,27,105,0.08);border-radius:1.25rem;overflow:hidden;background:white;padding:1.75rem;box-shadow:0 25px 60px rgba(45,27,105,0.08);"></div>

                <div style="display:flex;flex-wrap:wrap;gap:1rem;align-items:center;justify-content:center;margin-top:0.5rem;color:#9CA3AF;font-size:0.8rem;">
                    <span>Pagos protegidos con Stripe</span>
                    <span>Certificación PCI DSS Nivel 1</span>
                    <span>Monitoreo anti-fraude permanente</span>
                </div>
            </section>

            <aside class="card" style="position:sticky;top:1rem;display:flex;flex-direction:column;gap:1rem;">
                <div>
                    <h2 style="margin:0;color:#2D1B69;">Resumen</h2>
                    <p style="margin:0;color:#6B5B8F;font-size:0.9rem;">Orden #{{ strtoupper($order->uuid) }}</p>
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;">Fecha</span>
                    <p style="margin:0.3rem 0 0;color:#2D1B69;">{{ optional($order->visitDate)->visit_date?->translatedFormat('l j \d\e F Y') }}</p>
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;">Entradas</span>
                    <ul style="list-style:none;padding:0;margin:0.5rem 0 0;display:flex;flex-direction:column;gap:0.4rem;color:#2D1B69;font-size:0.9rem;">
                        @foreach($order->items->where('item_type', 'ticket') as $item)
                            <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <span style="display:block;color:#6B5B8F;font-weight:600;">Adicionales</span>
                    <ul style="list-style:none;padding:0;margin:0.5rem 0 0;display:flex;flex-direction:column;gap:0.4rem;color:#2D1B69;font-size:0.9rem;">
                        @forelse($order->items->where('item_type', 'addon') as $item)
                            <li>{{ $item->name }} × {{ $item->quantity }} — ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}</li>
                        @empty
                            <li style="color:#9CA3AF;">Sin adicionales</li>
                        @endforelse
                    </ul>
                </div>

                <div style="border-top:1px solid rgba(147,181,245,0.2);padding-top:1rem;display:flex;justify-content:space-between;align-items:center;">
                    <span style="color:#6B5B8F;font-weight:700;">Total</span>
                    <strong style="font-size:1.4rem;color:#2D1B69;">${{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                </div>
            </aside>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const container = document.getElementById('embedded-checkout');
            const status = document.getElementById('checkout-status');

            if (!container) {
                return;
            }

            try {
                const stripe = Stripe(@json($stripePublicKey));

                if (!@json($clientSecret)) {
                    status.textContent = 'No se pudo recuperar la sesión de pago. Regresa y vuelve a intentarlo.';
                    return;
                }

                const checkout = await stripe.initEmbeddedCheckout({
                    clientSecret: @json($clientSecret),
                });

                await checkout.mount('#embedded-checkout');
                status.textContent = '';
            } catch (error) {
                console.error(error);
                status.textContent = error.message ?? 'No se pudo cargar el formulario de pago.';
            }
        });
    </script>
@endpush
