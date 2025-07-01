<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSchedule;
use App\Exports\MaintenanceScheduleExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;

class MaintenanceScheduleController extends Controller
{
    public function MaintenanceSchedule(Request $request)
    {
        $query = MaintenanceSchedule::query()
            ->leftJoin('equipment', 'maintenance_schedule.hw_id', '=', 'equipment.hw_id')
            ->leftJoin('groups', 'equipment.groups_id', '=', 'groups.groups_id')
            ->leftJoin('type', 'equipment.type_id', '=', 'type.type_id')
            ->leftJoin('brand', 'equipment.brand_id', '=', 'brand.brand_id')
            ->leftJoin('model', 'equipment.model_id', '=', 'model.model_id')
            ->leftJoin('zone', 'equipment.zone_id', '=', 'zone.zone_id')
            ->select(
                'maintenance_schedule.*',
                'equipment.hw_sn',
                'equipment.hw_name',
                'groups.groups_name',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name'
            );
        if ($request->filled('year')) {
            $query->whereYear('maintenance_schedule.planned_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('maintenance_schedule.planned_date', $request->month);
        }
        $query->where('status', '>=', 1);
        $maintenance = $query->get();
        return view('maintenance_schedule.maintenance_schedule', ['maintenance' => $maintenance]);
    }

    public function frmEditDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pm_id' => 'required|numeric',
            'edit_date' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = MaintenanceSchedule::where('pm_id', $validated['pm_id'])->update([
            'planned_date' => $validated['edit_date'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeletePM(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pm_id' => 'required|numeric|exists:maintenance_schedule,pm_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = MaintenanceSchedule::find($validated['pm_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }

    private function getFilteredSchedules(Request $request)
    {
        $query = MaintenanceSchedule::query()
            ->leftJoin('equipment', 'maintenance_schedule.hw_id', '=', 'equipment.hw_id')
            ->leftJoin('groups', 'equipment.groups_id', '=', 'groups.groups_id')
            ->leftJoin('type', 'equipment.type_id', '=', 'type.type_id')
            ->leftJoin('brand', 'equipment.brand_id', '=', 'brand.brand_id')
            ->leftJoin('model', 'equipment.model_id', '=', 'model.model_id')
            ->leftJoin('zone', 'equipment.zone_id', '=', 'zone.zone_id')
            ->select(
                'maintenance_schedule.*',
                'equipment.hw_sn',
                'equipment.hw_name',
                'groups.groups_name',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name'
            )
            ->where('status', '>=', 1);

        if ($request->filled('year')) {
            $query->whereYear('maintenance_schedule.planned_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('maintenance_schedule.planned_date', $request->month);
        }

        return $query->get();
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getFilteredSchedules($request);
        return Excel::download(new MaintenanceScheduleExport($data), 'maintenance_schedule.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getFilteredSchedules($request);
        $html = view('export.maintenance_schedule_pdf', compact('data'))->render();

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
            ->header('Content-Disposition', 'inline; filename="maintenance_schedule.pdf"');
    }
}
