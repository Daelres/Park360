<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService)
    {
        $this->middleware(['auth', 'role:admin,operator']);
    }

    public function index(Request $request): View
    {
        $sales = $this->reportService->salesSummary($request->get('from'), $request->get('to'));
        $attendance = $this->reportService->attendanceSummary($request->get('date'));
        $attractions = $this->reportService->attractionPerformance($request->get('metrics_date'));

        return view('reports.index', compact('sales', 'attendance', 'attractions'));
    }

    public function exportSales(Request $request)
    {
        $summary = $this->reportService->salesSummary($request->get('from'), $request->get('to'));
        $path = $this->reportService->exportSalesToCsv($summary);

        return Response::download($path)->deleteFileAfterSend(true);
    }

    public function exportAttractions(Request $request)
    {
        $summary = $this->reportService->attractionPerformance($request->get('metrics_date'));
        $path = $this->reportService->exportAttractionsToPdf($summary);

        return Response::download($path)->deleteFileAfterSend(true);
    }
}
