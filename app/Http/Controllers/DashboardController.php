<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(private readonly ReportService $reportService)
    {
    }

    public function __invoke(): View
    {
        $sales = $this->reportService->salesSummary(now()->subWeek()->toDateString(), now()->toDateString());
        $attendance = $this->reportService->attendanceSummary(now()->toDateString());
        $attractions = $this->reportService->attractionPerformance();

        return view('dashboard', [
            'user' => Auth::user(),
            'sales' => $sales,
            'attendance' => $attendance,
            'attractions' => $attractions,
        ]);
    }
}
