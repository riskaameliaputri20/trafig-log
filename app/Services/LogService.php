<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class LogService
{
    /**
     * Parse log file menjadi collection terstruktur
     * dan cache hasilnya agar tidak membaca ulang file besar.
     */
    public function parseLog(): Collection
    {
        // 🔹 Cek apakah ada custom log di session
        $customLogPath = Session::get('custom_log_path');

        if ($customLogPath && Storage::exists($customLogPath)) {
            $filePath = Storage::path($customLogPath);
        } else {
            $filePath = config('log.location');
        }

        // --- Pastikan file ada ---
        if (!file_exists($filePath)) {
            return collect();
        }

        // --- Cache Key ---
        $cacheKey = 'parsed_log_' . md5($filePath);
        $lastModified = filemtime($filePath);
        $cacheVersionKey = $cacheKey . '_version';

        if (Cache::get($cacheVersionKey) !== $lastModified) {
            Cache::forget($cacheKey);
        }

        // Cache parsing selama 5 menit
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($filePath, $cacheVersionKey, $lastModified) {
            $handle = fopen($filePath, 'r');
            if (!$handle) {
                return collect();
            }

            $parsedEntries = collect();

            while (($line = fgets($handle)) !== false) {
                $line = trim($line);
                if ($line === '') continue;

                // --- Format 1: Apache Combined Log ---
                $patternCombined = '/^(\S+) \S+ \S+ \[([^\]]+)\] "(\S+) ([^"]+?) \S+" (\d{3}) (\d+|-) "(.*?)" "(.*?)"$/';

                // --- Format 2: Common Log (tanpa referrer & UA) ---
                $patternCommon = '/^(\S+) \S+ \S+ \[([^\]]+)\] "(\S+) ([^"]+?) \S+" (\d{3}) (\d+|-)$/';

                $matches = [];
                if (preg_match($patternCombined, $line, $matches)) {
                    // ✅ Combined log
                    $ip = $matches[1];
                    $time = $matches[2];
                    $method = $matches[3];
                    $uri = $matches[4];
                    $status = (int)$matches[5];
                    $size = $matches[6] === '-' ? 0 : (int)$matches[6];
                    $referrer = $matches[7] === '-' ? null : $matches[7];
                    $ua = $matches[8] ?? null;
                } elseif (preg_match($patternCommon, $line, $matches)) {
                    // ✅ Common log
                    $ip = $matches[1];
                    $time = $matches[2];
                    $method = $matches[3];
                    $uri = $matches[4];
                    $status = (int)$matches[5];
                    $size = $matches[6] === '-' ? 0 : (int)$matches[6];
                    $referrer = null;
                    $ua = null;
                } else {
                    continue;
                }

                try {
                    $accessTime = Carbon::createFromFormat('d/M/Y:H:i:s O', $time);
                } catch (\Exception $e) {
                    continue;
                }

                $parsedEntries->push([
                    'ip_address' => $ip,
                    'access_time' => $accessTime,
                    'request_method' => $method,
                    'request_uri' => $uri,
                    'status_code' => $status,
                    'response_size' => $size,
                    'referrer' => $referrer,
                    'user_agent' => $ua,
                ]);
            }

            fclose($handle);
            Cache::put($cacheVersionKey, $lastModified, now()->addMinutes(5));

            return $parsedEntries;
        });
    }

    /**
     * Deteksi ancaman berdasarkan entri log.
     */
    public function detectThreats(): Collection
    {
        $cacheKey = 'detected_threats_' . (Session::get('using_custom_log') ? 'custom' : 'default');
        $entries = $this->parseLog();

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($entries) {
            if ($entries->isEmpty()) {
                return collect();
            }

            // --- Konfigurasi threshold ---
            $RECENT_WINDOW_MINUTES = 5;
            $BRUTE_FORCE_RECENT_REQ = 20;
            $TOTAL_404_UNIQUE = 30;
            $SQLI_THRESHOLD = 3;
            $XSS_THRESHOLD = 2;
            $SUSPICIOUS_UA_THRESHOLD = 1;
            $SCORE_ACTION_BLOCK = 10;

            $now = Carbon::now();

            $byIp = $entries->groupBy('ip_address');

            return $byIp->map(function ($group, $ip) use (
                $now,
                $RECENT_WINDOW_MINUTES,
                $BRUTE_FORCE_RECENT_REQ,
                $TOTAL_404_UNIQUE,
                $SQLI_THRESHOLD,
                $XSS_THRESHOLD,
                $SUSPICIOUS_UA_THRESHOLD,
                $SCORE_ACTION_BLOCK
            ) {
                $group = $group->map(function ($e) {
                    $e['request_uri'] = $e['request_uri'] ?? '';
                    $e['user_agent'] = $e['user_agent'] ?? '';
                    if (!($e['access_time'] instanceof Carbon)) {
                        $e['access_time'] = Carbon::parse($e['access_time']);
                    }
                    $e['request_uri_normal'] = strtolower($e['request_uri']);
                    $e['user_agent_normal'] = strtolower($e['user_agent']);
                    return $e;
                });

                $lastSeen = $group->max('access_time');
                $totalRequests = $group->count();

                $recentFrom = $now->copy()->subMinutes($RECENT_WINDOW_MINUTES);
                $recentRequests = $group->filter(fn($e) => $e['access_time']->greaterThanOrEqualTo($recentFrom));
                $recentCount = $recentRequests->count();

                // --- Brute Force ---
                $bruteForceTotal = $group->filter(
                    fn($e) =>
                    str_contains($e['request_uri_normal'], 'login') ||
                        str_contains($e['request_uri_normal'], '/admin')
                )->count();

                $isBruteForce = $bruteForceTotal >= $BRUTE_FORCE_RECENT_REQ;

                // --- Scanning (404 banyak) ---
                $paths404 = $group->where('status_code', 404)->pluck('request_uri')->map(fn($p) => parse_url($p, PHP_URL_PATH));
                $unique404 = $paths404->unique()->filter()->count();
                $isScanning = $unique404 >= $TOTAL_404_UNIQUE;

                // --- SQL Injection ---
                $sqliPattern = "/(\%27|\\'|\\-\\-|\\%3D|\\b(select|union|insert|update|delete|drop|sleep|benchmark)\\b|\\bor\\b\\s*\\d+=\\d+)/i";
                $sqliCount = $group->filter(fn($e) => preg_match($sqliPattern, $e['request_uri']))->count();
                $isSqlInjection = $sqliCount >= $SQLI_THRESHOLD;

                // --- XSS ---
                $xssPattern = "/(<script\b|%3cscript%3e|javascript:|onerror=|onload=)/i";
                $xssCount = $group->filter(fn($e) => preg_match($xssPattern, $e['request_uri']))->count();
                $isXss = $xssCount >= $XSS_THRESHOLD;

                // --- Suspicious UA ---
                $uaPattern = "/(sqlmap|nmap|nikto|acunetix|nessus|fuzzer|curl|wget|python-requests|httpclient)/i";
                $uaCount = $group->filter(fn($e) => preg_match($uaPattern, $e['user_agent']))->count();

                // --- Skor ---
                $score = 0;
                $score += intval($isBruteForce) * 5;
                $score += intval($isScanning) * 4;
                $score += intval($isSqlInjection) * 4 + $sqliCount;
                $score += intval($isXss) * 3 + $xssCount;
                $score += intval($uaCount) * 2;

                $recommendedAction = 'monitor';
                if ($score >= $SCORE_ACTION_BLOCK) {
                    $recommendedAction = 'block';
                } elseif ($score >= ($SCORE_ACTION_BLOCK / 2)) {
                    $recommendedAction = 'rate-limit / captcha';
                }

                return [
                    'ip_address' => $ip,
                    'total_requests' => $totalRequests,
                    'recent_requests' => $recentCount,
                    'last_seen' => $lastSeen,
                    'score' => round($score, 2),
                    'recommended_action' => $recommendedAction,
                    'details' => collect([
                        $isBruteForce ? ['type' => 'Brute Force', 'count' => $bruteForceTotal, 'recent' => $group->last()['request_uri'] ?? '-'] : null,
                        $isScanning ? ['type' => 'Scanning (404 Flood)', 'count' => $unique404, 'recent' => $paths404->last() ?? '-'] : null,
                        $isSqlInjection ? ['type' => 'SQL Injection', 'count' => $sqliCount, 'recent' => $group->where(fn($e) => preg_match($sqliPattern, $e['request_uri']))->last()['request_uri'] ?? '-'] : null,
                        $isXss ? ['type' => 'XSS Attack', 'count' => $xssCount, 'recent' => $group->where(fn($e) => preg_match($xssPattern, $e['request_uri']))->last()['request_uri'] ?? '-'] : null,
                        $uaCount > 0 ? ['type' => 'Suspicious User Agent', 'count' => $uaCount, 'recent' => $group->last()['user_agent'] ?? '-'] : null,
                    ])->filter()->values()->toArray(),
                ];
            })->filter(fn($r) => $r['score'] > 0)->sortByDesc('score')->values();
        });
    }

    /**
     * Analisis error (4xx, 5xx)
     */
    public function analyzeErrorLogs(): Collection
    {
        $entries = $this->parseLog();
        $cacheKey = 'error_analysis_' . (Session::get('using_custom_log') ? 'custom' : 'default');

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($entries) {
            if ($entries->isEmpty()) {
                return collect([
                    'total_errors' => 0,
                    'errors_by_code' => [],
                    'top_urls' => [],
                    'top_ips' => [],
                    'errors_over_time' => [],
                ]);
            }

            $errorEntries = $entries->filter(fn($e) => $e['status_code'] >= 400 && $e['status_code'] < 600);

            if ($errorEntries->isEmpty()) {
                return collect([
                    'total_errors' => 0,
                    'errors_by_code' => [],
                    'top_urls' => [],
                    'top_ips' => [],
                    'errors_over_time' => [],
                ]);
            }

            return collect([
                'total_errors' => $errorEntries->count(),
                'errors_by_code' => $errorEntries->groupBy('status_code')->map->count()->sortDesc(),
                'top_urls' => $errorEntries->groupBy('request_uri')->map->count()->sortDesc()->take(10),
                'top_ips' => $errorEntries->groupBy('ip_address')->map->count()->sortDesc()->take(10),
                'errors_over_time' => $errorEntries->groupBy(fn($e) => $e['access_time']->format('Y-m-d H:00'))->map->count()->sortKeys(),
            ]);
        });
    }
    /**
     * 🔍 Analisis perilaku pengguna berdasarkan log
     * Mengelompokkan aktivitas per IP dan menghitung frekuensi, halaman populer, dan waktu akses terakhir.
     */
    public function analyzeUserBehavior(): \Illuminate\Support\Collection
    {
        $logs = $this->parseLog();

        if ($logs->isEmpty()) {
            return collect();
        }

        // Kelompokkan berdasarkan IP Address
        $grouped = $logs->groupBy('ip_address');

        return $grouped->map(function ($entries, $ip) {
            $totalRequests = $entries->count();
            $sortedByTime = $entries->sortBy('access_time')->values();

            $firstSeen = $sortedByTime->first()['access_time'];
            $lastSeen = $sortedByTime->last()['access_time'];

            // Durasi aktif dalam menit
            $durationMinutes = $firstSeen->diffInMinutes($lastSeen);

            // Rata-rata jarak antar klik (detik)
            $avgClickGap = 0;
            if ($totalRequests > 1) {
                $gaps = [];
                for ($i = 1; $i < $sortedByTime->count(); $i++) {
                    $prev = $sortedByTime[$i - 1]['access_time'];
                    $curr = $sortedByTime[$i]['access_time'];
                    $gaps[] = $prev->diffInSeconds($curr);
                }
                $avgClickGap = round(collect($gaps)->avg(), 2);
            }

            // Halaman pertama dan terakhir
            $firstPage = $sortedByTime->first()['request_uri'] ?? '-';
            $lastPage = $sortedByTime->last()['request_uri'] ?? '-';

            // Clickstream gabungan
            $clickstream = $sortedByTime->pluck('request_uri')->implode(' → ');

            // Tentukan tipe perilaku
            $behaviorType = 'normal user';
            if ($totalRequests > 500 || $avgClickGap < 2) {
                $behaviorType = 'possible bot / crawler';
            } elseif ($totalRequests > 100) {
                $behaviorType = 'high activity user';
            }

            return [
                'ip_address' => $ip,
                'total_requests' => $totalRequests,
                'duration_minutes' => $durationMinutes,
                'avg_click_gap_sec' => $avgClickGap,
                'behavior_type' => $behaviorType,
                'first_page' => $firstPage,
                'last_page' => $lastPage,
                'clickstream' => $clickstream,
                'first_seen' => $firstSeen,
                'last_seen' => $lastSeen,
            ];
        })->sortByDesc('total_requests')->values();
    }
}
