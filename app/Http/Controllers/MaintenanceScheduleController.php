<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceScheduleController extends Controller
{
    public function MaintenanceSchedule()
    {
        $maintenance = MaintenanceSchedule::query()
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
            ->get();
        return view('maintenance_schedule.maintenance_schedule', ['maintenance' => $maintenance]);
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
}
