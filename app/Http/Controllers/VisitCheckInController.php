<?php

namespace App\Http\Controllers;

use App\Models\TicketOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class VisitCheckInController extends Controller
{
    public function create(): View
    {
        return view('visit-scan.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'qr_code_token' => ['required', 'string'],
            'visit_hour' => ['nullable', 'date_format:H:i'],
            'qr_upload' => ['required', 'file', 'mimetypes:image/png,image/jpeg,image/svg+xml,application/pdf', 'max:4096'],
        ]);

        $order = TicketOrder::where('qr_code_token', $validated['qr_code_token'])->first();

        if (! $order) {
            return back()->withInput()->withErrors([
                'qr_code_token' => 'No encontramos una compra asociada a ese código. Verifica e intenta nuevamente.',
            ]);
        }

        $path = $request->file('qr_upload')->store('qr-scans', 'public');

        $visitHour = $validated['visit_hour'] ?? Carbon::now()->format('H:i');

        $order->checkIns()->create([
            'uploaded_qr_path' => $path,
            'visit_hour' => $visitHour,
            'submitted_at' => Carbon::now(),
        ]);

        return redirect()
            ->route('visit-scan.create')
            ->with('status', 'Registro exitoso. ¡Gracias por confirmar tu visita!');
    }
}
