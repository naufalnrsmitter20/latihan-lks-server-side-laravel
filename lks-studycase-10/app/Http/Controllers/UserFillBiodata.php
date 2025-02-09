<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserFillBiodata extends Controller
{
    public function index()
    {
        try {
            $data = User::with("biodata")->get();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function fill(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "age" => "integer|required",
                "kota_id" => "integer|required",
                "provinsi_id" => "integer|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }

            $data = Biodata::create([
                "user_id" => (int) $id,
                "age" => (int)$request->age,
                "kota_id" => (int)$request->kota_id,
                "provinsi_id" => (int)$request->provinsi_id,
            ]);

            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
