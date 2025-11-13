@csrf
@include('partials.errors')
<div class="grid grid-2">
    <div class="field">
        <label>Nombre</label>
        <input type="text" name="name" value="{{ old('name', $attraction->name ?? '') }}" required>
    </div>
    <div class="field">
        <label>Estado</label>
        <select name="status" required>
            @foreach (['active' => 'Activa', 'maintenance' => 'En mantenimiento', 'closed' => 'Cerrada'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $attraction->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Capacidad</label>
        <input type="number" name="capacity" value="{{ old('capacity', $attraction->capacity ?? 0) }}" min="0" required>
    </div>
    <div class="field">
        <label>Ubicación</label>
        <input type="text" name="location" value="{{ old('location', $attraction->location ?? '') }}">
    </div>
    <div class="field">
        <label>Apertura</label>
        <input type="time" name="opening_time" value="{{ old('opening_time', optional($attraction->opening_time ?? null)->format('H:i')) }}">
    </div>
    <div class="field">
        <label>Cierre</label>
        <input type="time" name="closing_time" value="{{ old('closing_time', optional($attraction->closing_time ?? null)->format('H:i')) }}">
    </div>
</div>
<div class="field">
    <label>Descripción</label>
    <textarea name="description" rows="3">{{ old('description', $attraction->description ?? '') }}</textarea>
</div>
<div class="field">
    <label>Notas de mantenimiento</label>
    <textarea name="maintenance_notes" rows="3">{{ old('maintenance_notes', $attraction->maintenance_notes ?? '') }}</textarea>
</div>
<div class="field">
    <label>Próxima inspección</label>
    <input type="date" name="next_maintenance_at" value="{{ old('next_maintenance_at', optional($attraction->next_maintenance_at ?? null)->format('Y-m-d')) }}">
</div>
<div class="field">
    <label>Personal asignado</label>
    <select name="employees[]" multiple size="5">
        @foreach ($employees as $id => $name)
            <option value="{{ $id }}" @selected(in_array($id, old('employees', isset($attraction) ? $attraction->employees->pluck('id')->toArray() : [])))>{{ $name }}</option>
        @endforeach
    </select>
</div>
<button type="submit" class="btn">Guardar</button>
