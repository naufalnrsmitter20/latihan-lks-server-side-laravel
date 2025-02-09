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
            $data = User::all();
            return response()->json(["status" => true, "message" => "success", "data" => $data], 200);
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
            $validate = Validator::make(request()->all(), [
                "username" => "string|required|unique:users,username",
                "password" => "string|required",
                "role" => "string|required",
            ]);

            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors(), "data" =>  null], 403);
            }

            $data = User::create([
                "username" => $request->username,
                "password" => $request->password,
                "role" => $request->role,
            ]);

            return response()->json($data, 200);
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
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }
            return response()->json(["status" => true, "message" => "success", "data" => $data], 200);
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
            $validate = Validator::make(request()->all(), [
                "username" => "string|required",
                "role" => "string|required",
            ]);

            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors()->first(), "data" =>  null], 403);
            }

            $finduser = User::find($id);
            if (!$finduser) {
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }

            $data = User::find($id)->update([
                "username" => $request->username,
                "password" => $request->password || $finduser->password,
                "role" => $request->role,
            ]);

            if (!$data) {
                return response()->json(["status" => false, "message" => "faild to update", "data" => null], 422);
            }


            return response()->json(["status" => true, "data" => [
                "username" => $request->username,
                "password" => $request->password,
                "role" => $request->role,
            ], "message" => "success"], 200);
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

            $finduser = User::find($id);
            if (!$finduser) {
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }
            $del = User::destroy($id);
            return response()->json(["status" => true, "message" => "success", "data" => $del], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
