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

    /**
     * Dashboard utama: menampilkan trafik & ancaman
     */
    public function index(Request $request)
    {
        // ✅ Gunakan instance yang di-inject (tidak perlu new)
        $traffics = $this->logService->parseLog();
        $threats = $this->logService->detectThreats();

        // 🔹 Hitung total request
        $trafikCount = $traffics->count();

        // 🔹 Hitung request hari ini
        $trafikCountToday = $traffics->filter(function ($item) {
            return isset($item['access_time']) && $item['access_time']->isToday();
        })->count();

        // 🔹 Kelompokkan berdasarkan status code
        $statusCounts = $traffics
            ->groupBy(fn($item) => $item['status_code'] ?? 0)
            ->map(fn($group) => $group->count())
            ->sortKeys();

        // 🔹 Paginasi trafik
        $perPage = 25;
        $page = (int) $request->get('page', 1);
        $paginatedTraffics = paginateCollection(
            $traffics->sortByDesc('access_time')->values(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // 🔹 Paginasi threats
        $threatsPerPage = 10;
        $threatsPage = (int) $request->get('threats_page', 1);
        $paginatedThreats = paginateCollection(
            $threats,
            $threatsPerPage,
            $threatsPage,
            [
                'path' => $request->url(),
                'query' => array_merge($request->query(), ['tab' => 'threats']),
            ]
        );

        return view('dashboard.index', [
            'traffics' => $paginatedTraffics,
            'trafikCount' => $trafikCount,
            'trafikCountToday' => $trafikCountToday,
            'statusCounts' => $statusCounts,
            'threats' => $paginatedThreats,
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

        return back()->with('success', 'File log custom berhasil dihapus. Sistem kembali ke log default.');
    }
}
