<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    public function index()
    {
        try {
            $user = User::all();
            if(!$user){
                return new ApiResource(false, "user not found", null);
            }
            return new ApiResource(true, "user payload", $user);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "email" => "required|email|string|unique:users,email",
                "password" => "required|string|min:8",
                "role" => "required|string",
            ]);

            if($request->role !== "STUDENT" && $request->role !== "TEACHER" && $request->role !== "ADMIN"){
                return new ApiResource(false, "invalid role", null);
            }

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
            return new ApiResource(true, "Success to create user!", $user);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::find($id);
            if(!$user){
                return new ApiResource(false, "user not found", null);
            }
            return new ApiResource(true, "user by id payload", $user);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "email" => "required|email|string|unique:users,email",
                "password" => "required|string|min:8",
                "role" => "required|string",
            ]);

            if($request->role !== "STUDENT" && $request->role !== "TEACHER" && $request->role !== "ADMIN"){
                return new ApiResource(false, "invalid role", null);
            }

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $user = User::find($id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
            return new ApiResource(true, "Success to update user!", $user);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $userpayload = User::find($id);
            if(!$userpayload){
                return new ApiResource(false, "user not found", null);
            }
            User::destroy($id);
            return new ApiResource(true, "success to delete user", []);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}