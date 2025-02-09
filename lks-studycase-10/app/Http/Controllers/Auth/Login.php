<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Pest\Arch\Support\UserDefinedFunctions;
use Tymon\JWTAuth\Facades\JWTAuth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "email" => "string|required",
                "password" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $userPayload = User::where("email", $request->email)->first();
            $credentials = $request->only("email", "password");
            if (!$token = auth()->guard("api")->attempt($credentials)) {
                return response()->json([
                    "message" => "Invalid credentials"
                ], 401);
            }
            $token = JWTAuth::claims([
                "userData" => $userPayload
            ])->attempt($credentials);
            return response()->json([
                "message" => "login success",
                "token" => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}