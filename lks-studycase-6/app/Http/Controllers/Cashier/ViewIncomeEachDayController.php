<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;

class ViewIncomeEachDayController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $user = auth()->guard("api")->user();
            $data = User::with("transactions")->find($user->id)->select("transactions.total_final_amount");
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
