<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "email" => "string|required|unique:users,email",
                "password" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = User::create([
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => "USER",
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
