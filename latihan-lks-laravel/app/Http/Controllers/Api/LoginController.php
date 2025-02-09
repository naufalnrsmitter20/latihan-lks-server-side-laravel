<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "email" => "email|required",
            "password" => "required"
        ]);

        if($validation->fails()){
            return new ApiResources(401, $validation->errors(), null);
        }

        $credentials = $request->only("email", "password");
        if(!$token = auth()->guard('api')->attempt($credentials)){
            return new ApiResources(403, "Email atau Password Salah", null);
        }
        return new ApiResources(200, "Login Success", [
            "user" => auth()->guard("api")->user(),
            "token" => $token
        ]);
    }
}