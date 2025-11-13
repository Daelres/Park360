<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sede;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SedeController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $sedes = Sede::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', "%{$search}%")
                        ->orWhere('codigo', 'like', "%{$search}%")
                        ->orWhere('ciudad', 'like', "%{$search}%");
                });
            })
            ->withCount('atracciones')
            ->orderBy('nombre')
            ->paginate(10)
            ->withQueryString();

        return view('admin.sedes.index', [
            'sedes' => $sedes,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.sedes.create', [
            'sede' => new Sede(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'correo_contacto' => ['nullable', 'email', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'gerente' => ['nullable', 'string', 'max:255'],
        ]);

        // Generate unique code from name
        $validated['codigo'] = $this->generateUniqueCode($validated['nombre']);

        $sede = Sede::create($validated);

        return redirect()
            ->route('admin.sedes.show', $sede)
            ->with('status', 'Sede creada correctamente.');
    }

    public function show(Sede $sede): View
    {
        $sede->load(['atracciones' => function ($query) {
            $query->orderBy('nombre');
        }]);

        return view('admin.sedes.show', [
            'sede' => $sede,
        ]);
    }

    public function edit(Sede $sede): View
    {
        return view('admin.sedes.edit', [
            'sede' => $sede,
        ]);
    }

    public function update(Request $request, Sede $sede): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:255'],
            'direccion' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'correo_contacto' => ['nullable', 'email', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'gerente' => ['nullable', 'string', 'max:255'],
        ]);

        $sede->update($validated);

        return redirect()
            ->route('admin.sedes.show', $sede)
            ->with('status', 'Sede actualizada correctamente.');
    }

    public function destroy(Sede $sede): RedirectResponse
    {
        $sede->delete();

        return redirect()
            ->route('admin.sedes.index')
            ->with('status', 'Sede eliminada.');
    }

    private function generateUniqueCode(string $nombre): string
    {
        // Generate code from name: take first 3 letters + count + random suffix
        $baseCode = strtoupper(substr($nombre, 0, 3));
        $count = Sede::where('codigo', 'like', $baseCode . '%')->count();
        $code = $baseCode . str_pad($count + 1, 3, '0', STR_PAD_LEFT);

        // Check if code already exists, if so add random suffix
        while (Sede::where('codigo', $code)->exists()) {
            $code = $baseCode . str_pad($count + 1, 3, '0', STR_PAD_LEFT) . strtoupper(chr(rand(65, 90)));
        }

        return $code;
    }
}
