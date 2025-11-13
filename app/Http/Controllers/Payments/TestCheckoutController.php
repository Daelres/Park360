<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Cashier\Cashier;
use Symfony\Component\HttpFoundation\Response;

class TestCheckoutController extends Controller
{
    private const TEST_AMOUNT = 50000; // COP, currency without decimal places

    public function show(Request $request): View
    {
        $publicKey = config('services.stripe.key');

        abort_if(blank($publicKey), Response::HTTP_INTERNAL_SERVER_ERROR, 'Stripe no está configurado.');

        return view('payments.test', [
            'stripePublicKey' => $publicKey,
            'formattedAmount' => number_format(self::TEST_AMOUNT, 0, ',', '.'),
        ]);
    }

    public function createSession(Request $request): JsonResponse
    {
        $request->validate([
            'cantidad' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $user = $request->user();
        $customerId = $user->createOrGetStripeCustomer();

        $quantity = (int) ($request->input('cantidad', 1));
        $unitAmount = self::TEST_AMOUNT;

        try {
            $session = Cashier::stripe()->checkout->sessions->create([
                'customer' => $customerId,
                'mode' => 'payment',
                'locale' => 'es-419',
                'ui_mode' => 'embedded',
                'return_url' => route('payments.test.return', [], false).'?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => [
                    'origen' => 'prueba_interna',
                    'usuario' => $user->email,
                ],
                'line_items' => [[
                    'quantity' => $quantity,
                    'price_data' => [
                        'currency' => 'cop',
                        'unit_amount' => $unitAmount,
                        'product_data' => [
                            'name' => 'Entrada de prueba Park360',
                            'description' => 'Flujo de integración con Stripe Checkout embebido',
                        ],
                    ],
                ]],
            ]);

            return response()->json([
                'clientSecret' => $session->client_secret,
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'No fue posible crear la sesión de pago. Inténtalo nuevamente.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function handleReturn(Request $request): View
    {
        $sessionId = $request->string('session_id')->trim();

        abort_if($sessionId->isEmpty(), Response::HTTP_BAD_REQUEST, 'Identificador de sesión faltante.');

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId->toString(), [
            'expand' => ['payment_intent'],
        ]);

        $paymentIntent = $session->payment_intent ?? null;

        if (is_string($paymentIntent)) {
            $paymentIntent = null;
        }

        return view('payments.test-return', [
            'session' => $session,
            'paymentIntent' => $paymentIntent,
        ]);
    }
}
