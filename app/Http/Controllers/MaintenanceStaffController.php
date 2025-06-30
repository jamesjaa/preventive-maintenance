<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MaintenanceStaffController extends Controller
{
    public function maintenance_staff()
    {
        $staff = Staff::get();
        return view('maintenance_staff.maintenance_staff', ['staff' => $staff]);
    }

    public function frmAddMaintenanceStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maintenance_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $Model = new Staff();
        $Model->maintenance_name = $validated['maintenance_name'];
        $Model->save();

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmEditMaintenanceStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_staff_id' => 'required|numeric',
            'edit_staff_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = Staff::where('maintenance_id', $validated['edit_staff_id'])->update([
            'maintenance_name' => $validated['edit_staff_name'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeleteMaintenanceStaff(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'maintenance_id' => 'required|numeric|exists:maintenance_staff,maintenance_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Staff::find($validated['maintenance_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
