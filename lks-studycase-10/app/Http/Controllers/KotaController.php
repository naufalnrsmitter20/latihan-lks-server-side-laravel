<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = Kota::all();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
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
            $validate = Validator::make($request->all(), [
                "nama_kota" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = Kota::create([
                "nama_kota" => $request->nama_kota,
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
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
                "nama_kota" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = Kota::find($id)->update([
                "nama_kota" => $request->nama_kota,
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
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
            $findkota = Kota::find($id);
            if (!$findkota) {
                return response()->json([
                    "message" => "kota not found"
                ], 404);
            }
            Kota::destroy($id);
            return response()->json([
                "message" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => 500,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
