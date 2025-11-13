<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncidentRequest;
use App\Models\Attraction;
use App\Models\Employee;
use App\Models\Incident;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class IncidentController extends Controller
{
    public function __construct(private readonly NotificationService $notificationService)
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(): View
    {
        $incidents = Incident::query()->with(['attraction', 'reportedBy'])->latest()->paginate(10);

        return view('incidents.index', compact('incidents'));
    }

    public function create(): View
    {
        $attractions = Attraction::query()->pluck('name', 'id');
        $employees = Employee::query()->get()->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])->toArray();

        return view('incidents.create', compact('attractions', 'employees'));
    }

    public function store(IncidentRequest $request): RedirectResponse
    {
        $incident = Incident::query()->create($request->validated());
        $incident->load('attraction.employees');
        $this->notificationService->notifyIncident($incident);

        return redirect()->route('incidents.index')->with('status', 'Incidente registrado.');
    }

    public function edit(Incident $incident): View
    {
        $attractions = Attraction::query()->pluck('name', 'id');
        $employees = Employee::query()->get()->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])->toArray();

        return view('incidents.edit', compact('incident', 'attractions', 'employees'));
    }

    public function update(IncidentRequest $request, Incident $incident): RedirectResponse
    {
        $incident->update($request->validated());

        return redirect()->route('incidents.index')->with('status', 'Incidente actualizado.');
    }

    public function destroy(Incident $incident): RedirectResponse
    {
        $incident->delete();

        return redirect()->route('incidents.index')->with('status', 'Incidente eliminado.');
    }
}
