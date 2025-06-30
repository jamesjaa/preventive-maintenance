<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    public function zone()
    {
        $zone = Zone::get();
        return view('zone.zone', ['zone' => $zone]);
    }

    public function frmAddZone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zone_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $Model = new Zone();
        $Model->zone_name = $validated['zone_name'];
        $Model->save();

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmEditZone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_zone_id' => 'required|numeric',
            'edit_zone_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = Zone::where('zone_id', $validated['edit_zone_id'])->update([
            'zone_name' => $validated['edit_zone_name'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeleteZone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zone_id' => 'required|numeric|exists:zone,zone_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Zone::find($validated['zone_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
