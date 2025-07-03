<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login()
    {
        return view('layouts.login');
    }

    public function frmLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $validated = $validator->validated();

        $check = User::where('name', $validated['username'])->first();
        if ($check && Hash::check($validated['password'], $check->password)) {
            Session::put('user_id', $check->id);
            Session::put('user_name', $check->name);
            Session::put('user_fullname', $check->fullname);
            Session::save();
            return response()->json(['message' => "เข้าสู่ระบบสำเร็จ"], 200);
        } else {
            return response()->json(['message' => "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง"], 401);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/');
    }
}
