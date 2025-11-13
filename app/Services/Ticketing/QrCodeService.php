<?php

namespace App\Services\Ticketing;

use App\Models\TicketOrder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QrCodeService
{
    public function ensureForOrder(TicketOrder $order): void
    {
        if (blank($order->qr_code_token)) {
            $order->qr_code_token = Str::upper(Str::random(12));
        }

        $path = $this->renderPlaceholder($order->qr_code_token, $order->uuid);

        if ($order->qr_code_path !== $path) {
            $order->qr_code_path = $path;
        }

        $order->save();
    }

    private function renderPlaceholder(string $token, string $uuid): string
    {
        $disk = Storage::disk('public');
        $directory = 'qr-codes';

        if (! $disk->exists($directory)) {
            $disk->makeDirectory($directory);
        }

        $filename = $directory.'/'.$uuid.'.svg';

        $pattern = $this->buildPattern($token);

        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="240" height="240" viewBox="0 0 240 260">
    <rect width="240" height="240" fill="#ffffff"/>
    {$pattern}
    <rect y="240" width="240" height="20" fill="#2D1B69"/>
    <text x="120" y="254" font-family="'Courier New', monospace" font-size="12" fill="#ffffff" text-anchor="middle">QR {$token}</text>
</svg>
SVG;

        $disk->put($filename, $svg);

        return $filename;
    }

    private function buildPattern(string $token): string
    {
        $hash = hash('sha256', $token);
        $cells = 21;
        $cellSize = 10;
        $padding = 15;

        $fragments = [];

        for ($y = 0; $y < $cells; $y++) {
            for ($x = 0; $x < $cells; $x++) {
                $index = ($y * $cells + $x) % strlen($hash);
                $value = hexdec($hash[$index]);

                if ($value % 2 === 0) {
                    $posX = $padding + ($x * $cellSize);
                    $posY = $padding + ($y * $cellSize);
                    $fragments[] = sprintf('<rect x="%d" y="%d" width="%d" height="%d" fill="#2D1B69"/>', $posX, $posY, $cellSize, $cellSize);
                }
            }
        }

        return implode('\n    ', $fragments);
    }
}
