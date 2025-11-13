<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Atraccion;
use App\Models\Sede;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AtraccionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();
        $sedeId = $request->integer('sede_id');

        $atracciones = Atraccion::query()
            ->with('sede')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('tipo', 'like', "%{$search}%")
                        ->orWhere('estado_operativo', 'like', "%{$search}%");
                });
            })
            ->when($sedeId, function ($query) use ($sedeId) {
                $query->where('sede_id', $sedeId);
            })
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        $sedes = Sede::orderBy('nombre')->pluck('nombre', 'id');

        return view('admin.atracciones.index', [
            'atracciones' => $atracciones,
            'sedes' => $sedes,
            'selectedSede' => $sedeId,
            'search' => $search,
        ]);
    }

    public function create(Request $request): View
    {
        return view('admin.atracciones.create', [
            'sedes' => Sede::orderBy('nombre')->pluck('nombre', 'id'),
            // Pasamos una instancia vacía para evitar instanciar el modelo en la vista
            'atraccion' => new Atraccion(),
            // Selección inicial de sede proveniente de la petición (si aplica)
            'selectedSedeId' => $request->integer('sede_id') ?: null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateData($request);

        $atraccion = Atraccion::create($validated);

        return redirect()
            ->route('admin.atracciones.show', $atraccion)
            ->with('status', 'Atracción creada correctamente.');
    }

    public function show(Atraccion $atraccione): View
    {
        $atraccione->load('sede');

        return view('admin.atracciones.show', [
            'atraccion' => $atraccione,
        ]);
    }

    public function edit(Atraccion $atraccione): View
    {
        return view('admin.atracciones.edit', [
            'atraccion' => $atraccione,
            'sedes' => Sede::orderBy('nombre')->pluck('nombre', 'id'),
        ]);
    }

    public function update(Request $request, Atraccion $atraccione): RedirectResponse
    {
        $validated = $this->validateData($request, $atraccione->id);

        $atraccione->update($validated);

        return redirect()
            ->route('admin.atracciones.show', $atraccione)
            ->with('status', 'Atracción actualizada correctamente.');
    }

    public function destroy(Atraccion $atraccione): RedirectResponse
    {
        $atraccione->delete();

        return redirect()
            ->route('admin.atracciones.index')
            ->with('status', 'Atracción eliminada.');
    }

    protected function validateData(Request $request, ?int $atraccionId = null): array
    {
        return $request->validate([
            'sede_id' => ['required', 'exists:sedes,id'],
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'tipo' => ['nullable', 'string', 'max:255'],
            'altura_minima' => ['nullable', 'integer', 'min:0'],
            'capacidad' => ['required', 'integer', 'min:0'],
            'estado_operativo' => ['required', 'string', 'max:255'],
            'imagen_url' => ['nullable', 'url'],
        ]);
    }
}
