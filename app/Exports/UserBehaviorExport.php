<?php

namespace App\Exports;

use App\Services\LogService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserBehaviorExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $service = new LogService();
        return $service->analyzeUserBehavior();
    }

    public function headings(): array
    {
        return [
            'IP Address',
            'Total Requests',
            'Duration Minutes',
            'Average Click Gap (sec)',
            'Behavior Type',
            'First Page',
            'Last Page',
            'Clickstream',
            'First Seen',
            'Last Seen',
        ];
    }
}
