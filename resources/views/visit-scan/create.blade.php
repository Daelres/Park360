@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-6 max-w-3xl">
        <div>
            <h1 style="margin:0;font-size:2rem;color:#2D1B69;">Registrar visita con QR</h1>
            <p style="margin:0;color:#6B5B8F;">Sube el código QR entregado al cliente para marcar la hora de ingreso y alimentar las estadísticas del parque.</p>
        </div>

        @if(session('status'))
            <div style="padding:0.85rem 1.2rem;border-radius:0.75rem;background:rgba(76,175,80,0.12);color:#1B5E20;border:1px solid rgba(76,175,80,0.25);font-weight:600;">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div style="padding:0.85rem 1.2rem;border-radius:0.75rem;background:rgba(244,67,54,0.12);color:#B71C1C;border:1px solid rgba(244,67,54,0.25);font-weight:600;">
                <ul style="margin:0;padding-left:1.1rem;display:flex;flex-direction:column;gap:0.35rem;font-weight:500;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('visit-scan.store') }}" method="POST" enctype="multipart/form-data" class="card" style="display:flex;flex-direction:column;gap:1rem;">
            @csrf
            <div>
                <label for="qr_code_token" style="display:block;font-weight:600;color:#2D1B69;margin-bottom:0.35rem;">Código de verificación</label>
                <input type="text" id="qr_code_token" name="qr_code_token" value="{{ old('qr_code_token') }}" required style="width:100%;padding:0.75rem 1rem;border-radius:0.75rem;border:1px solid #d1d5db;" placeholder="Ej: AB123-CD456-EF789-GH012" />
            </div>

            <div>
                <label for="visit_hour" style="display:block;font-weight:600;color:#2D1B69;margin-bottom:0.35rem;">Hora del ingreso (opcional)</label>
                <input type="time" id="visit_hour" name="visit_hour" value="{{ old('visit_hour') }}" style="padding:0.75rem 1rem;border-radius:0.75rem;border:1px solid #d1d5db;" />
                <p style="margin:0.4rem 0 0;color:#9CA3AF;font-size:0.85rem;">Si no la registras, tomaremos la hora actual.</p>
            </div>

            <div>
                <label for="qr_upload" style="display:block;font-weight:600;color:#2D1B69;margin-bottom:0.35rem;">Archivo del QR</label>
                <input type="file" id="qr_upload" name="qr_upload" required accept="image/png,image/jpeg,image/svg+xml,application/pdf" />
                <p style="margin:0.4rem 0 0;color:#9CA3AF;font-size:0.85rem;">Admite imágenes (PNG/JPG/SVG) o PDF exportado del pase.</p>
            </div>

            <button type="submit" class="btn" style="align-self:flex-start;">Registrar visita</button>
        </form>
    </div>
@endsection
