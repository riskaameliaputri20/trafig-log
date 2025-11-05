<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\TrafficLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ParseApacheLog extends Command
{
    protected $signature = 'log:parse';
    protected $description = 'Parse Apache log into database';

    public function handle()
    {
        $filePath = config('log.location');

        if (!file_exists($filePath)) {
            $this->error("File log tidak ditemukan di: {$filePath}");
            return 1;
        }

        $disk = Storage::disk('local');
        $stateFileName = 'parser_state_' . md5($filePath) . '.txt';
        $lastPosition = 0;

        if ($disk->exists($stateFileName)) {
            $lastPosition = (int) $disk->get($stateFileName);
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            $this->error("Gagal membuka file: {$filePath}");
            return 1;
        }

        fseek($handle, $lastPosition);
        $this->info("Memulai pembacaan dari posisi: {$lastPosition}...");

        $newLinesCount = 0;

        // Abaikan file statis seperti CSS, JS, gambar, dll.
        $ignorePattern = '/\.(css|js|png|jpg|jpeg|gif|svg|woff|woff2|ico|json)(\?.*)?$/i';

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $pattern = '/^(\S+) \S+ \S+ \[([^\]]+)\] "(\S+) (\S+) \S+" (\d{3}) (\d+|-) "(.*?)" "(.*?)"$/';

            if (preg_match($pattern, $line, $matches)) {
                $requestUri = strtolower($matches[4]);
                $parsedUrl = parse_url($requestUri);
                $path = $parsedUrl['path'] ?? $requestUri;

                // ✅ Abaikan file statis
                // if (preg_match($ignorePattern, $path)) {
                //     continue;
                // }

                try {
                    $accessTime = Carbon::createFromFormat('d/M/Y:H:i:s O', $matches[2]);
                } catch (\Exception $e) {
                    $this->warn("Gagal parse waktu: {$matches[2]}");
                    continue;
                }

                TrafficLog::firstOrCreate(
                    [
                        'ip_address' => $matches[1],
                        'access_time' => $accessTime,
                        'request_uri' => $requestUri,
                    ],
                    [
                        'request_method' => $matches[3],
                        'status_code' => $matches[5],
                        'response_size' => $matches[6] === '-' ? 0 : (int) $matches[6],
                        'referrer' => $matches[7] === '-' ? null : $matches[7],
                        'user_agent' => $matches[8],
                    ]
                );

                $newLinesCount++;
            }
        }

        $currentPosition = ftell($handle);
        fclose($handle);

        $disk->put($stateFileName, $currentPosition);

        Log::info('Scheduler dijalankan pada: ' . now('Asia/Makassar'));
        return 0;
    }
}
