<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Logout extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $token = $request->header("Authorization");
            if (!$token) {
                return response()->json([
                    "status" => "forbidden",
                    "message" => "token not provided!",
                ], 403);
            }
            if (auth()->guard("api")->check()) auth()->guard("api")->logout();
            return response()->json([
                "message" => "logout success",
                "user" => auth()->guard("api")->user()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
