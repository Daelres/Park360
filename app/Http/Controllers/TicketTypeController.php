<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketTypeRequest;
use App\Models\TicketType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TicketTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(): View
    {
        $ticketTypes = TicketType::query()->paginate(10);

        return view('ticket_types.index', compact('ticketTypes'));
    }

    public function create(): View
    {
        return view('ticket_types.create');
    }

    public function store(TicketTypeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);
        TicketType::query()->create($data);

        return redirect()->route('ticket-types.index')->with('status', 'Tipo de ticket creado.');
    }

    public function edit(TicketType $ticketType): View
    {
        return view('ticket_types.edit', compact('ticketType'));
    }

    public function update(TicketTypeRequest $request, TicketType $ticketType): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', false);
        $ticketType->update($data);

        return redirect()->route('ticket-types.index')->with('status', 'Tipo de ticket actualizado.');
    }

    public function destroy(TicketType $ticketType): RedirectResponse
    {
        $ticketType->delete();

        return redirect()->route('ticket-types.index')->with('status', 'Tipo de ticket eliminado.');
    }
}
