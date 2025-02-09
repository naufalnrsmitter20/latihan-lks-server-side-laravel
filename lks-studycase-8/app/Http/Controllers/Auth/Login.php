<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make(request()->all(), [
                "username" => "string|required",
                "password" => "string|required",
            ]);

            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors(), "data" =>  null], 403);
            }

            $credentials = $request->only("username", "password");
            if (!$token = auth()->guard("api")->attempt($credentials)) {
                return response()->json(["status" => false, "message" => "Invalid login", "data" =>  null], 401);
            }
            $userPayload = auth()->guard("api")->user();
            $customClass = [
                "username" => $userPayload->username,
                "role" => $userPayload->role,
            ];
            $token = JWTAuth::claims($customClass)->attempt($credentials);
            return response()->json(["status" => true, "message" => "login success", ["token" => $token, "role" => $userPayload->role]], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
