<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PMReportExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
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
                \Carbon\Carbon::parse($log->planned_date)->format('d/m/Y'),
                \Carbon\Carbon::parse($log->actual_date)->format('d/m/Y'),
                $log->groups_name,
                $log->type_name,
                $log->hw_sn,
                $log->brand_name,
                $log->model_name,
                $log->hw_name,
                number_format($log->cost, 2)
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'PM Plan Date',
            'วันที่ PM อุปกรณ์',
            'กลุ่มอุปกรณ์',
            'ชนิดอุปกรณ์',
            'SN',
            'แบรนด์',
            'โมเดล',
            'ชื่อของอุปกรณ์',
            'ค่าใช้จ่าย'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // หัวตารางหนา + สีพื้น
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE4E4E4');
        // จัดกึ่งกลางทุกคอลัมน์
        $sheet->getStyle('A:J')->getAlignment()->setHorizontal('center');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 15,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 15,
            'H' => 15,
            'I' => 25,
            'J' => 12,
        ];
    }
}
