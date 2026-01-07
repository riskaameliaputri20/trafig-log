<?php

namespace App\Exports;

use App\Services\LogService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ThreatDetectionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $service = new LogService();
        return $service->detectThreats();
    }

    public function headings(): array
    {
        return [
            'IP Address',
            'Total Requests',
            'Recent Requests',
            'Last Seen',
            'Score',
            'Recommended Action',
            'Details',
        ];
    }
}
