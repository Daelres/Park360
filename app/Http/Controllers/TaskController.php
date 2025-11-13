<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Attraction;
use App\Models\Employee;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(): View
    {
        $tasks = Task::query()->with(['attraction', 'assignments'])->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View
    {
        $attractions = Attraction::query()->pluck('name', 'id');
        $employees = Employee::query()->get()->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])->toArray();

        return view('tasks.create', compact('attractions', 'employees'));
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $employees = $data['employees'] ?? [];
        unset($data['employees']);

        $task = Task::query()->create($data);
        $task->assignments()->sync($employees);

        return redirect()->route('tasks.index')->with('status', 'Tarea creada.');
    }

    public function edit(Task $task): View
    {
        $task->load('assignments');
        $attractions = Attraction::query()->pluck('name', 'id');
        $employees = Employee::query()->get()->mapWithKeys(fn ($employee) => [$employee->id => $employee->full_name])->toArray();

        return view('tasks.edit', compact('task', 'attractions', 'employees'));
    }

    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $data = $request->validated();
        $employees = $data['employees'] ?? [];
        unset($data['employees']);

        $task->update($data);
        $task->assignments()->sync($employees);

        return redirect()->route('tasks.index')->with('status', 'Tarea actualizada.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('status', 'Tarea eliminada.');
    }
}
