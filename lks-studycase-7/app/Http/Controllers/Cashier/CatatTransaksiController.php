<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaction;
use App\Models\Roti;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CatatTransaksiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "customer_id" => "integer|required",
                "transaction_date" => "date|required",
                "item" => "array|required",
                "item.*.roti_id" => "required",
                "item.*.qty" => "required|integer"
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors(),
                ], 403);
            }
            $currentUser = auth()->guard("api")->user();
            $findcustomer = User::find($request->customer_id);
            $findccashier = User::find($currentUser->id);
            if (!$findcustomer) {
                return response()->json([
                    "status" => false,
                    "message" => "customer not found",
                ], 404);
            }
            if (!$findccashier) {
                return response()->json([
                    "status" => false,
                    "message" => "cahsir not found",
                ], 404);
            }
            if ($findcustomer->role !== "CUSTOMER") {
                return response()->json([
                    "status" => false,
                    "message" => "invalid role of customer",
                ], 404);
            }
            $totalAmount = 0;
            $detail_transaction = [];
            foreach ($request->item as $items) {
                $findProduct = Roti::find($items["roti_id"]);
                if (!$findProduct) {
                    return response()->json([
                        "status" => false,
                        "message" => "Product not found with ID: " . $items['roti_id'],
                    ], 404);
                }
                $subtotal = $findProduct->price * $items["qty"];
                $totalAmount += $subtotal;
                $detail_transaction[] = new DetailTransaction([
                    "roti_id" => $items["roti_id"],
                    "name" => $findProduct->name,
                    "qty" => $items["qty"],
                    "price" => $findProduct->price,
                    "subtotal" => $subtotal,
                ]);
                if ($findProduct->qty < $items["qty"]) {
                    return response()->json([
                        "status" => false,
                        "message" => "roti nya ga cukup",
                    ], 403);
                }
                $findProduct->qty -= $items["qty"];
                $findProduct->save();
            }
            $transaction = Transaction::create([
                "customer_id" => $request->customer_id,
                "cashier_id" => $currentUser->id,
                "total_amount" => $totalAmount,
                "transaction_date" => $request->transaction_date
            ]);
            $transaction->detail_transaction()->saveMany($detail_transaction);
            return response()->json([
                "status" => true,
                "message" => "success to add transaction",
                "data" => Transaction::with("detail_transaction")->find($transaction->id)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
