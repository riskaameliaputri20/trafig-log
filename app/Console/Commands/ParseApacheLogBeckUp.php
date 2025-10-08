<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\TrafficLog;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class ParseApacheLogBeckUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:parse';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'parse apache log into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = config('log.location');
        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan di: {$filePath}");
            return 1;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $this->info("Membaca " . count($lines) . " baris dari log...");

        $bar = $this->output->createProgressBar(count($lines));
        $bar->start();

        // Daftar ekstensi file aset yang ingin diabaikan
        $extensionsToIgnore = ['.css', '.js', '.png', '.jpg', '.jpeg', '.gif', '.svg', '.woff', '.woff2', '.ico'];

        foreach ($lines as $line) {
            // Regex untuk memecah baris log
            $pattern = '/^(\S+) \S+ \S+ \[([^\]]+)\] "(\S+) (\S+) \S+" (\d{3}) (\d+|-) "(.*?)" "(.*?)"$/';

            if (preg_match($pattern, $line, $matches)) {
                $requestUri = $matches[4];

                // <-- PENYEMPURNAAN: Filter untuk mengabaikan file aset
                if (Str::endsWith($requestUri, $extensionsToIgnore)) {
                    // Jika ini adalah file aset, lewati dan jangan simpan ke database
                    $bar->advance();
                    continue;
                }

                $accessTime = Carbon::createFromFormat('d/M/Y:H:i:s O', $matches[2]);

                // <-- PERBAIKAN PENTING: Mencegah duplikasi data
                // Metode ini akan mencari record dengan kombinasi ip, waktu, dan uri.
                // Jika tidak ditemukan, baru ia akan membuat record baru.
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
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nParsing selesai. Data yang relevan berhasil diimpor ke database.");
        return 0;
    }
}
