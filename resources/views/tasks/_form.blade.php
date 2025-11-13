@csrf
@include('partials.errors')
<div class="grid grid-2">
    <div class="field">
        <label>Atracción</label>
        <select name="attraction_id" required>
            @foreach ($attractions as $id => $name)
                <option value="{{ $id }}" @selected(old('attraction_id', $task->attraction_id ?? '') == $id)>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Título</label>
        <input type="text" name="title" value="{{ old('title', $task->title ?? '') }}" required>
    </div>
    <div class="field">
        <label>Frecuencia</label>
        <select name="frequency" required>
            @foreach (['daily' => 'Diaria', 'weekly' => 'Semanal', 'monthly' => 'Mensual', 'ad-hoc' => 'Ad-hoc'] as $value => $label)
                <option value="{{ $value }}" @selected(old('frequency', $task->frequency ?? 'ad-hoc') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Estado</label>
        <select name="status" required>
            @foreach (['pending' => 'Pendiente', 'in_progress' => 'En progreso', 'completed' => 'Completada', 'cancelled' => 'Cancelada'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $task->status ?? 'pending') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="field">
    <label>Descripción</label>
    <textarea name="description" rows="3">{{ old('description', $task->description ?? '') }}</textarea>
</div>
<div class="grid grid-2">
    <div class="field">
        <label>Programada para</label>
        <input type="datetime-local" name="scheduled_for" value="{{ old('scheduled_for', optional($task->scheduled_for ?? null)->format('Y-m-d\TH:i')) }}">
    </div>
    <div class="field">
        <label>Completada el</label>
        <input type="datetime-local" name="completed_at" value="{{ old('completed_at', optional($task->completed_at ?? null)->format('Y-m-d\TH:i')) }}">
    </div>
</div>
<div class="field">
    <label>Notas</label>
    <textarea name="notes" rows="3">{{ old('notes', $task->notes ?? '') }}</textarea>
</div>
<div class="field">
    <label>Personal asignado</label>
    <select name="employees[]" multiple size="5">
        @foreach ($employees as $id => $name)
            <option value="{{ $id }}" @selected(in_array($id, old('employees', isset($task) ? $task->assignments->pluck('id')->toArray() : [])))>{{ $name }}</option>
        @endforeach
    </select>
</div>
<button type="submit" class="btn">Guardar</button>
