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
        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->setSize(14);

        $sheet->getStyle('A1:D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:D1')->getFill()->getStartColor()->setARGB('FFCCE5FF');

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(25);

        $sheet->getStyle('A1:A1048576')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1:D1048576')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->getStyle('A1:D1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    }
}
