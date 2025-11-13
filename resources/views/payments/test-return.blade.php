@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 style="margin-top: 0; font-size: 1.75rem;">Estado del pago de prueba</h1>

        @php
            $status = $session->status ?? null;
            $paymentStatus = is_object($paymentIntent) ? ($paymentIntent->status ?? null) : null;
        @endphp

        @if ($status === 'complete')
            <p style="color: #059669; font-weight: 600;">¡Pago completado con éxito! 🎉</p>
            <p>La referencia del pago es <strong>{{ $session->payment_intent ?? 'N/D' }}</strong>.</p>
        @elseif ($status === 'open')
            <p style="color: #b45309; font-weight: 600;">El pago quedó pendiente o fue cancelado.</p>
            <p>Puedes intentar nuevamente desde la página de prueba para finalizar la compra.</p>
        @else
            <p style="color: #dc2626; font-weight: 600;">No pudimos determinar el estado del pago.</p>
            <p>Revisa la sesión en Stripe usando el ID <code>{{ $session->id ?? 'N/D' }}</code>.</p>
        @endif

        @if (! empty($paymentStatus))
            <p style="margin-top: 1.5rem;">
                Estado del Payment Intent: <strong>{{ strtoupper($paymentStatus) }}</strong>.
            </p>
        @endif

        <a href="{{ route('payments.test.show') }}" class="btn" style="margin-top: 2rem; display: inline-flex;">Volver a la prueba</a>
    </div>
@endsection
