@extends('layouts.app')

@section('content')
    <div class="grid grid-2">
        <div class="card">
            <h1>Completa tu pago</h1>
            <p style="color:#4b5563;">Ingresa los datos para iniciar el proceso de pago a través de PayU. Te redirigiremos cuando la integración esté disponible.</p>

            <form method="POST" action="{{ route('payments.store') }}" style="margin-top: 1.5rem; display:grid; gap:1rem;">
                @csrf
                <div class="field">
                    <label for="nombre">Nombre completo</label>
                    <input
                        type="text"
                        name="nombre"
                        id="nombre"
                        value="{{ old('nombre', $customer['name'] ?? '') }}"
                        required
                    >
                    @error('nombre')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="correo">Correo electrónico</label>
                    <input
                        type="email"
                        name="correo"
                        id="correo"
                        value="{{ old('correo', $customer['email'] ?? '') }}"
                        required
                    >
                    @error('correo')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="plan">Plan</label>
                    <input type="text" name="plan" id="plan" value="{{ old('plan', $plan) }}" required>
                    @error('plan')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="monto">Monto (COP)</label>
                    <input type="number" step="0.01" min="0" name="monto" id="monto" value="{{ old('monto') }}" required>
                    @error('monto')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="metodo_pago">Método preferido</label>
                    <select name="metodo_pago" id="metodo_pago" required>
                        <option value="">Selecciona una opción</option>
                        <option value="tarjeta" @selected(old('metodo_pago') === 'tarjeta')>Tarjeta de crédito / débito</option>
                        <option value="pse" @selected(old('metodo_pago') === 'pse')>PSE</option>
                        <option value="efecty" @selected(old('metodo_pago') === 'efecty')>Efecty</option>
                    </select>
                    @error('metodo_pago')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn">Procesar pago</button>
            </form>
        </div>
        <div class="card" style="background: linear-gradient(135deg, rgba(29,78,216,0.9), rgba(59,130,246,0.8)); color:white;">
            <h2 style="font-size:1.75rem;">Integración PayU</h2>
            <p>El módulo está listo para conectarse con PayU. Próximamente se añadirá la redirección automática y confirmación en tiempo real.</p>
            <ul style="margin-top:1.5rem; line-height:1.8;">
                <li>• Registro de solicitudes de pago</li>
                <li>• Validaciones de datos del cliente</li>
                <li>• Espacio para tokenización y firma digital</li>
                <li>• Mensajería clara al usuario</li>
            </ul>
        </div>
    </div>
@endsection
