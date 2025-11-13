<?php

namespace App\Services;

use App\Models\AttractionMetric;
use App\Models\EmployeeAttendance;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ReportService
{
    public function salesSummary(?string $from = null, ?string $to = null): array
    {
        $query = Order::query()->with('items');
        if ($from) {
            $query->whereDate('purchased_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('purchased_at', '<=', $to);
        }

        $orders = $query->get();
        $total = $orders->sum('total_amount');
        $tickets = $orders->flatMap(fn ($order) => $order->items)->sum('quantity');

        return [
            'total_amount' => $total,
            'tickets_sold' => $tickets,
            'orders' => $orders,
        ];
    }

    public function attendanceSummary(?string $date = null): array
    {
        $date = $date ?? now()->toDateString();
        $records = EmployeeAttendance::query()
            ->with('employee')
            ->whereDate('date', $date)
            ->get();

        $present = $records->where('status', 'present')->count();
        $absent = $records->where('status', 'absent')->count();

        return [
            'date' => $date,
            'present' => $present,
            'absent' => $absent,
            'records' => $records,
        ];
    }

    public function attractionPerformance(?string $date = null): array
    {
        $date = $date ?? now()->subDay()->toDateString();
        $metrics = AttractionMetric::query()
            ->with('attraction')
            ->whereDate('date', $date)
            ->get();

        return [
            'date' => $date,
            'metrics' => $metrics,
            'average_satisfaction' => $metrics->avg('satisfaction_score'),
        ];
    }

    public function exportSalesToCsv(array $summary): string
    {
        $rows = [
            ['Fecha', 'Cliente', 'Estado', 'Total'],
        ];

        foreach ($summary['orders'] as $order) {
            $rows[] = [
                $order->purchased_at?->format('Y-m-d'),
                $order->customer_name,
                $order->status,
                number_format($order->total_amount, 2, ',', '.'),
            ];
        }

        $rows[] = ['', 'Total vendido', '', number_format($summary['total_amount'], 2, ',', '.')];

        $csvLines = array_map(fn ($row) => implode(';', $row), $rows);
        $content = implode("\n", $csvLines);
        $path = 'reports/sales-' . Str::uuid() . '.csv';
        Storage::disk('local')->put($path, $content);

        return Storage::path($path);
    }

    public function exportAttractionsToPdf(array $summary): string
    {
        $content = "BT /F1 18 Tf 80 760 Td (Reporte de atracciones " . $summary['date'] . ") Tj ET\n";
        $offsetY = 720;
        foreach ($summary['metrics'] as $metric) {
            $line = sprintf(
                'BT /F1 12 Tf 80 %d Td (%s - Visitantes: %d, Incidentes: %d, Satisfacción: %.2f) Tj ET\n',
                $offsetY,
                $metric->attraction?->name,
                $metric->visitors_count,
                $metric->incidents_count,
                $metric->satisfaction_score
            );
            $content .= $line;
            $offsetY -= 24;
        }

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
        $pdf .= "xref\n";
        $pdf .= '0 ' . (count($objects) + 1) . "\n";
        $pdf .= "0000000000 65535 f \n";
        for ($i = 1; $i <= count($objects); $i++) {
            $pdf .= sprintf('%010d 00000 n ', $offsets[$i]) . "\n";
        }
        $pdf .= 'trailer<< /Size ' . (count($objects) + 1) . ' /Root 1 0 R >>' . "\n";
        $pdf .= 'startxref' . "\n" . $xrefPosition . "\n";
        $pdf .= '%%EOF';

        $path = 'reports/attractions-' . Str::uuid() . '.pdf';
        Storage::disk('local')->put($path, $pdf);

        return Storage::path($path);
    }
}
