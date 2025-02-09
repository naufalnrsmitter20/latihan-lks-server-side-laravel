<?php

namespace App\Http\Controllers\GasDang;

use App\Models\User;
use App\Models\LogSupply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Support\Facades\Validator;

class CatatLogSupplyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "supplier_id" => "integer|required",
                "bahan_id" => "integer|required",
                "received_at" => "date|required"
            ]);
            $findsupplier = User::find($request->supplier_id);
            $findbahan = Bahan::find($request->bahan_id);
            if (!$findsupplier) {
                return response()->json([
                    "status" => false,
                    "message" => "supplier tidak ditemukan",
                ], 404);
            }
            if ($findsupplier->role !== "SUPPLIER") {
                return response()->json([
                    "status" => false,
                    "message" => "invalid supplier id ",
                ], 404);
            }
            if (!$findbahan) {
                return response()->json([
                    "status" => false,
                    "message" => "bahan tidak ditemukan",
                ], 404);
            }
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors(),
                ], 403);
            }
            $log = LogSupply::create([
                "supplier_id" => $request->supplier_id,
                "bahan_id" => $request->bahan_id,
                "qty" => $findbahan->qty,
                "received_at" => $request->received_at,
            ]);
            return response()->json([
                "status" => true,
                "message" => "sukses mencatat log",
                "data" => $log
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
