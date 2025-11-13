@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1>Ventas</h1>
            <a class="btn" href="{{ route('orders.create') }}">Nueva venta</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->purchased_at?->format('Y-m-d H:i') }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>${{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td><span class="badge">{{ ucfirst($order->status) }}</span></td>
                        <td class="table-actions">
                            <a class="btn secondary" href="{{ route('orders.show', $order) }}">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
