<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Roti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatatKomposisiRotiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "roti_id" => "required|integer",
                "bahan_id" => "array|required",
                "bahan_id.*" => "integer|required",
                "quantity_used" => "array|required",
                "quantity_used.*" => "integer|required"
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors(),
                ], 403);
            }
            $roti = Roti::find($request->roti_id);

            foreach ($request->bahan_id as $index => $bahanId) {
                $quantityUsed = $request->quantity_used[$index];
                $bahan = Bahan::find($bahanId);

                if ($quantityUsed > $bahan->qty) {
                    return response()->json([
                        "status" => false,
                        "error" => "Bahan tidak mencukupi",
                    ], 403);
                }
                $bahan->qty -= $quantityUsed;
                $bahan->save();

                $roti->bahans()->attach($bahanId, ["quantity_used" => $quantityUsed]);
            }
            return response()->json([
                "status" => false,
                "message" => Roti::with("bahans")->find($request->roti_id),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
