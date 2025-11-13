<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(private readonly TicketService $ticketService)
    {
    }

    public function createOrder(array $orderData, array $items): Order
    {
        return DB::transaction(function () use ($orderData, $items) {
            $order = Order::query()->create(array_merge($orderData, [
                'payment_reference' => $orderData['payment_reference'] ?? Str::uuid()->toString(),
            ]));
            $total = 0;

            foreach ($items as $itemData) {
                $ticketType = TicketType::query()->findOrFail($itemData['ticket_type_id']);
                $quantity = Arr::get($itemData, 'quantity', 1);
                $unitPrice = $ticketType->price;
                $subtotal = $unitPrice * $quantity;

                $orderItem = OrderItem::query()->create([
                    'order_id' => $order->id,
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;

                for ($i = 0; $i < $quantity; $i++) {
                    $ticket = Ticket::query()->create([
                        'order_item_id' => $orderItem->id,
                        'code' => strtoupper(Str::random(12)),
                        'status' => 'valid',
                        'valid_from' => now(),
                        'valid_until' => now()->addDays($ticketType->validity_days),
                    ]);

                    $this->ticketService->generateArtifacts($ticket);
                }
            }

            $order->update([
                'total_amount' => $total,
                'status' => 'paid',
            ]);

            return $order->load('items.tickets');
        });
    }
}
