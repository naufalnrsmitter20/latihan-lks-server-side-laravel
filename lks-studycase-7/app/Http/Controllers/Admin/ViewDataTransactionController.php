<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class ViewDataTransactionController extends Controller
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
            $data = Transaction::with(["detail_transaction.roti", "cashier", "customer"])->whereBetween("transaction_date", [$request->start_date, $request->end_date])->orWhereBetween("transaction_date", [$request->start_date, $request->end_date])
                ->get();
            return response()->json([
                "status" => true,
                "message" => "success",
                "data" => $data
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
