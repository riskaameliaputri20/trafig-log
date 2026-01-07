<?php

namespace App\View\Components\Chart;

use App\Services\LogService;
use Closure;
use App\Models\TrafficLog;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ResponSizeChart extends Component
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
        $trafficData = (new LogService())->parseLog();

        $prices = $trafficData->pluck('response_size');
        $dates = $trafficData->pluck('access_time')->map(function ($time) {
            return \Carbon\Carbon::parse($time)->toIso8601String(); // Format ISO utk datetime chart
        });
        return view('components.chart.respon-size-chart', [
            'prices' => $prices,
            'dates' => $dates

        ]);
    }
}
