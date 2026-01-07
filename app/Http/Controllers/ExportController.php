<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParsedLogExport;
use App\Exports\ThreatDetectionExport;
use App\Exports\ErrorLogExport;
use App\Exports\UserBehaviorExport;
use App\Exports\LoginActivityExport;

class ExportController extends Controller
{
    public function exportParsedLog()
    {
        return Excel::download(new ParsedLogExport(), now() . 'parsed_log.xlsx');
    }

    public function exportThreats()
    {
        return Excel::download(new ThreatDetectionExport(), now() . 'threat_detection.xlsx');
    }

    public function exportErrorLogs()
    {
        return Excel::download(new ErrorLogExport(), now() . 'error_logs.xlsx');
    }

    public function exportUserBehavior()
    {
        return Excel::download(new UserBehaviorExport(), now() . 'user_behavior.xlsx');
    }

    public function exportLoginActivity()
    {
        return Excel::download(new LoginActivityExport(), now() . 'login_activity.xlsx');
    }
}
