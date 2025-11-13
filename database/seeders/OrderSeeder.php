<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customer = User::query()->where('email', 'cliente@park360.test')->first();
        $ticketTypes = TicketType::query()->get();

        if ($ticketTypes->isEmpty()) {
            return;
        }

        $ticketService = app(TicketService::class);

        $purchaseDate = now()->subDays(2)->startOfDay();

        $order = Order::query()->updateOrCreate(
            ['customer_email' => 'cliente@park360.test', 'purchased_at' => $purchaseDate],
            [
                'user_id' => $customer?->id,
                'customer_name' => 'Cliente Demo',
                'customer_phone' => '+57 300 123 4567',
                'total_amount' => 0,
                'status' => 'paid',
                'payment_method' => 'offline',
                'payment_reference' => Str::uuid(),
                'purchased_at' => $purchaseDate,
            ]
        );

        $total = 0;
        foreach ($ticketTypes as $ticketType) {
            $quantity = rand(1, 3);
            $item = OrderItem::query()->updateOrCreate(
                [
                    'order_id' => $order->id,
                    'ticket_type_id' => $ticketType->id,
                ],
                [
                    'quantity' => $quantity,
                    'unit_price' => $ticketType->price,
                    'subtotal' => $ticketType->price * $quantity,
                ]
            );
            $total += $item->subtotal;

            $existing = $item->tickets()->count();
            $needed = max($quantity - $existing, 0);

            for ($i = 0; $i < $needed; $i++) {
                $ticketService->generateArtifacts(
                    Ticket::query()->create([
                        'order_item_id' => $item->id,
                        'code' => strtoupper(Str::random(10)),
                        'status' => 'valid',
                        'valid_from' => now()->subDay(),
                        'valid_until' => now()->addDay(),
                    ])
                );
            }
        }

        $order->update(['total_amount' => $total]);
    }
}
