<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionalController extends Controller
{
    public function index()
    {
        try {
            $data = Regional::all();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "province" => "string|required",
                "district" => "string|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            Regional::create([
                "province" => $request->province,
                "district" => $request->district,
            ]);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            Regional::destroy($id);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}