<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Register extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "username" => "required|unique:users,username|min:4|max:60",
                "password" => "required|min:5|max:10"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $role = "USER";
            if ($request->username && str_contains($request->username, "admin")) {
                $role = "ADMIN";
            }
            $user = User::create([
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "role" => $role
            ]);
            $token = JWTAuth::fromUser($user);
            Session::put("user_token", $token);
            User::find($user->id)->update(["session_token", $token]);
            return response()->json([
                "status" => "success",
                "token" => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
