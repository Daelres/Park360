@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Detalle de orden</h1>
        <p><strong>Cliente:</strong> {{ $order->customer_name }} ({{ $order->customer_email }})</p>
        <p><strong>Total:</strong> ${{ number_format($order->total_amount, 0, ',', '.') }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($order->status) }}</p>

        <h3>Entradas</h3>
        <table>
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Tickets</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->ticketType->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        <td>
                            <ul>
                                @foreach ($item->tickets as $ticket)
                                    <li>
                                        Código: {{ $ticket->code }}
                                        <div style="display:inline-flex; gap:0.5rem; margin-left:0.5rem;">
                                            @if($ticket->pdf_path)
                                                <a class="btn secondary" href="{{ route('orders.tickets.pdf', [$order, $ticket]) }}">PDF</a>
                                            @endif
                                            @if($ticket->qr_path)
                                                <a class="btn secondary" href="{{ route('orders.tickets.qr', [$order, $ticket]) }}">QR</a>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn secondary" href="{{ route('orders.index') }}">Volver</a>
    </div>
@endsection
