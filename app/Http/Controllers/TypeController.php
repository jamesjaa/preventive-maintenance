<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Groups;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
{
    public function type($groupsId)
    {
        $groups = Groups::find($groupsId);
        $type = Type::where('groups_id', $groupsId)->get();
        return view('groups.type', ['groups' => $groups, 'type' => $type]);
    }

    public function frmAddType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_name' => 'required|string|max:255',
            'groups_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $type = new Type();
        $type->type_name = $validated['type_name'];
        $type->groups_id = $validated['groups_id'];
        $type->save();

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmEditType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_type_id' => 'required|numeric',
            'edit_type_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = Type::where('type_id', $validated['edit_type_id'])->update([
            'type_name' => $validated['edit_type_name'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeleteType(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type_id' => 'required|numeric|exists:type,type_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Type::find($validated['type_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
