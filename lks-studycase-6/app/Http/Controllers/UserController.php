<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;

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
            $data = User::create([
                "username" => $request->username,
                "password" => $request->password,
                "role" => $request->role
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to create user", null);
            }
            return new ApiResource(true, "success to create user", $data);
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
            $user = User::find($id);
            if (!$user) {
                return new ApiResource(false, "user not found", null);
            }
            $data = User::find($id)->update([
                "username" => $request->username,
                "password" => $request->password,
                "role" => $request->role
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to update user", null);
            }
            return new ApiResource(true, "success to update user", $data);
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
            $user = User::find($id);
            if (!$user) {
                return new ApiResource(false, "user not found", null);
            }
            $data = User::destroy($id);
            return new ApiResource(true, "success to delete user", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
