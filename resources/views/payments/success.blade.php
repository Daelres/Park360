@extends('layouts.app')

@section('content')
    <div class="container py-4">

        {{-- ENCABEZADO --}}
        <div class="d-flex flex-wrap justify-content-between align-items-start mb-4 gap-3 text-center">
            <div>
                <h1 class="m-2" style="font-size:2.1rem;color:#2D1B69;">¡Compra exitosa!</h1>
            </div>
        </div>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="row g-4">

            {{-- COLUMNA PRINCIPAL --}}
            <div class="col-lg-8">

                <div class="card p-4">
                    <div class="text-center card" style="font-size:1.1rem; background-color: #2fff9e">
                        <p class="m-2">
                            Estos son los detalles de tu visita. Presenta el código QR en la entrada del parque para agilizar tu
                            ingreso.
                        </p>
                    </div>

                    {{-- CABECERA DE ORDEN --}}
                    <div class="d-flex justify-content-between align-items-start mb-4 mt-4 flex-wrap gap-3">
                        <div>
                            <span class="text-muted fw-semibold" style="color:#6B5B8F;">Número de orden</span>
                            <h2 class="m-0" style="color:#2D1B69;">#{{ strtoupper($order->uuid) }}</h2>
                        </div>

                        <div class="text-end mb-4">
                            <span class="d-block text-muted"
                                  style="font-size:0.85rem;color:#6B5B8F;">Fecha de compra</span>
                            <strong style="color:#2D1B69;">
                                {{ optional($order->paid_at, fn ($date) => $date->timezone(config('app.timezone'))->translatedFormat('l j \d\e F Y H:i')) }}
                            </strong>
                        </div>

                        {{-- COLUMNA QR --}}
                        <div class="col-lg-4 mb-4">

                            <div class="card justify-center p-4 text-center position-sticky" style="top:1rem;">

                                <span class="fw-semibold d-block mb-2" style="color:#6B5B8F;">Tu pase digital</span>

                                @if($order->qr_code_path)
                                    <img src="{{ asset('storage/'.$order->qr_code_path) }}"
                                         alt="Código QR de la visita"
                                         class="img-fluid mb-3"
                                         style="max-width:240px;border-radius:1rem;border:1px solid rgba(147,181,245,0.25);background:white;padding:0.75rem;">
                                @else
                                    <div class="d-flex justify-content-center align-items-center mb-3"
                                         style="width:240px;height:240px;border-radius:1rem;border:1px dashed rgba(147,181,245,0.5);color:#9CA3AF;">
                                        QR no disponible
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <span class="d-block text-muted" style="font-size:0.85rem;color:#6B5B8F;">Código de verificación</span>
                                    <strong style="color:#2D1B69;font-size:1.1rem;">
                                        {{ $order->qr_code_token }}
                                    </strong>
                                </div>

                                @if($order->qr_code_path)
                                    <a href="{{ asset('storage/'.$order->qr_code_path) }}"
                                       class="btn btn-primary w-100 mb-2" download>
                                        Descargar QR
                                    </a>
                                @endif

                                <p class="m-0" style="color:#9CA3AF;font-size:0.8rem;">
                                    Conserva el QR para cualquier control durante tu visita.
                                </p>

                            </div>
                        </div>
                    </div>

                    {{-- RESUMEN DE COMPRA --}}
                    <div class="border rounded p-3 mb-4" style="border-color:rgba(147,181,245,0.2);">
                        <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-3 text-center">
                            <div class="mt-4">
                                <span class="fw-semibold" style="color:#6B5B8F;">Visita agendada</span>
                                <div class="fw-bold" style="color:#2D1B69;font-size:1.1rem;">
                                    {{ optional($order->visitDate?->visit_date, fn ($date) => $date->translatedFormat('l j \d\e F Y')) }}
                                </div>
                            </div>

                            <div class="text-end">
                                <span class="fw-semibold" style="color:#6B5B8F;">Importe total</span>
                                <div class="fw-bold" style="color:#2D1B69;font-size:1.2rem;">
                                    ${{ number_format($order->total_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>

                        {{-- Entradas --}}
                        <div class="mb-3 text-center">
                            <span class="fw-semibold d-block mb-2" style="color:#6B5B8F;">Entradas</span>
                            <ul class="list-unstyled m-0 ps-0">
                                @foreach($order->items->where('item_type', 'ticket') as $item)
                                    <li class="mb-1" style="color:#2D1B69;font-size:0.95rem;">
                                        {{ $item->name }} × {{ $item->quantity }} —
                                        ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Adicionales --}}
                        <div class="text-center mb-4">
                            <span class="fw-semibold d-block mb-2" style="color:#6B5B8F;">Adicionales</span>
                            <ul class="list-unstyled m-0 ps-0">
                                @forelse($order->items->where('item_type', 'addon') as $item)
                                    <li class="mb-1" style="color:#2D1B69;font-size:0.95rem;">
                                        {{ $item->name }} × {{ $item->quantity }} —
                                        ${{ number_format($item->unit_amount * $item->quantity, 0, ',', '.') }}
                                    </li>
                                @empty
                                    <li style="color:#9CA3AF;">Sin productos adicionales</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    {{-- RECOMENDACIONES --}}
                    <div class="card p-3"
                         style="background:rgba(147,181,245,0.08);border:1px dashed rgba(147,181,245,0.3);">
                        <h3 class="mb-3" style="color:#2D1B69;">Recomendaciones</h3>
                        <ul class="mb-0 ps-3" style="color:#6B5B8F;font-size:0.9rem;">
                            <li>Presenta el código QR desde tu móvil o impreso al ingresar.</li>
                            <li>Llega 15 minutos antes de la hora planificada para agilizar tu check-in.</li>
                            <li>Si necesitas cambiar la fecha, contáctanos con el número de orden.</li>
                        </ul>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('payments.create') }}" class="btn btn-secondary">
                            Planear otra visita
                        </a>
                    </div>


                </div>
            </div>

        </div>
    </div>
@endsection
