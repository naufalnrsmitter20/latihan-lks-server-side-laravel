<?php

namespace App\Http\Controllers\Owner;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class ViewTransactionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $data = Transaction::whereBetween("transaction_date", [$request->start_date, $request->end_date])->orWhereBetween("transaction_date", [$request->end_date, $request->start_date])->get();
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
