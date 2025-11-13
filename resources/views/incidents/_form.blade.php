@csrf
@include('partials.errors')
<div class="grid grid-2">
    <div class="field">
        <label>Atracción</label>
        <select name="attraction_id" required>
            @foreach ($attractions as $id => $name)
                <option value="{{ $id }}" @selected(old('attraction_id', $incident->attraction_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Reportado por</label>
        <select name="reported_by_employee_id">
            <option value="">Selecciona...</option>
            @foreach ($employees as $id => $name)
                <option value="{{ $id }}" @selected(old('reported_by_employee_id', $incident->reported_by_employee_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="field">
    <label>Título</label>
    <input type="text" name="title" value="{{ old('title', $incident->title ?? '') }}" required>
</div>
<div class="field">
    <label>Descripción</label>
    <textarea name="description" rows="4" required>{{ old('description', $incident->description ?? '') }}</textarea>
</div>
<div class="grid grid-2">
    <div class="field">
        <label>Severidad</label>
        <select name="severity" required>
            @foreach (['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta', 'critical' => 'Crítica'] as $value => $label)
                <option value="{{ $value }}" @selected(old('severity', $incident->severity ?? 'low') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Estado</label>
        <select name="status" required>
            @foreach (['open' => 'Abierto', 'investigating' => 'Investigando', 'resolved' => 'Resuelto', 'closed' => 'Cerrado'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $incident->status ?? 'open') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="grid grid-2">
    <div class="field">
        <label>Reportado el</label>
        <input type="datetime-local" name="reported_at" value="{{ old('reported_at', optional($incident->reported_at ?? now())->format('Y-m-d\TH:i')) }}" required>
    </div>
    <div class="field">
        <label>Resuelto el</label>
        <input type="datetime-local" name="resolved_at" value="{{ old('resolved_at', optional($incident->resolved_at ?? null)->format('Y-m-d\TH:i')) }}">
    </div>
</div>
<div class="field">
    <label>Notas de resolución</label>
    <textarea name="resolution_notes" rows="3">{{ old('resolution_notes', $incident->resolution_notes ?? '') }}</textarea>
</div>
<button type="submit" class="btn">Guardar</button>
