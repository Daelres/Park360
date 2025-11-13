@csrf
@include('partials.errors')
<div class="grid grid-2">
    <div class="field">
        <label>Nombre</label>
        <input type="text" name="name" value="{{ old('name', $ticketType->name ?? '') }}" required>
    </div>
    <div class="field">
        <label>Slug</label>
        <input type="text" name="slug" value="{{ old('slug', $ticketType->slug ?? '') }}">
    </div>
    <div class="field">
        <label>Precio</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $ticketType->price ?? 0) }}" required>
    </div>
    <div class="field">
        <label>Días de validez</label>
        <input type="number" name="validity_days" value="{{ old('validity_days', $ticketType->validity_days ?? 1) }}" min="1" required>
    </div>
</div>
<div class="field">
    <label>Límite de acceso (opcional)</label>
    <input type="number" name="access_limit" value="{{ old('access_limit', $ticketType->access_limit ?? '') }}">
</div>
<div class="field">
    <label>Descripción</label>
    <textarea name="description" rows="3">{{ old('description', $ticketType->description ?? '') }}</textarea>
</div>
<div class="field">
    <label>Activo</label>
    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $ticketType->is_active ?? true))>
</div>
<button type="submit" class="btn">Guardar</button>
