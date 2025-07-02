<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EquipmentPMHistoryExport implements FromCollection, WithHeadings, WithStyles
{
    protected $logs;

    public function __construct($logs)
    {
        $this->logs = $logs;
    }

    public function collection()
    {
        return $this->logs->map(function ($log, $index) {
            return [
                $index + 1,
                \Carbon\Carbon::parse($log->actual_date)->format('d/m/Y'),
                $log->status == 1 ? 'ดำเนินการเรียบร้อย' : 'ไม่สามารถซ่อมได้',
                $log->maintenance_name
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'วันที่ PM อุปกรณ์',
            'สถานะ',
            'ผู้ดำเนินการ',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);
    }
}
