<?php

namespace App\Services;

use App\Models\Incident;
use App\Models\NotificationLog;
use App\Models\Order;
use App\Notifications\IncidentReportedNotification;
use App\Notifications\OrderCompletedNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    public function notifyOrder(Order $order): void
    {
        Notification::route('mail', $order->customer_email)
            ->notify(new OrderCompletedNotification($order));

        NotificationLog::query()->create([
            'type' => OrderCompletedNotification::class,
            'recipient' => $order->customer_email,
            'channel' => 'mail',
            'payload' => ['order_id' => $order->id, 'total' => $order->total_amount],
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function notifyIncident(Incident $incident): void
    {
        $recipients = $incident->attraction?->employees?->pluck('email')->filter()->all() ?? [];
        if (empty($recipients)) {
            return;
        }

        Notification::route('mail', $recipients)
            ->notify(new IncidentReportedNotification($incident));

        foreach ($recipients as $email) {
            NotificationLog::query()->create([
                'type' => IncidentReportedNotification::class,
                'recipient' => $email,
                'channel' => 'mail',
                'payload' => ['incident_id' => $incident->id],
                'status' => 'sent',
                'sent_at' => now(),
            ]);
        }
    }
}
