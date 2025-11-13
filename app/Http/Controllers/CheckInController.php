<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckInRequest;
use App\Models\Ticket;
use App\Models\TicketScan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckInController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function create(): View
    {
        return view('checkin.scan');
    }

    public function store(CheckInRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $ticket = Ticket::query()->where('code', strtoupper($data['code']))->first();

        if (! $ticket || $ticket->status !== 'valid' || $ticket->valid_until->isPast()) {
            return back()->withErrors(['code' => 'El boleto no es válido o ya fue utilizado.']);
        }

        $ticket->update([
            'status' => 'used',
            'checked_in_at' => now(),
        ]);

        TicketScan::query()->create([
            'ticket_id' => $ticket->id,
            'scanned_by' => $request->user()->id,
            'scanned_at' => now(),
            'location' => $data['location'] ?? null,
            'device' => $data['device'] ?? null,
        ]);

        return redirect()->route('check-in.create')->with('status', 'Check-in realizado correctamente.');
    }
}
