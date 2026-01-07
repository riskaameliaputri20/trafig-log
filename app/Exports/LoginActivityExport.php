<?php

namespace App\Exports;

use App\Services\LogService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoginActivityExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $service = new LogService();
        $data = $service->analyzeLoginActivity();

        return collect([
            [
                'Total Login Requests' => $data['total_login_requests'],
                'Attempt By IP' => json_encode($data['attempt_by_ip']),
                'Success By IP' => json_encode($data['success_by_ip']),
                'Failed By IP' => json_encode($data['failed_by_ip']),
                'Timeline' => json_encode($data['timeline']),
                'Suspicious' => json_encode($data['suspicious']),
            ]
        ]);
    }

    public function headings(): array
    {
        return [
            'Total Login Requests',
            'Attempt By IP',
            'Success By IP',
            'Failed By IP',
            'Timeline',
            'Suspicious',
        ];
    }
}
