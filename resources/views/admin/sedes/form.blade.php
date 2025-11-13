@php($sede = $sede ?? new \App\Models\Sede())
@csrf
<div class="field">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $sede->nombre ?? '') }}" required>
    @error('nombre')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="ciudad">Ciudad</label>
    <input type="text" name="ciudad" id="ciudad" value="{{ old('ciudad', $sede->ciudad ?? '') }}" required>
    @error('ciudad')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="direccion">Dirección</label>
    <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $sede->direccion ?? '') }}" required>
    @error('direccion')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="telefono">Teléfono</label>
    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $sede->telefono ?? '') }}">
    @error('telefono')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="correo_contacto">Correo de contacto</label>
    <input type="email" name="correo_contacto" id="correo_contacto" value="{{ old('correo_contacto', $sede->correo_contacto ?? '') }}">
    @error('correo_contacto')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="gerente">Gerente</label>
    <input type="text" name="gerente" id="gerente" value="{{ old('gerente', $sede->gerente ?? '') }}">
    @error('gerente')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $sede->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
