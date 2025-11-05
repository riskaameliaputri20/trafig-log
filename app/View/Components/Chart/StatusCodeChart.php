<?php

namespace App\View\Components\Chart;

use Closure;
use App\Models\TrafficLog;
use App\Services\LogService;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class StatusCodeChart extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $logService = new LogService();

        // Ambil koleksi log dari file
        $logs = $logService->parseLog();

        // Hitung jumlah berdasarkan status_code
        $statusCounts = $logs
            ->groupBy('status_code')        // Kelompokkan berdasarkan status_code
            ->map(fn($group) => $group->count())  // Hitung jumlah tiap status_code
            ->sortKeys();

        return view('components.chart.status-code-chart', [
            'statusCounts' => $statusCounts
        ]);

    }
}
