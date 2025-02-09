<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KotaProvinsiController extends Controller
{
    public function insert(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "kota_id" => "array|required",
                "kota_id.*" => "integer|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }

            $checkKota = Kota::whereIn("id", $request->kota_id)->exists();
            if (!$checkKota) {
                return response()->json([
                    "message" => "Invalid Kota id"
                ], 400);
            }
            Kota::whereIn("id", $request->kota_id)->update([
                "provinsi_id" => $id
            ]);
            Kota::where("provinsi_id", $id)
                ->whereNotIn("id", $request->kota_id)
                ->update([
                    "provinsi_id" => null
                ]);
            return response()->json([
                "message" => "success"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $provinsi = Provinsi::with("kotas")->where("id", $id)->first();
            return response()->json([
                "data" => $provinsi
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
