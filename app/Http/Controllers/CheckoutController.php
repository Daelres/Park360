<?php

namespace App\Http\Controllers;

use App\Models\AddonProduct;
use App\Models\TicketOrder;
use App\Models\TicketOrderItem;
use App\Models\TicketType;
use App\Models\VisitDate;
use App\Services\Ticketing\QrCodeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use Symfony\Component\HttpFoundation\Response;

class CheckoutController extends Controller
{
    public function __construct(private readonly QrCodeService $qrCodeService)
    {
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'visit_date_id' => ['required', 'exists:visit_dates,id'],
            'tickets' => ['required', 'array'],
            'tickets.*.id' => ['required', 'exists:ticket_types,id'],
            'tickets.*.quantity' => ['required', 'integer', 'min:1'],
            'addons' => ['nullable', 'array'],
            'addons.*.id' => ['required', 'exists:addon_products,id'],
            'addons.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $ticketsPayload = collect($validated['tickets'])
            ->filter(fn ($item) => ($item['quantity'] ?? 0) > 0);

        if ($ticketsPayload->isEmpty()) {
            return response()->json([
                'message' => 'Debes seleccionar al menos una entrada.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $addonsPayload = collect($validated['addons'] ?? [])
            ->filter(fn ($item) => ($item['quantity'] ?? 0) > 0);

        $visitDate = VisitDate::findOrFail($validated['visit_date_id']);
        $user = $request->user();
        $customerId = $user->createOrGetStripeCustomer();

    $ticketTypes = TicketType::whereIn('id', $ticketsPayload->pluck('id'))->get()->keyBy('id');
    $addonProducts = AddonProduct::whereIn('id', $addonsPayload->pluck('id'))->get()->keyBy('id');

        $lineItems = [];
        $orderTotal = 0;

        $order = null;

        DB::beginTransaction();

        try {
            $order = TicketOrder::create([
                'user_id' => $user->id,
                'visit_date_id' => $visitDate->id,
                'status' => TicketOrder::STATUS_PENDING,
            ]);

            foreach ($ticketsPayload as $ticketInput) {
                $ticket = $ticketTypes->get($ticketInput['id']);

                if (! $ticket) {
                    continue;
                }

                $quantity = (int) $ticketInput['quantity'];

                TicketOrderItem::create([
                    'ticket_order_id' => $order->id,
                    'item_type' => 'ticket',
                    'item_id' => $ticket->id,
                    'name' => $ticket->name,
                    'quantity' => $quantity,
                    'unit_amount' => $ticket->base_price,
                    'is_primary' => true,
                ]);

                $lineItems[] = [
                    'quantity' => $quantity,
                    'price_data' => [
                        'currency' => 'cop',
                        'unit_amount' => $ticket->base_price,
                        'product' => $ticket->stripe_product_id,
                    ],
                ];

                $orderTotal += $ticket->base_price * $quantity;
            }

            foreach ($addonsPayload as $addonInput) {
                $addon = $addonProducts->get($addonInput['id']);

                if (! $addon) {
                    continue;
                }

                $quantity = (int) $addonInput['quantity'];

                TicketOrderItem::create([
                    'ticket_order_id' => $order->id,
                    'item_type' => 'addon',
                    'item_id' => $addon->id,
                    'name' => $addon->name,
                    'quantity' => $quantity,
                    'unit_amount' => $addon->price,
                    'is_primary' => false,
                ]);

                $lineItems[] = [
                    'quantity' => $quantity,
                    'price_data' => [
                        'currency' => 'cop',
                        'unit_amount' => $addon->price,
                        'product' => $addon->stripe_product_id,
                    ],
                ];

                $orderTotal += $addon->price * $quantity;
            }

            $order->update(['total_amount' => $orderTotal]);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();
            report($exception);

            return response()->json([
                'message' => 'No fue posible preparar la orden.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if (empty($lineItems)) {
            $order->delete();

            return response()->json([
                'message' => 'Debes seleccionar al menos una entrada válida.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $session = Cashier::stripe()->checkout->sessions->create([
                'customer' => $customerId,
                'mode' => 'payment',
                'ui_mode' => 'embedded',
                'locale' => 'es-419',
                'return_url' => route('checkout.success', ['order' => $order->uuid], true).'?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => [
                    'order_uuid' => $order->uuid,
                    'visit_date' => $visitDate->visit_date->toDateString(),
                ],
                'line_items' => $lineItems,
            ]);

            $order->update([
                'stripe_session_id' => $session->id,
                'stripe_client_secret' => $session->client_secret,
            ]);
        } catch (\Throwable $exception) {
            report($exception);
            $order->delete();

            return response()->json([
                'message' => 'No fue posible iniciar el pago. Intenta nuevamente en unos minutos.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return response()->json([
            'redirect_url' => route('checkout.show', ['order' => $order->uuid]),
        ]);
    }

    public function show(Request $request): View|RedirectResponse
    {
        $orderUuid = $request->query('order');

        /** @var TicketOrder $order */
        $order = TicketOrder::query()
            ->with(['items', 'visitDate'])
            ->where('uuid', $orderUuid)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        if ($order->status === TicketOrder::STATUS_PAID) {
            return redirect()->route('checkout.success', ['order' => $order->uuid]);
        }

        if (blank($order->stripe_client_secret) && filled($order->stripe_session_id)) {
            try {
                $session = Cashier::stripe()->checkout->sessions->retrieve($order->stripe_session_id);
                $order->update(['stripe_client_secret' => $session->client_secret]);
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        $stripePublicKey = config('services.stripe.key');

        abort_if(blank($stripePublicKey), Response::HTTP_INTERNAL_SERVER_ERROR, 'Stripe no está configurado.');

        return view('payments.checkout', [
            'order' => $order,
            'stripePublicKey' => $stripePublicKey,
            'clientSecret' => $order->stripe_client_secret,
        ]);
    }

    public function success(Request $request, TicketOrder $order): View|RedirectResponse
    {
        abort_unless($order->user_id === $request->user()->id, Response::HTTP_FORBIDDEN);

        $sessionId = $request->string('session_id')->toString() ?: $order->stripe_session_id;

        if (blank($sessionId)) {
            return redirect()->route('payments.create')->with('checkout_error', 'No se encontró la sesión de pago.');
        }

        try {
            $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId, [
                'expand' => ['payment_intent', 'line_items', 'line_items.data.price.product'],
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return redirect()->route('payments.create')->with('checkout_error', 'No fue posible consultar el estado del pago.');
        }

        if (($session->status ?? null) !== 'complete' || ($session->payment_status ?? null) !== 'paid') {
            $order->update([
                'status' => TicketOrder::STATUS_FAILED,
                'failed_at' => Carbon::now(),
            ]);

            return redirect()->route('payments.create')->with('checkout_error', 'El pago no se completó correctamente.');
        }

        $paymentIntentId = is_object($session->payment_intent) ? $session->payment_intent->id : $session->payment_intent;

        $order->update([
            'status' => TicketOrder::STATUS_PAID,
            'paid_at' => Carbon::now(),
            'stripe_payment_intent_id' => $paymentIntentId,
        ]);

        $this->qrCodeService->ensureForOrder($order->refresh()->load('items', 'visitDate'));

        return view('payments.success', [
            'order' => $order->load('items', 'visitDate'),
            'session' => $session,
        ]);
    }

    public function failure(): RedirectResponse
    {
        return redirect()->route('payments.create')->with('checkout_error', 'Tu pago no pudo completarse. Intenta nuevamente.');
    }
}
