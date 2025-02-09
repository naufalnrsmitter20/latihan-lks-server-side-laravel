<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
           $user = User::all();
           if(!$user){
            return new ApiResource(false, "User not found", null);
        }
        return new ApiResource(true, "User Payload", $user);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required",
                "role" => "required"
            ]);

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         try {
            $user = User::find($id);
            if(!$user){
                return new ApiResource(false, "User not found", null);
            }
                return new ApiResource(true, "User by id Payload", $user);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         try {
            $validator = Validator::make($request->all(), [
                "name" => "required",
                "email" => "required|email|unique:users,email",
                "password" => "required",
                "role" => "required"
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            
            $checkIdUser = User::find($id);
            
            if(!$checkIdUser){
                return new ApiResource(false, "User not found, please check valid id user!", null);
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
            $checkIdUser = User::find($id);
            
            if(!$checkIdUser){
                return new ApiResource(false, "User not found, please check valid id user!", null);
            }
            $user = User::destroy($id);
            if(!$user){
                return new ApiResource(false, "Failed to delete user", null);
            }
                return new ApiResource(true, "success to delete user!", []);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}