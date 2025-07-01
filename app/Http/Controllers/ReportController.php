<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EqmLog;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PMReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;

class ReportController extends Controller
{
    public function report(Request $request)
    {
        $query = EqmLog::query()
            ->leftJoin('maintenance_schedule', 'maintenance_log.pm_id', '=', 'maintenance_schedule.pm_id')
            ->leftJoin('equipment', 'maintenance_log.hw_id', '=', 'equipment.hw_id')
            ->leftJoin('groups', 'equipment.groups_id', '=', 'groups.groups_id')
            ->leftJoin('type', 'equipment.type_id', '=', 'type.type_id')
            ->leftJoin('brand', 'equipment.brand_id', '=', 'brand.brand_id')
            ->leftJoin('model', 'equipment.model_id', '=', 'model.model_id')
            ->leftJoin('zone', 'equipment.zone_id', '=', 'zone.zone_id')
            ->leftJoin('users', 'maintenance_log.created_by', '=', 'users.id')
            ->select(
                'maintenance_log.*',
                'equipment.hw_sn',
                'equipment.hw_name',
                'groups.groups_name',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name',
                'users.name as created_by_name',
                'maintenance_schedule.planned_date',
                'maintenance_log.actual_date'
            );
        $query->where('maintenance_log.status', '<=', 2);

        if ($request->filled('year')) {
            $query->whereYear('maintenance_log.actual_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('maintenance_log.actual_date', $request->month);
        }

        $logs = $query->orderBy('maintenance_log.actual_date', 'asc')->get();

        return view('report.report', [
            'logs' => $logs,
            'selectedYear' => $request->year,
            'selectedMonth' => $request->month,
        ]);
    }

    public function exportExcel(Request $request)
    {
        $logs = $this->getFilteredLogs($request);
        return Excel::download(new PMReportExport($logs), 'pm_report.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $logs = $this->getFilteredLogs($request);
        $html = view('export.report_pdf', compact('logs'))->render();

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font' => 'thsarabun',
            'fontDir' => array_merge((new \Mpdf\Config\ConfigVariables())->getDefaults()['fontDir'], [
                storage_path('fonts'),
            ]),
            'fontdata' => array_merge((new \Mpdf\Config\FontVariables())->getDefaults()['fontdata'], [
                'thsarabun' => [
                    'R' => 'thsarabunnew.ttf',
                    'B' => 'thsarabunnew_bold.ttf',
                ]
            ]),
        ]);

        $mpdf->WriteHTML($html);
        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="report.pdf"');
    }


    // ดึงข้อมูลตามเงื่อนไขปี/เดือน
    private function getFilteredLogs($request)
    {
        $query = EqmLog::query()
            ->leftJoin('maintenance_schedule', 'maintenance_log.pm_id', '=', 'maintenance_schedule.pm_id')
            ->leftJoin('equipment', 'maintenance_log.hw_id', '=', 'equipment.hw_id')
            ->leftJoin('groups', 'equipment.groups_id', '=', 'groups.groups_id')
            ->leftJoin('type', 'equipment.type_id', '=', 'type.type_id')
            ->leftJoin('brand', 'equipment.brand_id', '=', 'brand.brand_id')
            ->leftJoin('model', 'equipment.model_id', '=', 'model.model_id')
            ->leftJoin('zone', 'equipment.zone_id', '=', 'zone.zone_id')
            ->leftJoin('users', 'maintenance_log.created_by', '=', 'users.id')
            ->select(
                'maintenance_log.*',
                'equipment.hw_sn',
                'equipment.hw_name',
                'groups.groups_name',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name',
                'users.name as created_by_name',
                'maintenance_schedule.planned_date',
                'maintenance_log.actual_date'
            );
        $query->where('maintenance_log.status', '<=', 2);

        if ($request->filled('year')) {
            $query->whereYear('maintenance_log.actual_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('maintenance_log.actual_date', $request->month);
        }

        return $query->get();
    }
}
