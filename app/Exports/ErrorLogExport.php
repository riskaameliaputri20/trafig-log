<?php

namespace App\Exports;

use App\Services\LogService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ErrorLogExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $service = new LogService();
        $data = $service->analyzeErrorLogs();

        // Normalisasi ke bentuk baris (Excel tidak menerima nested arrays)
        return collect([
            [
                'Total Errors' => $data['total_errors'],
                'Error Codes' => json_encode($data['errors_by_code']),
                'Top URLs' => json_encode($data['top_urls']),
                'Top IPs' => json_encode($data['top_ips']),
                'Errors Over Time' => json_encode($data['errors_over_time']),
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Total Errors',
            'Error Codes',
            'Top URLs',
            'Top IPs',
            'Errors Over Time',
        ];
    }
}
