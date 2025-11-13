@extends('layouts.app')

@section('content')
    <div class="hero">
        <div>
            <h1 class="text-3d-bold">Roles y permisos</h1>
            <p>Gestiona los roles y permisos de los usuarios</p>
        </div>
        <div style="display:flex; gap:1rem; align-items:center; justify-content:flex-end;">
            <a href="#crear-rol" class="btn" onclick="document.getElementById('crear-rol').scrollIntoView({behavior:'smooth'}); return false;">
                + Crear roles y permisos
            </a>
        </div>
    </div>

    @if(session('status'))
        <div class="flash-message">{{ session('status') }}</div>
    @endif

    {{-- Crear rol --}}
    <div id="crear-rol" class="card" style="margin-bottom:1rem;">
        <h2 style="margin-top:0;">Crear rol</h2>
        <p style="color:#4b5563;">Crea un rol y selecciona permisos existentes. No se crean nuevas tablas.</p>
        <form method="POST" action="{{ route('admin.roles.store') }}" style="display:grid; gap:1rem;">
            @csrf
            <div class="field">
                <label for="nombre">Nombre del rol</label>
                <input id="nombre" type="text" name="nombre" required placeholder="ej. administrador">
            </div>
            <div class="field">
                <label for="descripcion">Descripción</label>
                <input id="descripcion" type="text" name="descripcion" placeholder="Opcional">
            </div>
            <div class="field">
                <label>Permisos</label>
                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:.5rem;">
                    @forelse($permisos as $permiso)
                        <label style="display:flex; gap:.5rem; align-items:center;">
                            <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}">
                            <span>{{ $permiso->nombre }}</span>
                        </label>
                    @empty
                        <small style="color:#6b7280;">No hay permisos registrados.</small>
                    @endforelse
                </div>
            </div>
            <div>
                <button class="btn" type="submit">Crear rol</button>
            </div>
        </form>
    </div>

    {{-- Listado de usuarios --}}
    <h2 style="margin:.5rem 0;">Usuarios</h2>
    <div class="grid" style="gap:1rem;">
        @forelse($usuarios as $u)
            <div class="card" style="display:flex; flex-direction:column; gap:.5rem;">
                <div style="display:flex; align-items:center; justify-content:space-between;">
                    <strong>{{ $u->name }}</strong>
                    <span class="badge">{{ $u->email }}</span>
                </div>
                <div style="display:grid; grid-template-columns: 1fr 1fr 1fr; gap:1rem;">
                    <div>
                        <div style="font-weight:700;">Roles</div>
                        <ul style="margin:.25rem 0 0 0; padding-left:1rem;">
                            @forelse($u->roles as $r)
                                <li>{{ $r->nombre }}</li>
                            @empty
                                <li class="text-muted">Sin roles</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <div style="font-weight:700;">Permisos</div>
                        @php
                            $perms = $u->roles->flatMap(fn($r) => $r->permisos->pluck('nombre'))
                                ->unique()->values();
                        @endphp
                        @if($perms->isEmpty())
                            <p style="color:#6b7280; margin:.25rem 0 0 0;">N/D</p>
                        @else
                            <div style="display:flex; flex-wrap:wrap; gap:.35rem; margin-top:.25rem;">
                                @foreach($perms as $p)
                                    <span class="badge" style="background:var(--muted-dark); color:#111; border-color:var(--border);">{{ $p }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div>
                        <div style="font-weight:700;">Agregar rol</div>
                        <form method="POST" action="{{ route('admin.users.roles.assign', $u) }}" style="display:flex; gap:.5rem; margin-top:.25rem; align-items:center;">
                            @csrf
                            <select name="rol" style="min-width:180px;">
                                @foreach($roles as $r)
                                    <option value="{{ $r->nombre }}">{{ $r->nombre }}</option>
                                @endforeach
                            </select>
                            <button class="btn secondary" type="submit">Agregar</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card"><p>No hay usuarios registrados.</p></div>
        @endforelse
    </div>
@endsection
