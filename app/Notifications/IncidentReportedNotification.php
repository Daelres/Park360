<?php

namespace App\Notifications;

use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IncidentReportedNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Incident $incident)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Incidente reportado en ' . $this->incident->attraction?->name)
            ->line('Se ha registrado un nuevo incidente con severidad: ' . $this->incident->severity)
            ->line('Descripción: ' . $this->incident->description)
            ->line('Estado actual: ' . $this->incident->status)
            ->action('Revisar incidente', route('incidents.edit', $this->incident))
            ->line('Por favor ingresa al sistema para gestionar la situación.');
    }
}
