<?php

namespace App\View\Components\Chart;

use Closure;
use App\Models\TrafficLog;
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
        // Hitung jumlah berdasarkan status_code
        $statusCounts = TrafficLog::select('status_code')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('status_code')
            ->pluck('total', 'status_code')
            ->sortKeys();

        return view('components.chart.status-code-chart', [
            'statusCounts' => $statusCounts
        ]);

    }
}
