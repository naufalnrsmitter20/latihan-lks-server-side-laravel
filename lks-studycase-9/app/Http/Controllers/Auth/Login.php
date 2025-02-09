<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "username" => "required|min:4|max:60",
                "password" => "required|min:5|max:10"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }


            $credentials = $request->only("username", "password");
            if (!$token = auth()->guard("api")->attempt($credentials)) {
                return response()->json([
                    "status" => "invalid",
                    "message" => "Wrong username or password"
                ], 401);
            }
            $user = auth()->guard("api")->user();
            $token = JWTAuth::claims([
                "username" => $user->username,
                "role" => $user->role
            ])->attempt($credentials);
            $sessionToken = Session::get("user_token");
            return response()->json([
                "status" => "success",
                "token" => $token,
                // "sessionToken" => $sessionToken
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
