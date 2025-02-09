<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Chart;
use App\Models\Kemasan;
use App\Models\Telur;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AddTransactionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $findUser = User::find($request->user_id);
            $findCashier = User::find($request->cashier_id);
            $findChart = Chart::where("id", $request->chart_id);
            if (!$findUser) {
                return new ApiResource(false, "user not found", null);
            }
            if (!$findCashier) {
                return new ApiResource(false, "cashier not found", null);
            }
            if (!$findChart) {
                return new ApiResource(false, "chart not found", null);
            }
            $data = Transaction::create([
                "user_id" => $request->user_id,
                "cashier_id" => $request->cashier_id,
                "transaction_date" => $request->transaction_date,
                "total_final_amount" => 0,
            ]);
            $data->charts()->attach($request->chart_id);
            $totalAmount = $data->charts->sum('total_amount');

            $data->update(['total_final_amount' => $totalAmount]);

            return new ApiResource(
                true,
                "success",
                $data,
            );
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
