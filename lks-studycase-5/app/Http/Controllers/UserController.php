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
            return new ApiResource(true, "User Payload", User::all());
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
                "username" => "required|string|unique:users,username",
                "password" => "required|string",
                "role" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $data = User::create([
                "name" => $request->name,
                "username" => $request->username,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
            if (!$data) {
                return new ApiResource(false, "Failed to create user!", null);
            }
            return new ApiResource(true, "Success to create user!", $data);
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
            $find = User::find($id);
            if (!$find) {
                return new ApiResource(false, "User Not Found", null);
            }
            return new ApiResource(true, "User Payload", $find);
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
                "username" => "required|string",
                "password" => "required|string",
                "role" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $find = User::find($id);
            if (!$find) {
                return new ApiResource(false, "User Not Found", null);
            }
            $data = User::find($id)->update([
                "name" => $request->name,
                "username" => $request->username,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
            if (!$data) {
                return new ApiResource(false, "Failed to update user!", null);
            }
            return new ApiResource(true, "Success to update user!", $data);
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
            $find = User::destroy($id);
            if (!$find) {
                return new ApiResource(false, "User Not Found", null);
            }
            return new ApiResource(true, "Success to delete user!", $find);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
