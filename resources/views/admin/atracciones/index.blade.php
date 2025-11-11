@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
            <h1>Gestión de atracciones</h1>
            <p style="color:#4b5563;">Consulta y administra el catálogo de atracciones por sede.</p>
        </div>
        <a class="btn" href="{{ route('admin.atracciones.create') }}">+ Añadir atracción</a>
    </div>

    <form method="GET" action="{{ route('admin.atracciones.index') }}" style="display:flex; gap:1rem; margin-bottom:1rem;">
        <input type="text" name="search" placeholder="Buscar" value="{{ $search }}" style="flex:1;">
        <select name="sede_id" style="min-width:200px;">
            <option value="">Todas las sedes</option>
            @foreach($sedes as $id => $nombre)
                <option value="{{ $id }}" @selected($selectedSede == $id)>{{ $nombre }}</option>
            @endforeach
        </select>
        <button class="btn secondary" type="submit">Filtrar</button>
    </form>

    <div class="card" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Sede</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($atracciones as $atraccion)
                    <tr>
                        <td>{{ $atraccion->nombre }}</td>
                        <td>{{ $atraccion->sede->nombre ?? 'No asignada' }}</td>
                        <td>{{ $atraccion->tipo ?? 'General' }}</td>
                        <td><span class="badge">{{ $atraccion->estado_operativo }}</span></td>
                        <td>
                            <div class="table-actions">
                                <a class="btn secondary" href="{{ route('admin.atracciones.show', $atraccion) }}">Ver</a>
                                <a class="btn secondary" href="{{ route('admin.atracciones.edit', $atraccion) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.atracciones.destroy', $atraccion) }}" onsubmit="return confirm('¿Eliminar atracción?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn secondary" type="submit">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:2rem;">No hay atracciones registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem;">
        {{ $atracciones->links() }}
    </div>
@endsection
