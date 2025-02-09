<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Society;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class Login extends Controller
{
    public function login1(Request $request) {}
    public function login2(Request $request)
    {
        try {
            $data = Society::with("regional")->where("id_card_number", $request->id_card_number)->first();
            if (!$data || $data->password !== md5($request->password)) {
                return response()->json([
                    "message" => "Id card number or password inccorrect"
                ], 401);
            }
            Society::find($data->id)->update([
                "login_tokens" => md5($data->id_card_number . $data->password)
            ]);
            return response()->json(Society::with("regional")->where("id_card_number", $request->id_card_number)->first(), 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
