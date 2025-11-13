<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCompletedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Order $order)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Confirmación de compra Park360')
            ->greeting('Hola ' . $this->order->customer_name)
            ->line('Tu compra ha sido procesada correctamente.')
            ->line('Total pagado: $' . number_format($this->order->total_amount, 0, ',', '.'))
            ->action('Ver orden', route('orders.show', $this->order))
            ->line('Gracias por visitar Park360.');
    }
}
