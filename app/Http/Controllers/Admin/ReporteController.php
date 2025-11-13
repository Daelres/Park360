<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Incidente;
use App\Models\Atraccion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReporteController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $tipo = $request->string('tipo')->toString();

        $reportes = Incidente::query()
            ->with(['reportadoPor'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', $search)
                      ->orWhere('tipo', 'like', "%{$search}%")
                      ->orWhereHas('reportadoPor', function ($q2) use ($search) {
                          $q2->where('email', 'like', "%{$search}%");
                      });
                });
            })
            ->when($tipo, fn($q) => $q->where('tipo', $tipo))
            ->orderByDesc('inicio_at')
            ->paginate(10)
            ->withQueryString();

        $tipos = $this->tipos();

        // Métricas rápidas para la cabecera (sin romper estilos)
        $kpis = [
            'total' => (clone $reportes)->total(),
            'abiertos' => Incidente::whereNull('fin_at')->count(),
            'cerrados' => Incidente::whereNotNull('fin_at')->count(),
        ];

        return view('admin.reportes.index', [
            'reportes' => $reportes,
            'search' => $search,
            'tipo' => $tipo,
            'tipos' => $tipos,
            'kpis' => $kpis,
        ]);
    }

    public function create(): View
    {
        return view('admin.reportes.create', [
            'tipos' => $this->tipos(),
            'atracciones' => Atraccion::orderBy('nombre')->pluck('nombre', 'id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);
        $validated['reportado_por_id'] = $request->user()->id;

        $reporte = Incidente::create($validated);

        return redirect()->route('admin.reportes.show', $reporte)
            ->with('status', 'Reporte creado correctamente.');
    }

    public function show(Incidente $reporte): View
    {
        $reporte->load(['reportadoPor', 'atraccion']);
        return view('admin.reportes.show', [
            'reporte' => $reporte,
        ]);
    }

    public function edit(Incidente $reporte): View
    {
        return view('admin.reportes.edit', [
            'reporte' => $reporte,
            'tipos' => $this->tipos(),
            'atracciones' => Atraccion::orderBy('nombre')->pluck('nombre', 'id'),
        ]);
    }

    public function update(Request $request, Incidente $reporte): RedirectResponse
    {
        $validated = $this->validateData($request);
        $reporte->update($validated);

        return redirect()->route('admin.reportes.show', $reporte)
            ->with('status', 'Reporte actualizado correctamente.');
    }

    public function destroy(Incidente $reporte): RedirectResponse
    {
        $reporte->delete();
        return redirect()->route('admin.reportes.index')
            ->with('status', 'Reporte eliminado.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'atraccion_id' => ['nullable', 'exists:atracciones,id'],
            'tipo' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'severidad' => ['nullable', 'string', 'max:50'],
            'inicio_at' => ['required', 'date'],
            'fin_at' => ['nullable', 'date', 'after_or_equal:inicio_at'],
            'estado' => ['nullable', 'string', 'max:50'],
        ]);
    }

    protected function tipos(): array
    {
        return [
            'Operativo' => 'Operativo',
            'Financiero' => 'Financiero',
            'Seguridad' => 'Seguridad',
            'Mantenimiento' => 'Mantenimiento',
        ];
    }
}
