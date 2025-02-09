<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User::with(["biodata", "biodata.kota", "biodata.provinsi"])->get();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "email" => "string|required|unique:users,email",
                "password" => "string|required",
                "role" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = User::create([
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role,
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "email" => "string",
                "password" => "string",
                "role" => "string",
                "age" => "integer",
                "kota_id" => "integer",
                "provinsi_id" => "integer",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $findKota = Kota::find($request->kota_id);
            $findProvinsi = Provinsi::find($request->provinsi_id);
            if (!$findKota && !$findProvinsi) {
                return response()->json([
                    "message" => "Kota id atau provinsi id tidak valid!"
                ], 400);
            }
            $data = User::find($id)->update([
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "role" => $request->role,
            ]);
            $biodata = Biodata::create([
                "user_id" => $id,
                "age" => $request->age,
                "kota_id" => $request->kota_id,
                "provinsi_id" => $request->provinsi_id,
            ]);
            return response()->json([
                "message" => "success",
                "data" => ["userData" => $data, "Biodata" => $biodata]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
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
                return response()->json([
                    "message" => "user not found"
                ], 404);
            }
            User::destroy($id);
            return response()->json([
                "message" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
