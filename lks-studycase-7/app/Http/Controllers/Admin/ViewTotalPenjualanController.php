<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ViewTotalPenjualanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "start_date" => "date|required",
                "end_date" => "date|required|after:start_date"
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors(),
                ], 403);
            }
            $data = Transaction::whereBetween("transaction_date", [$request->start_date, $request->end_date])->orWhereBetween("transaction_date", [$request->start_date, $request->end_date])
                ->select(DB::raw("DATE(transaction_date) as tgl"), DB::raw("SUM(total_amount) as total"))
                ->groupBy(DB::raw("DATE(transaction_date) "))
                ->get();
            return response()->json([
                "status" => true,
                "data" => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
