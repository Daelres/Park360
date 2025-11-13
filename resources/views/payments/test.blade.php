@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 style="margin-top: 0; margin-bottom: 1rem; font-size: 1.75rem;">Pago de prueba con Stripe Checkout embebido</h1>
        <p style="margin-bottom: 1rem;">Este flujo está pensado para validar la integración con Stripe usando el formulario incrustado. El monto de prueba es de <strong>${{ $formattedAmount }} COP</strong> por boleto.</p>

        <div style="margin-bottom: 1.5rem;">
            <label for="cantidad" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">Cantidad de boletos</label>
            <select id="cantidad" name="cantidad" style="padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #d1d5db; min-width: 120px;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <button id="iniciarPago" class="btn">Iniciar pago de prueba</button>

        <div id="estado-pago" style="margin-top: 1.5rem; color: #6B5B8F;"></div>

        <div id="contenedor-checkout" style="margin-top: 2rem;"></div>

        <p style="margin-top: 2rem; font-size: 0.95rem; color: #6B5B8F;">
            Para probar el flujo puedes usar las tarjetas de prueba de Stripe, por ejemplo <code>4242 4242 4242 4242</code> con cualquier fecha futura, CVC y código postal.
        </p>
    </div>
@endsection

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const boton = document.getElementById('iniciarPago');
            const mensajeEstado = document.getElementById('estado-pago');
            const contenedor = document.getElementById('contenedor-checkout');
            const cantidad = document.getElementById('cantidad');

            if (!boton || !contenedor) {
                return;
            }

            let checkoutInstance = null;

            const stripe = Stripe(@json($stripePublicKey));

            const fetchClientSecret = async () => {
                const respuesta = await fetch(@json(route('payments.test.session')), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ cantidad: cantidad.value }),
                });

                if (!respuesta.ok) {
                    const data = await respuesta.json().catch(() => ({}));
                    throw new Error(data.message ?? 'No se pudo iniciar la sesión de pago.');
                }

                const datos = await respuesta.json();
                return datos.clientSecret;
            };

            const iniciarCheckout = async () => {
                if (checkoutInstance) {
                    mensajeEstado.textContent = 'El formulario ya está listo para completar el pago.';
                    return;
                }

                boton.disabled = true;
                mensajeEstado.textContent = 'Preparando el formulario de pago…';

                try {
                    checkoutInstance = await stripe.initEmbeddedCheckout({
                        fetchClientSecret,
                    });

                    await checkoutInstance.mount('#contenedor-checkout');
                    mensajeEstado.textContent = '';
                } catch (error) {
                    console.error(error);
                    mensajeEstado.textContent = error.message ?? 'Ocurrió un error al cargar el formulario de pago.';
                    boton.disabled = false;
                    checkoutInstance = null;
                }
            };

            boton.addEventListener('click', iniciarCheckout);
        });
    </script>
@endpush
