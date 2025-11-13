<?php

namespace App\Http\Controllers;

use App\Models\TicketOrder;
use App\Services\Ticketing\QrCodeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QrCodeController extends Controller
{
    public function __construct(private readonly QrCodeService $qrCodeService)
    {
    }

    public function show(Request $request, TicketOrder $order)
    {
        abort_unless($request->user()?->id === $order->user_id, Response::HTTP_FORBIDDEN);

        $svg = $this->qrCodeService->svgForOrder($order);

        $response = response($svg, Response::HTTP_OK, [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-store, private',
        ]);

        $disposition = $request->boolean('download') ? 'attachment' : 'inline';
        $response->header('Content-Disposition', sprintf('%s; filename="qr-%s.svg"', $disposition, $order->uuid));

        return $response;
    }
}
