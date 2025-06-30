<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSchedule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActualPmController extends Controller
{
    public function ActualPm()
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
            ->whereDate('maintenance_schedule.planned_date', '<=', Carbon::today())
            ->where('status', 1)
            ->paginate(10);
        return view('actual_pm.actual_pm', ['maintenance' => $maintenance]);
    }

    public function frmAddPM(Request $request)
    {
        // $schedule = MaintenanceSchedule::find($request->schedule_id);
        // $schedule->status = 'completed';
        // $schedule->actual_date = $request->actual_date;
        // $schedule->save();

        // // สร้างแผนใหม่ถ้าต้องการ
        // MaintenanceSchedule::create([
        //     'equipment_id' => $schedule->equipment_id,
        //     'planned_date' => Carbon::parse($request->actual_date)->addMonths(6),
        //     'status' => 'pending',
        //     // ...อื่นๆ
        // ]);

        // return response()->json(['message' => 'บันทึกและสร้างแผนใหม่แล้ว']);
    }
}
