<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaintenanceRequest;
use App\Models\Attraction;
use App\Models\Employee;
use App\Models\Maintenance;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(): View
    {
        $maintenances = Maintenance::query()->with(['attraction', 'requestedBy', 'performedBy'])->latest()->paginate(10);

        return view('maintenances.index', compact('maintenances'));
    }

    public function create(): View
    {
        $attractions = Attraction::query()->pluck('name', 'id');
        $employees = Employee::query()->get()->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])->toArray();

        return view('maintenances.create', compact('attractions', 'employees'));
    }

    public function store(MaintenanceRequest $request): RedirectResponse
    {
        Maintenance::query()->create($request->validated());

        return redirect()->route('maintenances.index')->with('status', 'Mantenimiento programado.');
    }

    public function edit(Maintenance $maintenance): View
    {
        $attractions = Attraction::query()->pluck('name', 'id');
        $employees = Employee::query()->get()->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])->toArray();

        return view('maintenances.edit', compact('maintenance', 'attractions', 'employees'));
    }

    public function update(MaintenanceRequest $request, Maintenance $maintenance): RedirectResponse
    {
        $maintenance->update($request->validated());

        return redirect()->route('maintenances.index')->with('status', 'Mantenimiento actualizado.');
    }

    public function destroy(Maintenance $maintenance): RedirectResponse
    {
        $maintenance->delete();

        return redirect()->route('maintenances.index')->with('status', 'Mantenimiento eliminado.');
    }
}
