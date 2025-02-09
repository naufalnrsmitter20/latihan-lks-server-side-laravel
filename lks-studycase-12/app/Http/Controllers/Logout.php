<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Http\Request;

class Logout extends Controller
{
    public function logout1(Request $request)
    {
        try {
            if (auth()->guard("api")->check()) auth()->guard("api")->logout();
            return response()->json([
                "message" => "logout success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function logout2(Request $request)
    {
        try {
            $token = $request->get("token");
            $data = Society::where("login_tokens", $token)->first();
            if (!$data) {
                return response()->json([
                    "message" => "Invalid Token!",
                ], 200);
            }
            Society::find($data->id)->update([
                "login_tokens" => null
            ]);
            return response()->json([
                "message" => "logout success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
