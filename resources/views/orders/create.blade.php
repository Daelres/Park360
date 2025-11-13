@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Registrar venta</h1>
        <form method="POST" action="{{ route('orders.store') }}" id="order-form">
            @csrf
            @include('partials.errors')
            <div class="grid grid-2">
                <div class="field">
                    <label>Nombre del cliente</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name) }}" required>
                </div>
                <div class="field">
                    <label>Correo del cliente</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email) }}" required>
                </div>
                <div class="field">
                    <label>Teléfono</label>
                    <input type="text" name="customer_phone" value="{{ old('customer_phone') }}">
                </div>
            </div>
            <h3>Entradas</h3>
            <div id="items-container">
                @php($oldItems = old('items', [['ticket_type_id' => '', 'quantity' => 1]]))
                @foreach ($oldItems as $index => $oldItem)
                    <div class="grid grid-2 order-item" data-index="{{ $index }}" style="border:1px solid #e5e7eb; padding:1rem; border-radius:0.75rem; margin-bottom:1rem;">
                        <div class="field">
                            <label>Tipo de entrada</label>
                            <select name="items[{{ $index }}][ticket_type_id]" required>
                                <option value="">Selecciona...</option>
                                @foreach ($ticketTypes as $ticketType)
                                    <option value="{{ $ticketType->id }}" @selected($oldItem['ticket_type_id'] == $ticketType->id)>
                                        {{ $ticketType->name }} - ${{ number_format($ticketType->price, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Cantidad</label>
                            <input type="number" name="items[{{ $index }}][quantity]" value="{{ $oldItem['quantity'] ?? 1 }}" min="1" required>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn secondary" id="add-item">Agregar entrada</button>
            <button type="submit" class="btn" style="margin-left:1rem;">Confirmar compra</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addButton = document.getElementById('add-item');
            const container = document.getElementById('items-container');
            let index = container.querySelectorAll('.order-item').length;

            addButton.addEventListener('click', () => {
                const template = `
                    <div class="grid grid-2 order-item" data-index="${index}" style="border:1px solid #e5e7eb; padding:1rem; border-radius:0.75rem; margin-bottom:1rem;">
                        <div class="field">
                            <label>Tipo de entrada</label>
                            <select name="items[${index}][ticket_type_id]" required>
                                <option value="">Selecciona...</option>
                                @foreach ($ticketTypes as $ticketType)
                                    <option value="{{ $ticketType->id }}">{{ $ticketType->name }} - ${{ number_format($ticketType->price, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Cantidad</label>
                            <input type="number" name="items[${index}][quantity]" value="1" min="1" required>
                        </div>
                    </div>`;
                container.insertAdjacentHTML('beforeend', template);
                index++;
            });
        });
    </script>
@endpush
