<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;

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
            $data = Regional::create([
                "province" => $request->province,
                "district" => $request->district,
            ]);
            if ($data) {
                return response()->json([
                    "message" => "success"
                ], 200);
            }
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
            $find = Regional::find($id);
            if (!$find) {
                return response()->json([
                    "message" => "not found"
                ], 404);
            }
            Regional::destroy($id);
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
}
