@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 style="margin-top:0; font-size:1.75rem;">Resumen de tu pago</h1>

        @php
            $status = $session->status ?? null;
            $paymentStatus = is_object($paymentIntent) ? ($paymentIntent->status ?? null) : null;
        @endphp

        @if ($status === 'complete')
            <p style="color:#059669; font-weight:600;">¡Pago completado con éxito! 🎉</p>
            <p>Guarda esta referencia para cualquier consulta: <strong>{{ $session->payment_intent ?? 'N/D' }}</strong>.</p>
        @elseif ($status === 'open')
            <p style="color:#b45309; font-weight:600;">El pago quedó pendiente o fue cancelado.</p>
            <p>Puedes volver a intentarlo desde la página de pagos.</p>
        @else
            <p style="color:#dc2626; font-weight:600;">No pudimos confirmar el estado del pago.</p>
            <p>Revisa la sesión en Stripe con el ID <code>{{ $session->id ?? 'N/D' }}</code>.</p>
        @endif

        @if (! empty($paymentStatus))
            <p style="margin-top:1.5rem;">Estado del Payment Intent: <strong>{{ strtoupper($paymentStatus) }}</strong>.</p>
        @endif

        <div style="display:flex; gap:1rem; margin-top:2rem;">
            <a href="{{ route('payments.create', ['plan' => $session->metadata['plan'] ?? 'GENERAL']) }}" class="btn">Realizar otro pago</a>
            <a href="{{ route('dashboard') }}" class="btn secondary">Ir al panel</a>
        </div>
    </div>
@endsection
