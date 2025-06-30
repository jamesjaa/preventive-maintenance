<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
{
    public function groups()
    {
        $groups = Groups::get();
        return view('groups.groups', ['groups' => $groups]);
    }

    public function frmAddGroups(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'groups_name' => 'required|string|max:255',
            'groups_cost' => 'required|numeric',
            'groups_cycle_month' => 'required|numeric|min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $group = new Groups();
        $group->groups_name = $validated['groups_name'];
        $group->groups_cost = $validated['groups_cost'];
        $group->groups_cycle_month = $validated['groups_cycle_month'];
        $group->save();

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmEditGroups(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_groups_id' => 'required|numeric|exists:groups,groups_id',
            'edit_groups_cost' => 'required|numeric',
            'edit_groups_cycle_month' => 'required|numeric|min:1|max:12',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = Groups::where('groups_id', $validated['edit_groups_id'])->update([
            'groups_cost' => $validated['edit_groups_cost'],
            'groups_cycle_month' => $validated['edit_groups_cycle_month'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeleteGroups(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'groups_id' => 'required|numeric|exists:groups,groups_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Groups::find($validated['groups_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
