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
            return new ApiResource(true, "user payload", User::all());
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
                "name" => "required|string",
                "email" => "required|string|email",
                "password" => "required|string",
                "role" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $data = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
            return new ApiResource(true, "user payload", $data);
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
            $data = User::find($id);
            if (!$data) {
                return new ApiResource(false, "user not found", null);
            }
            return new ApiResource(true, "user payload", $data);
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
                "name" => "required|string",
                "email" => "required|string|email",
                "password" => "required|string",
                "role" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $data = User::find($id)->update([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "role" => $request->role,

            ]);
            return new ApiResource(true, "user payload", $data);
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
            $data = User::find($id);
            if (!$data) {
                return new ApiResource(false, "user not found", null);
            }
            User::destroy($id);
            return new ApiResource(true, "Success to delete", null);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
