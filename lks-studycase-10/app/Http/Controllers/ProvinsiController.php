<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Provinsi::with("kotas")->get();
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
                "nama_provinsi" => "string|required",
                "kota_id" => "array",
                "kota_id.*" => "integer",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = Provinsi::create([
                "nama_provinsi" => $request->nama_provinsi,
            ]);
            $checkKota = Kota::whereIn("id", $request->kota_id)->exists();
            if (!$checkKota) {
                return response()->json([
                    "message" => "Invalid Kota id"
                ], 400);
            }
            Kota::whereIn("id", $request->kota_id)->update([
                "provinsi_id" => $data->id
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
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
            $validate = Validator::make($request->all(), [
                "nama_provinsi" => "string|required",
                "kota_id" => "array",
                "kota_id.*" => "integer",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = Provinsi::find($id)->update([
                "nama_provinsi" => $request->nama_provinsi,
            ]);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $findprovinsi = Provinsi::find($id);
            if (!$findprovinsi) {
                return response()->json([
                    "message" => "provinsi not found"
                ], 404);
            }
            Provinsi::destroy($id);
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
