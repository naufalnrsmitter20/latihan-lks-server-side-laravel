<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|string",
                "password" => "required|string|min:8",
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $credentials = $request->only(["email", "password"]);
            if(!$token = auth()->guard("api")->attempt($credentials)){
                return new ApiResource(false, "Invalid email or password", null);
            }
            return new ApiResource(true, "Login Success", $token);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}