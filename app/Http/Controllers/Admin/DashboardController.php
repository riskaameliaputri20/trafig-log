<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrafficLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $trafik = TrafficLog::latest()->paginate(10);
        $trafikCount = TrafficLog::count();
        $trafikCountToday = TrafficLog::whereToday('created_at')->count();
        return view('dashboard.index', [
            'traffics' => $trafik,
             'trafikCount' => $trafikCount,
             'trafikCountToday' => $trafikCountToday,

            ]);
    }
}
