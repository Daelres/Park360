@csrf
@include('partials.errors')
<div class="grid grid-2">
    <div class="field">
        <label>Nombre</label>
        <input type="text" name="first_name" value="{{ old('first_name', $employee->first_name ?? '') }}" required>
    </div>
    <div class="field">
        <label>Apellido</label>
        <input type="text" name="last_name" value="{{ old('last_name', $employee->last_name ?? '') }}" required>
    </div>
    <div class="field">
        <label>Correo electrónico</label>
        <input type="email" name="email" value="{{ old('email', $employee->email ?? '') }}" required>
    </div>
    <div class="field">
        <label>Teléfono</label>
        <input type="text" name="phone" value="{{ old('phone', $employee->phone ?? '') }}">
    </div>
    <div class="field">
        <label>Cargo</label>
        <input type="text" name="position" value="{{ old('position', $employee->position ?? '') }}" required>
    </div>
    <div class="field">
        <label>Número de documento</label>
        <input type="text" name="document_number" value="{{ old('document_number', $employee->document_number ?? '') }}" required>
    </div>
    <div class="field">
        <label>Fecha de ingreso</label>
        <input type="date" name="hire_date" value="{{ old('hire_date', optional($employee->hire_date ?? null)->format('Y-m-d')) }}" required>
    </div>
    <div class="field">
        <label>Estado</label>
        <select name="status" required>
            @foreach (['active' => 'Activo', 'inactive' => 'Inactivo', 'suspended' => 'Suspendido'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $employee->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field">
        <label>Contacto de emergencia</label>
        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $employee->emergency_contact_name ?? '') }}">
    </div>
    <div class="field">
        <label>Teléfono de emergencia</label>
        <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone ?? '') }}">
    </div>
</div>
<div class="field">
    <label>Notas</label>
    <textarea name="notes" rows="3">{{ old('notes', $employee->notes ?? '') }}</textarea>
</div>
<div class="field">
    <label>Atracciones asignadas</label>
    <select name="attractions[]" multiple size="5">
        @foreach ($attractions as $id => $name)
            <option value="{{ $id }}" @selected(in_array($id, old('attractions', isset($employee) ? $employee->attractions->pluck('id')->toArray() : [])))>{{ $name }}</option>
        @endforeach
    </select>
</div>
<button type="submit" class="btn">Guardar</button>
