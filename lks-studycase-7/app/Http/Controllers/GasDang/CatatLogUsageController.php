<?php

namespace App\Http\Controllers\GasDang;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\LogUsage;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CatatLogUsageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "usage_at" => "required|date",
                "bahan" => "array|required",
                "bahan.*.bahan_id" => "integer|required",
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors(),
                ], 403);
            }
            $data = [];
            foreach ($request->bahan as $item) {
                $findbahan = Bahan::find($item["bahan_id"]);
                if (!$findbahan) {
                    return response()->json([
                        "status" => false,
                        "message" => "bahan not found",
                    ], 404);
                }
                $quantityRill = $findbahan->rotis->map(function ($h) {
                    return $h->pivot->quantity_used;
                })->first();

                $data[] = ([
                    "bahan_id" => $item["bahan_id"],
                    "qty" => $quantityRill,
                    "usage_at" => $request->usage_at,
                ]);
            }
            LogUsage::insert($data);
            return response()->json([
                "status" => true,
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
