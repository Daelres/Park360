<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketService
{
    public function generateArtifacts(Ticket $ticket): Ticket
    {
        $qrPath = $this->generateQr($ticket->code);
        $pdfPath = $this->generatePdf($ticket);

        $ticket->update([
            'qr_path' => $qrPath,
            'pdf_path' => $pdfPath,
        ]);

        return $ticket;
    }

    private function generateQr(string $code): string
    {
        $size = 29; // include quiet zone
        $matrix = $this->buildMatrix($code, $size);
        $moduleSize = 8;
        $dimension = $size * $moduleSize;

        $svg = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<svg xmlns="http://www.w3.org/2000/svg" width="' . $dimension . '" height="' . $dimension . '" viewBox="0 0 ' . $dimension . ' ' . $dimension . '">',
            '<rect width="100%" height="100%" fill="#ffffff"/>',
        ];

        foreach ($matrix as $y => $row) {
            foreach ($row as $x => $value) {
                if ($value) {
                    $svg[] = '<rect x="' . ($x * $moduleSize) . '" y="' . ($y * $moduleSize) . '" width="' . $moduleSize . '" height="' . $moduleSize . '" fill="#000000" />';
                }
            }
        }

        $svg[] = '</svg>';
        $svgContent = implode('', $svg);

        $path = 'tickets/qrcodes/' . Str::slug($code) . '.svg';
        Storage::disk('local')->put($path, $svgContent);

        return $path;
    }

    private function buildMatrix(string $code, int $size): array
    {
        $hash = hash('sha256', $code);
        $binary = '';
        foreach (str_split($hash) as $char) {
            $binary .= str_pad(base_convert($char, 16, 2), 4, '0', STR_PAD_LEFT);
        }

        $matrix = [];
        $index = 0;
        for ($y = 0; $y < $size; $y++) {
            $row = [];
            for ($x = 0; $x < $size; $x++) {
                $isQuietZone = $x < 4 || $y < 4 || $x >= $size - 4 || $y >= $size - 4;
                if ($isQuietZone) {
                    $row[] = false;
                    continue;
                }

                $bit = (int) $binary[$index % strlen($binary)];
                $row[] = (bool) $bit;
                $index++;
            }
            $matrix[] = $row;
        }

        $this->embedFinderPatterns($matrix);

        return $matrix;
    }

    private function embedFinderPatterns(array &$matrix): void
    {
        $size = count($matrix);
        $pattern = [
            [1, 1, 1, 1, 1, 1, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 1, 1, 1, 0, 1],
            [1, 0, 0, 0, 0, 0, 1],
            [1, 1, 1, 1, 1, 1, 1],
        ];

        $positions = [[4, 4], [4, $size - 11], [$size - 11, 4]];
        foreach ($positions as [$startY, $startX]) {
            foreach ($pattern as $y => $row) {
                foreach ($row as $x => $value) {
                    $matrix[$startY + $y][$startX + $x] = (bool) $value;
                }
            }
        }
    }

    private function generatePdf(Ticket $ticket): string
    {
        $content = sprintf(
            "BT /F1 24 Tf 100 720 Td (Park360 - Ticket %s) Tj ET\n",
            $ticket->code
        );
        $content .= sprintf("BT /F1 14 Tf 100 680 Td (Tipo: %s) Tj ET\n", optional($ticket->item->ticketType)->name ?? 'N/A');
        $content .= sprintf("BT /F1 14 Tf 100 650 Td (V\303\241lido hasta: %s) Tj ET\n", $ticket->valid_until?->format('Y-m-d H:i'));
        $content .= "BT /F1 12 Tf 100 620 Td (Presenta este comprobante junto al c\303\263digo QR generado.) Tj ET\n";

        $length = strlen($content);
        $objects = [
            '<< /Type /Catalog /Pages 2 0 R >>',
            '<< /Type /Pages /Count 1 /Kids [3 0 R] >>',
            '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 612 792] /Contents 4 0 R /Resources << /Font << /F1 5 0 R >> >> >>',
            "<< /Length {$length} >>\nstream\n{$content}\nendstream",
            '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
        ];

        $pdf = "%PDF-1.4\n";
        $offsets = [0];

        foreach ($objects as $index => $object) {
            $offsets[$index + 1] = strlen($pdf);
            $pdf .= ($index + 1) . " 0 obj\n{$object}\nendobj\n";
        }

        $xrefPosition = strlen($pdf);
        $pdf .= 'xref' . "\n";
        $pdf .= '0 ' . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf('%010d 00000 n ', $offsets[$i]) . "\n";
        }
        $pdf .= 'trailer<< /Size ' . (count($objects) + 1) . ' /Root 1 0 R >>' . "\n";
        $pdf .= 'startxref' . "\n" . $xrefPosition . "\n";
        $pdf .= '%%EOF';

        $path = 'tickets/pdfs/' . Str::slug($ticket->code) . '.pdf';
        Storage::disk('local')->put($path, $pdf);

        return $path;
    }
}
