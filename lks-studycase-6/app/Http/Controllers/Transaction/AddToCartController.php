<?php

namespace App\Http\Controllers\Transaction;

use App\Models\User;
use App\Models\Telur;
use App\Models\Kemasan;
use App\Models\QtyTelur;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Chart;
use App\Models\QTYKemasan;

class AddToCartController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $findUser = User::find($request->user_id);
            $findTelur = Telur::find($request->telur_id);
            $findKemasan = Kemasan::find($request->kemasan_id);
            if (!$findUser) {
                return new ApiResource(false, "user not found", null);
            }
            if (!$findTelur) {
                return new ApiResource(false, "telur not found", null);
            }
            if (!$findKemasan) {
                return new ApiResource(false, "kemasan not found", null);
            }
            $telurQTY = QTYTelur::create([
                "telur_id" => $request->telur_id,
                "qty" => $request->telur_qty,
                "total_price" => $findTelur->price + $request->telur_qty,
            ]);
            $kemasanQTY = QTYKemasan::create([
                "kemasan_id" => $request->kemasan_id,
                "qty" => $request->kemasan_qty,
                "total_price" => $findTelur->price + $request->kemasan_qty,
            ]);
            $chart = Chart::create([
                "user_id" => $request->user_id,
                "qty_telur_id" => $telurQTY->id,
                "qty_kemasan_id" => $kemasanQTY->id,
                "total_amount" => ($telurQTY->total_price * $telurQTY->qty) + ($kemasanQTY->total_price * $kemasanQTY->qty),
            ]);
            return new ApiResource(true, "success to add to cart", [
                "telur" => $telurQTY,
                "kemasan" => $kemasanQTY,
                "chart" => $chart,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
