<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "username" => "required|unique:users,username",
                "password" => "required|min:8|confirmed"
            ]);
            if($validation->fails()){
                return new ApiResources(403, $validation->errors(), null);
            }
            $user = User::create([
                "name" => $request->name,
                "username" => $request->username,
                "email" => $request->email,
                "password" => bcrypt($request->password),
            ]);
            $duplicate_email_validation = User::where("email", $request->email)->exists();
            if($duplicate_email_validation){
                return new ApiResources(401, "Duplicate Email", null);
            }
            if(!$user){
                return new ApiResources(400, "Failed to Register", null);
            }
            return new ApiResources(200, "Success to Register", $user);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "status" => 500,
                    "message" => $e->getMessage()
                ],
                500
            );
        }
    }
}