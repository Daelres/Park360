@csrf
@include('partials.errors')
<div class="grid grid-2">
    <div class="field">
        <label>Atracción</label>
        <select name="attraction_id" required>
            @foreach ($attractions as $id => $name)
                <option value="{{ $id }}" @selected(old('attraction_id', $maintenance->attraction_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Estado</label>
        <select name="status" required>
            @foreach (['scheduled' => 'Programado', 'in_progress' => 'En progreso', 'completed' => 'Completado', 'cancelled' => 'Cancelado'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $maintenance->status ?? 'scheduled') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Solicitado por</label>
        <select name="requested_by_employee_id">
            <option value="">Selecciona...</option>
            @foreach ($employees as $id => $name)
                <option value="{{ $id }}" @selected(old('requested_by_employee_id', $maintenance->requested_by_employee_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Realizado por</label>
        <select name="performed_by_employee_id">
            <option value="">Selecciona...</option>
            @foreach ($employees as $id => $name)
                <option value="{{ $id }}" @selected(old('performed_by_employee_id', $maintenance->performed_by_employee_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="grid grid-2">
    <div class="field">
        <label>Programado para</label>
        <input type="datetime-local" name="scheduled_for" value="{{ old('scheduled_for', optional($maintenance->scheduled_for ?? null)->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="field">
        <label>Inicio</label>
        <input type="datetime-local" name="started_at" value="{{ old('started_at', optional($maintenance->started_at ?? null)->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="field">
        <label>Finalización</label>
        <input type="datetime-local" name="completed_at" value="{{ old('completed_at', optional($maintenance->completed_at ?? null)->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="field">
        <label>Costo</label>
        <input type="number" step="0.01" name="cost" value="{{ old('cost', $maintenance->cost ?? '') }}">
    </div>
</div>
<div class="field">
    <label>Descripción</label>
    <textarea name="description" rows="3">{{ old('description', $maintenance->description ?? '') }}</textarea>
</div>
<div class="field">
    <label>Hallazgos</label>
    <textarea name="findings" rows="3">{{ old('findings', $maintenance->findings ?? '') }}</textarea>
</div>
<button type="submit" class="btn">Guardar</button>
