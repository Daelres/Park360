@extends('layouts.app')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;">
        <div>
            <h1>Reportes</h1>
            <p style="color:#4b5563;">Gestiona los reportes registrados en el sistema.</p>
        </div>
        <a class="btn" href="{{ route('admin.reportes.create') }}">+ Añadir reporte</a>
    </div>

    {{-- KPIs rápidos --}}
    @isset($kpis)
        <div class="grid grid-3" style="margin-bottom:1rem;">
            <div class="card">
                <div style="display:flex; align-items:center; gap:.75rem;">
                    <div class="badge">Total</div>
                    <strong style="font-size:1.4rem;">{{ number_format($kpis['total']) }}</strong>
                </div>
            </div>
            <div class="card">
                <div style="display:flex; align-items:center; gap:.75rem;">
                    <div class="badge warning">Abiertos</div>
                    <strong style="font-size:1.4rem;">{{ number_format($kpis['abiertos']) }}</strong>
                </div>
            </div>
            <div class="card">
                <div style="display:flex; align-items:center; gap:.75rem;">
                    <div class="badge success">Cerrados</div>
                    <strong style="font-size:1.4rem;">{{ number_format($kpis['cerrados']) }}</strong>
                </div>
            </div>
        </div>
    @endisset

    <form method="GET" action="{{ route('admin.reportes.index') }}" style="display:flex; flex-wrap:wrap; gap:1rem; margin-bottom:1rem; align-items:center;">
        <input type="text" name="search" placeholder="Buscar por código, email o tipo" value="{{ $search }}" style="flex:1 1 260px; min-width:220px;">
        <select name="tipo" style="flex:0 1 220px; min-width:200px;">
            <option value="">Todos los tipos</option>
            @foreach($tipos as $value => $label)
                <option value="{{ $value }}" @selected($tipo === $value)>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn secondary" type="submit" style="flex:0 0 auto;">Filtrar</button>
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
                                <a href="{{ route('admin.reportes.show', $reporte) }}">👁️ Ver</a>
                                <a href="{{ route('admin.reportes.edit', $reporte)  }}">✏️ Editar</a>
                                <form method="POST" action="{{  route('admin.reportes.destroy', $reporte)  }}" style="display: inline;" onsubmit="return confirm('¿Eliminar reporte?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: #FFE8E8; color: #FF6B35;">🗑️ Eliminar</button>
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
