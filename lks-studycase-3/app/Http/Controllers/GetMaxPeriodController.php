<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrakerinPeriod;
use App\Http\Resources\ApiResource;
use App\Models\YearPeriod;

class GetMaxPeriodController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $period = YearPeriod::with("prakerin_periods")->get();
            return new ApiResource( true, "period payload", $period);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}