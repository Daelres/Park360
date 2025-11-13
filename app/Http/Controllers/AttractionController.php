<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttractionRequest;
use App\Models\Attraction;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttractionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(): View
    {
        $attractions = Attraction::query()->withCount(['incidents', 'maintenances'])->paginate(10);

        return view('attractions.index', compact('attractions'));
    }

    public function create(): View
    {
        $employees = Employee::query()
            ->get()
            ->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])
            ->toArray();

        return view('attractions.create', compact('employees'));
    }

    public function store(AttractionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $employees = $data['employees'] ?? [];
        unset($data['employees']);

        $attraction = Attraction::query()->create($data);
        $attraction->employees()->sync($employees);

        return redirect()->route('attractions.index')->with('status', 'Atracción creada.');
    }

    public function show(Attraction $attraction): View
    {
        $attraction->load(['employees', 'incidents', 'maintenances']);

        return view('attractions.show', compact('attraction'));
    }

    public function edit(Attraction $attraction): View
    {
        $attraction->load('employees');
        $employees = Employee::query()
            ->get()
            ->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])
            ->toArray();

        return view('attractions.edit', compact('attraction', 'employees'));
    }

    public function update(AttractionRequest $request, Attraction $attraction): RedirectResponse
    {
        $data = $request->validated();
        $employees = $data['employees'] ?? [];
        unset($data['employees']);

        $attraction->update($data);
        $attraction->employees()->sync($employees);

        return redirect()->route('attractions.index')->with('status', 'Atracción actualizada.');
    }

    public function destroy(Attraction $attraction): RedirectResponse
    {
        $attraction->delete();

        return redirect()->route('attractions.index')->with('status', 'Atracción eliminada.');
    }
}
