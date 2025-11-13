@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
            <h1>Reportes</h1>
            <p style="color:#4b5563;">Gestiona los reportes registrados en el sistema.</p>
        </div>
        <a class="btn" href="{{ route('admin.reportes.create') }}">+ Añadir reporte</a>
    </div>

    <form method="GET" action="{{ route('admin.reportes.index') }}" style="display:flex; gap:1rem; margin-bottom:1rem;">
        <input type="text" name="search" placeholder="Buscar por código, email o tipo" value="{{ $search }}" style="flex:1;">
        <select name="tipo" style="min-width:200px;">
            <option value="">Todos los tipos</option>
            @foreach($tipos as $value => $label)
                <option value="{{ $value }}" @selected($tipo === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn secondary" type="submit">Filtrar</button>
    </form>

    <div class="card" style="padding:0;">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Creado por</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reportes as $reporte)
                    <tr>
                        <td>{{ str_pad($reporte->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ optional($reporte->inicio_at)->format('Y-m-d H:i') }}</td>
                        <td>{{ $reporte->reportadoPor->email ?? 'N/D' }}</td>
                        <td>{{ $reporte->tipo }}</td>
                        <td>
                            <div class="table-actions">
                                <a class="btn secondary" href="{{ route('admin.reportes.show', $reporte) }}">Ver</a>
                                <a class="btn secondary" href="{{ route('admin.reportes.edit', $reporte) }}">Editar</a>
                                <form method="POST" action="{{ route('admin.reportes.destroy', $reporte) }}" onsubmit="return confirm('¿Eliminar reporte?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn secondary" type="submit">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:2rem;">No hay reportes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:1rem;">
        {{ $reportes->links() }}
    </div>
@endsection
