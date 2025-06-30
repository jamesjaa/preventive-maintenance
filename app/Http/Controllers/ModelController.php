<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Groups;
use App\Models\Models;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModelController extends Controller
{
    public function model($groupsId, $typeId, $brandId)
    {
        $groups = Groups::find($groupsId);
        $type = Type::find($typeId);
        $brand = Brand::find($brandId);
        $models = Models::where('brand_id', $brandId)->get();
        return view(
            'groups.model',
            [
                'groups' => $groups,
                'brand' => $brand,
                'type' => $type,
                'models' => $models
            ]
        );
    }

    public function frmAddModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model_name' => 'required|string|max:255',
            'brand_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $Model = new Models();
        $Model->model_name = $validated['model_name'];
        $Model->brand_id = $validated['brand_id'];
        $Model->save();

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmEditModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_model_id' => 'required|numeric',
            'edit_model_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = Models::where('model_id', $validated['edit_model_id'])->update([
            'model_name' => $validated['edit_model_name'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeleteModel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'model_id' => 'required|numeric|exists:model,model_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Models::find($validated['model_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
