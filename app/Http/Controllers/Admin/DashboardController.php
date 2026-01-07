<?php

namespace App\Http\Controllers\Admin;

use App\Services\LogService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function index(Request $request)
    {
        $traffics = $this->logService->parseLog();
        $threats = $this->logService->detectThreats();

        // 1. Persiapan Data Area Chart (Response Size)
        // Ambil 50 data terbaru untuk performa
        $recentTraffics = $traffics->sortBy('access_time')->take(-50);
        $prices = $recentTraffics->pluck('response_size')->toArray();
        $dates = $recentTraffics
            ->pluck('access_time')
            ->map(fn($d) => $d->toIso8601String())
            ->toArray();

        // 2. Persiapan Data Donut Chart (Status Code)
        $statusCounts = $traffics->groupBy('status_code')->map->count()->sortKeys();

        // 3. Paginasi Data (Pastikan logic ini tetap ada)
        $perPage = 25;
        $paginatedTraffics = paginateCollection(
            $traffics->sortByDesc('access_time')->values(),
            $perPage,
            (int) $request->get('page', 1),
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ],
        );
        $paginatedThreats = paginateCollection(
            $threats,
            10,
            (int) $request->get('threats_page', 1),
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ],
        );

        return view('dashboard.index', [
            'traffics' => $paginatedTraffics,
            'threats' => $paginatedThreats,
            'prices' => $prices,
            'dates' => $dates,
            'statusCounts' => $statusCounts,
            'trafikCount' => $traffics->count(),
            'trafikCountToday' => $traffics
                ->filter(fn($i) => $i['access_time']->isToday())
                ->count(),
        ]);
    }

    /**
     * Analisis perilaku pengguna (user behavior)
     */
    public function userBehavior()
    {
        $userBehavior = $this->logService->analyzeUserBehavior();
        return view('dashboard.user-behavior', compact('userBehavior'));
    }

    /**
     * Analisis error log (4xx dan 5xx)
     */
    public function analyzeErrorLogs()
    {
        $data = $this->logService->analyzeErrorLogs();

        return view('dashboard.error-logs', [
            'errorData' => $data,
        ]);
    }

    /**
     * Upload file log custom
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'customLogFile' => 'required|file|mimes:log,txt,csv,json|max:2048',
        ]);

        $file = $request->file('customLogFile');
        $path = $file->store('custom-logs');

        // Simpan path ke session agar sistem tahu log custom digunakan
        Session::put('custom_log_path', $path);

        // Hapus cache lama supaya detectThreats() memproses ulang
        Cache::forget('detected_threats_custom');
        Cache::forget('detected_threats_default');

        return back()->with('success', 'File log berhasil diupload dan siap diproses.');
    }

    /**
     * Hapus file log custom & reset ke log default
     */
    public function removeFile()
    {
        $path = Session::get('custom_log_path');

        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }

        Session::forget('custom_log_path');
        // Bersihkan cache
        Cache::forget('detected_threats_custom');
        Cache::forget('detected_threats_default');

        return back()->with(
            'success',
            'File log custom berhasil dihapus. Sistem kembali ke log default.',
        );
    }

    // login activity
    public function loginActivity(Request $request)
    {
        $data = $this->logService->analyzeLoginActivity();

        // 🔹 Pagination untuk raw login logs
        $perPage = 30;
        $page = (int) $request->get('page', 1);

        $paginatedRaw = paginateCollection(
            $data['raw']->sortByDesc('access_time')->values(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ],
        );

        return view('dashboard.login-activity', [
            'summary' => $data,
            'raw' => $paginatedRaw,
        ]);
    }
    public function analyzeServerPerformance()
    {
        /* ============================================================
     |                     CPU USAGE
     |      Linux  → sys_getloadavg()
     |      Windows → PowerShell Get-Counter
    ============================================================ */
        if (PHP_OS_FAMILY === 'Windows') {
            $cpuOutput = shell_exec(
                'powershell -command "(Get-Counter \'\\Processor(_Total)\\% Processor Time\').CounterSamples.CookedValue"',
            );

            $cpuUsage = is_numeric(trim($cpuOutput)) ? round((float) $cpuOutput, 2) : null;
        } else {
            $load = function_exists('sys_getloadavg') ? sys_getloadavg() : null;
            $cpuUsage = $load ? $load[0] : null;
        }

        /* ============================================================
     |                     MEMORY USAGE (RAM)
     |   Linux → /proc/meminfo
     |   Windows → wmic OS get FreePhysicalMemory,TotalVisibleMemorySize
    ============================================================ */
        $memoryTotal = null;
        $memoryFree = null;

        if (PHP_OS_FAMILY !== 'Windows') {
            // LINUX
            $memInfo = file_get_contents('/proc/meminfo');
            preg_match('/MemTotal:\s+(\d+)/', $memInfo, $totalMatch);
            preg_match('/MemAvailable:\s+(\d+)/', $memInfo, $availableMatch);

            $memoryTotal = round($totalMatch[1] / 1024, 2); // MB
            $memoryFree = round($availableMatch[1] / 1024, 2); // MB
        } else {
            // WINDOWS (pakai PowerShell)
            $psCommand =
                'powershell -command "Get-CimInstance Win32_OperatingSystem | Select-Object FreePhysicalMemory,TotalVisibleMemorySize | ConvertTo-Json"';

            $output = shell_exec($psCommand);
            $data = json_decode($output, true);

            if ($data) {
                $memoryTotal = round($data['TotalVisibleMemorySize'] / 1024, 2); // MB
                $memoryFree = round($data['FreePhysicalMemory'] / 1024, 2); // MB
            }
        }

        /* ============================================================
     |                     DISK USAGE
     |   Windows → C:\
     |   Linux → /
    ============================================================ */
        $diskPath = PHP_OS_FAMILY === 'Windows' ? 'C:' : '/';

        $diskTotal = round(disk_total_space($diskPath) / 1073741824, 2); // GB
        $diskFree = round(disk_free_space($diskPath) / 1073741824, 2); // GB
        $diskUsed = $diskTotal - $diskFree;

        /* ============================================================
     |            PHP CONFIG (Memory Limit / Execution Time)
    ============================================================ */
        $phpMemoryLimit = ini_get('memory_limit');
        $maxExecution = ini_get('max_execution_time');

        /* ============================================================
     |                 DATABASE RESPONSE TIME
    ============================================================ */
        $start = microtime(true);
        \Illuminate\Support\Facades\DB::select('SELECT 1');
        $dbResponse = round((microtime(true) - $start) * 1000, 2); // ms

        /* ============================================================
     |                      RETURN VIEW
    ============================================================ */
        return view('dashboard.server-performance', [
            'cpuUsage' => $cpuUsage,
            'memoryTotal' => $memoryTotal,
            'memoryFree' => $memoryFree,
            'diskTotal' => $diskTotal,
            'diskUsed' => $diskUsed,
            'diskFree' => $diskFree,
            'phpMemoryLimit' => $phpMemoryLimit,
            'maxExecution' => $maxExecution,
            'dbResponse' => $dbResponse,
        ]);
    }
    public function popularEndpoints()
    {
        $entries = $this->logService->parseLog(); // sudah kamu punya sebelumnya

        // Hitung jumlah hit per endpoint (request URL)
        $endpointStats = $entries
            ->groupBy('request_uri')
            ->map(function ($items, $url) {
                return [
                    'url' => $url,
                    'hit_count' => $items->count(),
                ];
            })
            ->sortByDesc('hit_count')
            ->values()
            ->take(10); // ambil 10 endpoint paling populer

        return view('dashboard.popular-endpoints', compact('endpointStats'));
    }
}
