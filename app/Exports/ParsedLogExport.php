<?php

namespace App\Exports;

use App\Services\LogService;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ParsedLogExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $service = new LogService();
        return $service->parseLog();
    }

    public function headings(): array
    {
        return [
            'IP Address',
            'Access Time',
            'Request Method',
            'Request URI',
            'Status Code',
            'Response Size',
            'Referrer',
            'User Agent',
        ];
    }
}
