<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = $request->validate([
                "username" => "string|required",
                "password" => "string|required",
            ]);
            $crednetials = $request->only("username", "password");
            if (!$token = auth()->guard("api")->attempt($crednetials)) {
                return response()->json([
                    "status" => 403,
                    "message" => "Invalid username or password",
                ], 403);
            }
            $user = auth()->guard("api")->user();
            $customClass = [
                "username" => $user->username,
                "role" => $user->role
            ];
            $token = JWTAuth::claims($customClass)->attempt($crednetials);
            return response()->json([
                "status" => true,
                "message" => "login sukses",
                "token" => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
