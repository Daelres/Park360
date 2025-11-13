<?php

namespace App\Services\Ticketing;

use App\Models\TicketOrder;
use Illuminate\Support\Str;
use RuntimeException;
use SimpleSoftwareIO\QrCode\Generator;

class QrCodeService
{
    public function __construct(private readonly Generator $generator)
    {
    }

    public function ensureForOrder(TicketOrder $order): void
    {
        $shouldSave = false;

        if ($this->shouldRefreshToken($order)) {
            $order->qr_code_token = $this->generateUniqueToken($order->id);
            $shouldSave = true;
        }

        if (! blank($order->qr_code_path)) {
            $order->qr_code_path = null;
            $shouldSave = true;
        }

        if ($shouldSave) {
            $order->save();
        }
    }

    public function svgForOrder(TicketOrder $order): string
    {
        if (blank($order->qr_code_token)) {
            $this->ensureForOrder($order);
        }

        return $this->generator
            ->format('svg')
            ->size(320)
            ->margin(0)
            ->color(45, 27, 105)
            ->backgroundColor(255, 255, 255)
            ->generate($order->qr_code_token);
    }

    private function shouldRefreshToken(TicketOrder $order): bool
    {
        if (blank($order->qr_code_token)) {
            return true;
        }

        return TicketOrder::query()
            ->where('qr_code_token', $order->qr_code_token)
            ->whereKeyNot($order->id)
            ->exists();
    }

    private function generateUniqueToken(?int $ignoreId = null): string
    {
        $attempts = 0;

        do {
            $attempts++;
            $candidate = $this->buildTokenString();
            $exists = TicketOrder::query()
                ->where('qr_code_token', $candidate)
                ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
                ->exists();
        } while ($exists && $attempts < 10);

        if ($exists) {
            throw new RuntimeException('No fue posible generar un token de QR único tras múltiples intentos.');
        }

        return $candidate;
    }

    private function buildTokenString(): string
    {
        $raw = Str::upper(Str::uuid()->toString().Str::random(12));
        $raw = preg_replace('/[^A-Z0-9]/', '', $raw ?? '');

        $segments = str_split(substr($raw, 0, 20), 5);

        return implode('-', $segments);
    }
}
