<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\TrafficLog;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
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

        // Gunakan disk "local" agar tersimpan di storage/app
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

        $extensionsToIgnore = [
            '.css',
            '.js',
            '.png',
            '.jpg',
            '.jpeg',
            '.gif',
            '.svg',
            '.woff',
            '.woff2',
            '.ico'
        ];

        while (($line = fgets($handle)) !== false) {
            $line = trim($line);
            if ($line === '')
                continue;

            $newLinesCount++;
            $pattern = '/^(\S+) \S+ \S+ \[([^\]]+)\] "(\S+) (\S+) \S+" (\d{3}) (\d+|-) "(.*?)" "(.*?)"$/';

            if (preg_match($pattern, $line, $matches)) {
                $requestUri = strtolower($matches[4]);

                if (Str::endsWith($requestUri, $extensionsToIgnore)) {
                    continue;
                }

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
            }
        }

        $currentPosition = ftell($handle);
        fclose($handle);

        $disk->put($stateFileName, $currentPosition);

        $this->info("Parsing selesai. {$newLinesCount} baris baru diproses. Posisi terakhir disimpan di {$currentPosition}.");
        return 0;
    }
}
