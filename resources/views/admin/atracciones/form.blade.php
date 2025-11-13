@csrf
<div class="field">
    <label for="sede_id">Sede</label>
    <select name="sede_id" id="sede_id" required>
        <option value="">Selecciona una sede</option>
        @foreach($sedes as $id => $nombre)
            <option value="{{ $id }}" @selected(old('sede_id', optional($atraccion)->sede_id ?? ($selectedSedeId ?? null)) == $id)>{{ $nombre }}</option>
        @endforeach
    </select>
    @error('sede_id')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', optional($atraccion)->nombre ?? '') }}" required>
    @error('nombre')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="tipo">Tipo</label>
    <select name="tipo" id="tipo">
        <option value="">Selecciona un tipo</option>
        <option value="Extrema" @selected(old('tipo', optional($atraccion)->tipo ?? '') == 'Extrema')>Extrema</option>
        <option value="Infantil" @selected(old('tipo', optional($atraccion)->tipo ?? '') == 'Infantil')>Infantil</option>
        <option value="Familiar" @selected(old('tipo', optional($atraccion)->tipo ?? '') == 'Familiar')>Familiar</option>
        <option value="Interactiva/Tecnologica" @selected(old('tipo', optional($atraccion)->tipo ?? '') == 'Interactiva/Tecnologica')>Interactiva/Tecnológica</option>
    </select>
    @error('tipo')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion" id="descripcion" rows="4">{{ old('descripcion', optional($atraccion)->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="capacidad">Capacidad</label>
    <input type="number" min="0" name="capacidad" id="capacidad" value="{{ old('capacidad', optional($atraccion)->capacidad ?? '') }}" required>
    @error('capacidad')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="altura_minima">Estatura mínima (cm)</label>
    <input type="number" min="0" name="altura_minima" id="altura_minima" value="{{ old('altura_minima', optional($atraccion)->altura_minima ?? '') }}">
    @error('altura_minima')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="estado_operativo">Estado</label>
    <select name="estado_operativo" id="estado_operativo" required>
        <option value="">Selecciona un estado</option>
        <option value="Operativa" @selected(old('estado_operativo', optional($atraccion)->estado_operativo ?? '') == 'Operativa')>Operativa</option>
        <option value="Inoperativa" @selected(old('estado_operativo', optional($atraccion)->estado_operativo ?? '') == 'Inoperativa')>Inoperativa</option>
    </select>
    @error('estado_operativo')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
<div class="field">
    <label for="imagen_url">Imagen</label>
    <input type="url" name="imagen_url" id="imagen_url" value="{{ old('imagen_url', optional($atraccion)->imagen_url ?? '') }}">
    @error('imagen_url')
        <small style="color:#dc2626;">{{ $message }}</small>
    @enderror
</div>
