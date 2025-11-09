<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(Request $request): View
    {
        $preselectedPlan = $request->string('plan')->toString();

        return view('payments.create', [
            'plan' => $preselectedPlan,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'email', 'max:255'],
            'plan' => ['required', 'string', 'max:255'],
            'monto' => ['required', 'numeric', 'min:0'],
            'metodo_pago' => ['required', 'string', 'max:255'],
        ]);

        // La integración con PayU se implementará en el futuro.
        // Por ahora, se deja registro en el log para facilitar la futura implementación.
        logger()->info('Solicitud de pago pendiente de enviar a PayU', $validated);

        return redirect()
            ->route('payments.create')
            ->with('status', 'Solicitud registrada. En breve serás redirigido a PayU para completar el pago.');
    }
}
