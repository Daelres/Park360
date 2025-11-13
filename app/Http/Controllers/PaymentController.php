<?php

namespace App\Http\Controllers;

use App\Models\AddonProduct;
use App\Models\TicketType;
use App\Models\VisitDate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(Request $request): View
    {
        $visitDates = VisitDate::query()
            ->where('is_active', true)
            ->whereDate('visit_date', '>=', now()->toDateString())
            ->orderBy('visit_date')
            ->get();

        $ticketTypes = TicketType::query()->orderBy('base_price')->get();
        $addonProducts = AddonProduct::query()->orderBy('price')->get();

        $ticketCatalog = $ticketTypes
            ->map(fn (TicketType $ticket) => [
                'id' => $ticket->id,
                'name' => $ticket->name,
                'description' => $ticket->description,
                'price' => $ticket->base_price,
            ])->values()->toArray();

        $addonCatalog = $addonProducts
            ->map(fn (AddonProduct $addon) => [
                'id' => $addon->id,
                'name' => $addon->name,
                'description' => $addon->description,
                'price' => $addon->price,
            ])->values()->toArray();

        $selectedVisitDate = null;

        if ($request->filled('date_id')) {
            $selectedVisitDate = $visitDates->firstWhere('id', $request->integer('date_id'));
        }

        if (! $selectedVisitDate && $request->filled('visit_date')) {
            $requestedDate = Carbon::parse($request->string('visit_date'))->toDateString();
            $selectedVisitDate = $visitDates->first(fn (VisitDate $date) => $date->visit_date->toDateString() === $requestedDate);
        }

        if (! $selectedVisitDate && $visitDates->isNotEmpty()) {
            $selectedVisitDate = $visitDates->first();
        }

        $selectedDateId = $selectedVisitDate?->id;
        $selectedDateValue = $selectedVisitDate?->visit_date->toDateString();
        $selectedDateLabel = $selectedVisitDate ? $this->formatDateLabel($selectedVisitDate) : null;

        $datesForView = $visitDates->map(fn (VisitDate $date) => [
            'id' => $date->id,
            'value' => $date->visit_date->toDateString(),
            'label' => $this->formatDateLabel($date),
        ])->values()->toArray();

        return view('payments.create', [
            'visitDates' => $datesForView,
            'selectedDateId' => $selectedDateId,
            'selectedDateValue' => $selectedDateValue,
            'selectedDateLabel' => $selectedDateLabel,
            'ticketTypes' => $ticketTypes,
            'addonProducts' => $addonProducts,
            'ticketCatalog' => $ticketCatalog,
            'addonCatalog' => $addonCatalog,
            'flashSuccess' => session('checkout_success'),
            'flashError' => session('checkout_error'),
        ]);
    }

    public function storeVisitDate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'visit_date.required' => 'Selecciona una fecha válida.',
            'visit_date.date' => 'Selecciona una fecha válida.',
            'visit_date.after_or_equal' => 'La fecha debe ser hoy o posterior.',
        ]);

        $dateValue = Carbon::parse($validated['visit_date'])->startOfDay();

        $visitDate = VisitDate::firstOrCreate(
            ['visit_date' => $dateValue->toDateString()],
            ['is_active' => true]
        );

        return response()->json([
            'id' => $visitDate->id,
            'value' => $visitDate->visit_date->toDateString(),
            'label' => $this->formatDateLabel($visitDate),
        ]);
    }

    private function formatDateLabel(VisitDate $date): string
    {
        return Str::ucfirst($date->visit_date->locale('es')->isoFormat('dddd D [de] MMMM YYYY'));
    }
}
