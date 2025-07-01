<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class MaintenanceScheduleExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        // แปลง collection ให้เป็น array ของ row
        return $this->data->map(function ($item, $key) {
            return [
                $key + 1,
                $item->groups_name,
                $item->type_name,
                $item->hw_sn,
                $item->brand_name,
                $item->model_name,
                $item->hw_name,
                \Carbon\Carbon::parse($item->planned_date)->format('d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            'กลุ่มอุปกรณ์',
            'ชนิด',
            'SN',
            'แบรนด์',
            'โมเดล',
            'ชื่ออุปกรณ์',
            'PM Plan Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ทำหัวตารางหนา
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        // กำหนด background color
        $sheet->getStyle('A1:H1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFE4E4E4');
        // จัดกึ่งกลางทุกคอลัมน์
        $sheet->getStyle('A:H')->getAlignment()->setHorizontal('center');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 15,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 25,
            'H' => 15,
        ];
    }
}
