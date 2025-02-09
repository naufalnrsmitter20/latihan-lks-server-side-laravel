<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginUser extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "username" => "string|required",
                "password" => "string|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $checkUser = User::where("username", $request->username)->first();
            if (!$checkUser) {
                return response()->json([
                    "message" => "Invalid username"
                ], 400);
            }
            // if (!password_verify($checkUser->password, $request->password)) {
            //     return response()->json([
            //         "message" => "invalid password",
            //     ], 400);
            // }
            $token = md5($request->username . $request->password);
            return response()->json([
                "message" => "login success",
                "token" => $token,
                "user_id" => $checkUser->id
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
