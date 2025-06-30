<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Groups;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function brand($groupsId, $typeId)
    {
        $groups = Groups::find($groupsId);
        $type = Type::find($typeId);
        $brand = Brand::where('type_id', $typeId)->get();
        return view('groups.brand', ['groups' => $groups, 'type' => $type, 'brand' => $brand]);
    }

    public function frmAddBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_name' => 'required|string|max:255',
            'type_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $brand = new Brand();
        $brand->brand_name = $validated['brand_name'];
        $brand->type_id = $validated['type_id'];
        $brand->save();

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmEditBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'edit_brand_id' => 'required|numeric',
            'edit_brand_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        $updated = Brand::where('brand_id', $validated['edit_brand_id'])->update([
            'brand_name' => $validated['edit_brand_name'],
        ]);

        return response()->json(['message' => 'บันทึกข้อมูลสำเร็จ'], 200);
    }

    public function frmDeleteBrand(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|numeric|exists:brand,brand_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validated = $validator->validated();

        $delete = Brand::find($validated['brand_id']);
        if (!$delete) {
            return response()->json(['message' => 'ไม่พบข้อมูลที่ต้องการลบ'], 404);
        }
        $delete->delete();

        return response()->json(['message' => 'ลบข้อมูลสำเร็จ'], 200);
    }
}
