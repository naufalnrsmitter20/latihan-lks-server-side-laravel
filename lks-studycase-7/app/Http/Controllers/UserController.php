<?php

namespace App\Http\Controllers;

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
            return response()->json([
                "status" => true,
                "data" => User::all()
            ], 200);
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
            $validated = Validator::make($request->all(), [
                "username" => "string|required|unique:users,username",
                "role" => "string|required",
                "password" => "string|required",
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors()->first(),
                ], 403);
            }

            $data = User::create([
                "username" => $request->username,
                "password" => bcrypt($request->password),
                "role" => $request->role,
            ]);
            return response()->json([
                "status" => true,
                "message" => "sukses menambahkan user",
                "data" => $data
            ], 200);
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
            $userData = User::find($id);
            if (!$userData) {
                return response()->json([
                    "status" => false,
                    "message" => "user not found"
                ], 404);
            }
            return response()->json([
                "status" => true,
                "data" => $userData
            ], 200);
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
            $validated = $request->validate([
                "username" => "string|required|unique:users,username",
                "role" => "string|required"
            ]);
            if (!User::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "user not found"
                ], 404);
            }
            $data = User::find($id)->update($validated);
            return response()->json([
                "status" => true,
                "message" => "sukses mengedit user",
                "data" => $data
            ], 200);
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
            if (!User::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "user not found"
                ], 404);
            }
            $data = User::destroy($id);
            return response()->json([
                "status" => true,
                "message" => "Sukses menghapus user!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
