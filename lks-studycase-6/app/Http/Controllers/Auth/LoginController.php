<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $credentials = $request->only(["username", "password"]);
            if (!$token = auth()->guard("api")->attempt($credentials)) {
                return new ApiResource(false, "Invalid username or password", null);
            }
            return new ApiResource(true, "Login success", ["token" => $token]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
