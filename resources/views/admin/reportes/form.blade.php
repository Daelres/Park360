@csrf
<div class="card" style="display:grid; gap:1rem;">
    <div>
        <label for="inicio_at">Fecha</label>
        <input id="inicio_at" type="datetime-local" name="inicio_at" value="{{ old('inicio_at', optional($reporte->inicio_at ?? null)->format('Y-m-d\TH:i')) }}" required>
        @error('inicio_at')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="tipo">Tipo</label>
        <select id="tipo" name="tipo" required>
            <option value="">Seleccione tipo</option>
            @foreach($tipos as $value => $label)
                <option value="{{ $value }}" @selected(old('tipo', $reporte->tipo ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('tipo')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="atraccion_id">Atracción (opcional)</label>
        <select id="atraccion_id" name="atraccion_id">
            <option value="">-- Ninguna --</option>
            @foreach($atracciones as $id => $nombre)
                <option value="{{ $id }}" @selected((string) old('atraccion_id', (string)($reporte->atraccion_id ?? '')) === (string) $id)>{{ $nombre }}</option>
            @endforeach
        </select>
        @error('atraccion_id')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="severidad">Severidad (opcional)</label>
        <input id="severidad" type="text" name="severidad" value="{{ old('severidad', $reporte->severidad ?? '') }}" placeholder="Baja/Media/Alta">
        @error('severidad')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="estado">Estado (opcional)</label>
        <input id="estado" type="text" name="estado" value="{{ old('estado', $reporte->estado ?? '') }}" placeholder="Abierto/Cerrado">
        @error('estado')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="fin_at">Fin (opcional)</label>
        <input id="fin_at" type="datetime-local" name="fin_at" value="{{ old('fin_at', optional($reporte->fin_at ?? null)->format('Y-m-d\TH:i')) }}">
        @error('fin_at')<div class="error">{{ $message }}</div>@enderror
    </div>

    <div>
        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4" placeholder="Detalles del reporte">{{ old('descripcion', $reporte->descripcion ?? '') }}</textarea>
        @error('descripcion')<div class="error">{{ $message }}</div>@enderror
    </div>
</div>

<div style="display:flex; gap:.5rem; margin-top:1rem;">
    <a class="btn secondary" href="{{ route('admin.reportes.index') }}">Cancelar</a>
    <button class="btn" type="submit">Guardar</button>
</div>
