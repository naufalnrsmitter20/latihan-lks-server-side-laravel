<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginAdmin extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        try {
            $validate = Validator::make($request->all(), [
                "username" => "string|required",
                "password" => "string|required",
            ]);

            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()
                ], 403);
            }
            // return response()->json([
            //     "message" => "Login success",
            //     "token" => $credentials,
            // ], 200);

            $credentials = $request->only("username", "password");
            $token = auth()->guard("api")->attempt($credentials);
            if (!$token) {
                return response()->json([
                    "message" => "Username or password incorrect"
                ], 401);
            }
            return response()->json([
                "message" => "Login success",
                "token" => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}