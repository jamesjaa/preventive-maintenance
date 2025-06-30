<?php

namespace App\Http\Controllers;

use App\Models\EqmLog;
use App\Models\Equipment;
use Illuminate\Http\Request;

class PmRecordController extends Controller
{
    public function PmRecord($id)
    {
        $equipment = Equipment::query()
            ->leftJoin('groups', 'equipment.groups_id', '=', 'groups.groups_id')
            ->leftJoin('type', 'equipment.type_id', '=', 'type.type_id')
            ->leftJoin('brand', 'equipment.brand_id', '=', 'brand.brand_id')
            ->leftJoin('model', 'equipment.model_id', '=', 'model.model_id')
            ->leftJoin('zone', 'equipment.zone_id', '=', 'zone.zone_id')
            ->select(
                'equipment.*',
                'groups.groups_name',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name'
            )
            ->where('equipment.hw_id', $id)
            ->first();

        $logs = EqmLog::query()
            ->leftJoin('equipment', 'maintenance_log.hw_id', '=', 'equipment.hw_id')
            ->leftJoin('groups', 'equipment.groups_id', '=', 'groups.groups_id')
            ->leftJoin('type', 'equipment.type_id', '=', 'type.type_id')
            ->leftJoin('brand', 'equipment.brand_id', '=', 'brand.brand_id')
            ->leftJoin('model', 'equipment.model_id', '=', 'model.model_id')
            ->leftJoin('zone', 'equipment.zone_id', '=', 'zone.zone_id')
            ->select(
                'maintenance_log.log_id',
                'maintenance_log.actual_date',
                'maintenance_log.status',
                'maintenance_log.detail',
                'maintenance_log.cost',
                'equipment.hw_name',
                'equipment.hw_sn',
                'groups.groups_name',
                'type.type_name',
                'brand.brand_name',
                'model.model_name',
                'zone.zone_name'
            )
            ->orderBy('maintenance_log.actual_date', 'desc')
            ->get();


        return view('equipment.pm-record', ['equipment' => $equipment, 'logs' => $logs]);
    }
}
