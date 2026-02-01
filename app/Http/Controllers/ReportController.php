<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function daily(Request $request)
    {
        $date = $request->input('date', date('Y-m-d'));
        $report = $this->reportService->getDailyReport($date);

        return view('reports.daily', compact('report', 'date'));
    }
}
