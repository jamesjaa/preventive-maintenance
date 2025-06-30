<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceSchedule;
use App\Models\EqmLog;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function index()
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
                'groups.*',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name'
            )
            ->whereDate('maintenance_schedule.planned_date', '<=', Carbon::today())
            ->where('status', 1)
            ->get();

        $query = EqmLog::query();
        $totalCost = $query->sum('cost');

        return view('layouts.dashboard', ['maintenance' => $maintenance, 'totalCost' => $totalCost]);
    }
}
