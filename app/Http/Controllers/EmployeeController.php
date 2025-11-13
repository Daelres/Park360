<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Attraction;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(): View
    {
        $employees = Employee::query()->with('attractions')->paginate(10);

        return view('employees.index', compact('employees'));
    }

    public function create(): View
    {
        $attractions = Attraction::query()->pluck('name', 'id');

        return view('employees.create', compact('attractions'));
    }

    public function store(EmployeeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $employee = Employee::query()->create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'position' => $data['position'],
            'hire_date' => $data['hire_date'],
            'status' => $data['status'],
            'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        $employee->document_number = $data['document_number'];
        $employee->save();

        $employee->attractions()->sync($data['attractions'] ?? []);

        return redirect()->route('employees.index')->with('status', 'Empleado creado correctamente.');
    }

    public function show(Employee $employee): View
    {
        $employee->load(['attractions', 'tasks']);

        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee): View
    {
        $employee->load('attractions');
        $attractions = Attraction::query()->pluck('name', 'id');

        return view('employees.edit', compact('employee', 'attractions'));
    }

    public function update(EmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $data = $request->validated();

        $employee->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'position' => $data['position'],
            'hire_date' => $data['hire_date'],
            'status' => $data['status'],
            'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);

        $employee->document_number = $data['document_number'];
        $employee->save();

        $employee->attractions()->sync($data['attractions'] ?? []);

        return redirect()->route('employees.index')->with('status', 'Empleado actualizado.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('employees.index')->with('status', 'Empleado eliminado.');
    }
}
