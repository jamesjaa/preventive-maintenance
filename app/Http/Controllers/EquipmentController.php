<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Groups;
use App\Models\Models;
use App\Models\Type;
use App\Models\Zone;
use App\Models\Equipment;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;

class EquipmentController extends Controller
{
    public function equipment()
    {
        $groups = Groups::get();
        $zone = Zone::get();

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
            ->get();

        return view('equipment.equipment', [
            'groups' => $groups,
            'zone' => $zone,
            'equipment' => $equipment
        ]);
    }

    public function getTypes($groupId)
    {
        $types = Type::where('groups_id', $groupId)->get();
        return response()->json($types);
    }

    public function getBrands($typeId)
    {
        $brands = Brand::where('type_id', $typeId)->get();
        return response()->json($brands);
    }

    public function getModels($brandId)
    {
        $models = Models::where('brand_id', $brandId)->get();
        return response()->json($models);
    }

    public function frmAddEquipment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hw_name' => 'required|string|max:255',
            'hw_sn' => 'required|string|max:255',
            'groups_id' => 'required|integer|exists:groups,groups_id',
            'type_id' => 'required|integer|exists:type,type_id',
            'brand_id' => 'required|integer|exists:brand,brand_id',
            'model_id' => 'required|integer|exists:model,model_id',
            'zone_id' => 'required|integer|exists:zone,zone_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        try {
            $equipment = new Equipment();
            $equipment->hw_name = $validated['hw_name'];
            $equipment->hw_sn = $validated['hw_sn'];
            $equipment->groups_id = $validated['groups_id'];
            $equipment->type_id = $validated['type_id'];
            $equipment->brand_id = $validated['brand_id'];
            $equipment->model_id = $validated['model_id'];
            $equipment->zone_id = $validated['zone_id'];
            $equipment->created_at = Session::get('user_id');
            $equipment->hw_created_date = now();
            $equipment->save();

            $group = Groups::find($validated['groups_id']);
            if (!$group) {
                return response()->json(['message' => 'ไม่พบข้อมูลกลุ่มอุปกรณ์'], 404);
            }

            $schedule = new MaintenanceSchedule();
            $schedule->hw_id = $equipment->hw_id;
            $schedule->cycle_month = $group->groups_cycle_month;
            $schedule->planned_date = now()->addMonths($group->groups_cycle_month);
            $schedule->save();

            return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                return response()->json([
                    'message' => 'หมายเลขซีเรียลนี้มีอยู่แล้วในระบบ'
                ], 400);
            }

            return response()->json([
                'message' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาดไม่ทราบสาเหตุ'
            ], 500);
        }
    }

    public function frmDeleteHW(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hw_id' => 'required|numeric|exists:equipment,hw_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Equipment::find($validated['hw_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
