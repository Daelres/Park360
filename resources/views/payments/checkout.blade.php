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
            <section class="card" style="min-height:420px;display:flex;flex-direction:column;gap:1rem;">
                <h2 style="margin:0;color:#2D1B69;">Pago seguro con Stripe</h2>
                <div id="checkout-status" style="color:#6B5B8F;font-size:0.95rem;">Preparando el formulario…</div>
                <div id="embedded-checkout" style="flex:1;min-height:360px;border:1px solid rgba(147,181,245,0.3);border-radius:1rem;overflow:hidden;background:white;margin:2rem auto;width:100%;max-width:540px;padding:0.75rem 0.5rem;"></div>
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
