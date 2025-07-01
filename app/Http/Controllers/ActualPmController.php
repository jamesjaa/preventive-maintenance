<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceSchedule;
use App\Http\Controllers\Controller;
use App\Models\EqmLog;
use App\Models\Staff;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class ActualPmController extends Controller
{
    public function ActualPm(Request $request)
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
                'groups.*',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name'
            );
        $query->whereDate('maintenance_schedule.planned_date', '<=', Carbon::today());
        $query->where('status', 1);
        if ($request->filled('year')) {
            $query->whereYear('maintenance_schedule.planned_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('maintenance_schedule.planned_date', $request->month);
        }
        $maintenance = $query->get();

        $staff = Staff::get();

        return view('actual_pm.actual_pm', ['maintenance' => $maintenance, 'staff' => $staff]);
    }

    public function frmAddPM(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'schedule_id' => 'required|integer|exists:maintenance_schedule,pm_id',
            'hw_id' => 'required|integer|exists:equipment,hw_id',
            'cycle_month' => 'required|integer',
            'maintenance_id' => 'required|integer',
            'actual_date' => 'required|date',
            'status' => 'required|in:1,2',
            'detail' => 'nullable|string',
            'cost' => 'nullable|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $schedule = MaintenanceSchedule::find($validated['schedule_id']);
        $schedule->status = 0;
        $schedule->save();

        EqmLog::create([
            'pm_id' => $validated['schedule_id'],
            'hw_id' => $validated['hw_id'],
            'maintenance_id' => $validated['maintenance_id'],
            'created_by' => Session::get('user_id'),
            'actual_date' => $validated['actual_date'],
            'status' => $validated['status'],
            'detail' => $validated['detail'],
            'cost' => $validated['cost'] ?? 0,
        ]);

        MaintenanceSchedule::create([
            'hw_id' => $validated['hw_id'],
            'planned_date' => Carbon::parse($validated['actual_date'])->addMonths((int)$validated['cycle_month']),
            'cycle_month' => $validated['cycle_month'],
            'status' => '1',
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลเรียบร้อย และสร้างแผนใหม่แล้ว']);
    }
}
