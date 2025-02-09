<?php

namespace App\Http\Controllers\Owner;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\QtyTelur;
use Illuminate\Support\Facades\Validator;

class ViewEachQuantitySoldEggController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $val = Validator::make($request->all(), [
                "start_date" => "date|required",
                "end_date" => "date|required|after:start_date",
            ]);
            $data = Transaction::whereBetween('transaction_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('transaction_date', [$request->end_date, $request->start_date])
                ->with('charts.qty_telur')
                ->get()
                ->pluck('charts.*.qty_telur.qty')->filter(function ($t) {
                    return $t != null;
                })->toArray();
            $out = array_sum(array_merge(...array_values($data)));

            return new ApiResource(
                true,
                "success",
                $out,
            );
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
