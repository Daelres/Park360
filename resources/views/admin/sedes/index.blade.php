@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
            <h1>Gestión de sedes</h1>
            <p style="color:#4b5563;">Administra las ubicaciones del parque y su información clave.</p>
        </div>
        <a class="btn" href="{{ route('admin.sedes.create') }}">+ Añadir sede</a>
    </div>

    <form method="GET" action="{{ route('admin.sedes.index') }}" style="margin-bottom:1rem; display:flex; gap:1rem;">
        <input type="text" name="search" placeholder="Buscar sede" value="{{ $search }}" style="flex:1;">
        <button class="btn secondary" type="submit">Buscar</button>
    </form>

    <div class="card" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Atracciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sedes as $sede)
                    <tr>
                        <td>{{ $sede->codigo }}</td>
                        <td>{{ $sede->nombre }}</td>
                        <td>{{ $sede->ciudad }}</td>
                        <td>{{ $sede->atracciones_count }}</td>
                        <td>
                            <div class="table-actions">
                                <a class="btn secondary" href="{{ route('admin.sedes.show', $sede) }}">Ver</a>
                                <a class="btn secondary" href="{{ route('admin.sedes.edit', $sede) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.sedes.destroy', $sede) }}" onsubmit="return confirm('¿Deseas eliminar esta sede?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn secondary" type="submit">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:2rem;">No hay sedes registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem;">
        {{ $sedes->links() }}
    </div>
@endsection
