<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Services\NotificationService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(private readonly OrderService $orderService, private readonly NotificationService $notificationService)
    {
        $this->middleware(['auth']);
    }

    public function index(): View
    {
        $query = Order::query()->with('items.ticketType')->latest();

        if (Auth::user()?->hasRole('customer')) {
            $query->where('user_id', Auth::id());
        }

        $orders = $query->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create(): View
    {
        $ticketTypes = TicketType::query()->where('is_active', true)->get();

        return view('orders.create', compact('ticketTypes'));
    }

    public function store(OrderRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $order = $this->orderService->createOrder([
            'user_id' => Auth::id(),
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
            'total_amount' => 0,
            'status' => 'pending',
            'payment_method' => 'offline',
            'payment_reference' => null,
            'purchased_at' => now(),
        ], $data['items']);

        $this->notificationService->notifyOrder($order);

        return redirect()->route('orders.show', $order)->with('status', 'Compra registrada correctamente.');
    }

    public function show(Order $order): View
    {
        if (Auth::user()?->hasRole('customer') && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.tickets');

        return view('orders.show', compact('order'));
    }

    public function downloadTicketPdf(Order $order, Ticket $ticket)
    {
        if (Auth::user()?->hasRole('customer') && $order->user_id !== Auth::id()) {
            abort(403);
        }

        abort_unless($ticket->item->order_id === $order->id, 404);

        if (! $ticket->pdf_path || ! Storage::disk('local')->exists($ticket->pdf_path)) {
            return redirect()->route('orders.show', $order)->with('status', 'El comprobante aún no está disponible.');
        }

        $path = Storage::disk('local')->path($ticket->pdf_path);

        return Response::download($path, 'ticket-' . $ticket->code . '.pdf');
    }

    public function downloadTicketQr(Order $order, Ticket $ticket)
    {
        if (Auth::user()?->hasRole('customer') && $order->user_id !== Auth::id()) {
            abort(403);
        }

        abort_unless($ticket->item->order_id === $order->id, 404);

        if (! $ticket->qr_path || ! Storage::disk('local')->exists($ticket->qr_path)) {
            return redirect()->route('orders.show', $order)->with('status', 'El código QR aún no está disponible.');
        }

        $path = Storage::disk('local')->path($ticket->qr_path);

        return Response::download($path, 'ticket-' . $ticket->code . '.svg');
    }
}
