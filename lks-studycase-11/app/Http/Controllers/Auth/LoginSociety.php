<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoginSociety extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "id_card_number" => "string|required",
                "password" => "string|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $findSociety = Society::where("id_card_number", $request->id_card_number)->first();
            if (!$findSociety && $findSociety->password !== md5($request->password)) {
                return response()->json([
                    "message" => "ID Card Number or Password incorrect"
                ], status: 401);
            }
            $token = md5($findSociety->id_card_number . $findSociety->password);
            $updated = Society::find($findSociety->id)->update([
                "login_tokens" => $token
            ]);
            if ($updated) {
                $data = Society::with("regional")->find($findSociety->id);
                return response()->json([
                    "message" => "login success",
                    "data" => $data
                ], status: 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}