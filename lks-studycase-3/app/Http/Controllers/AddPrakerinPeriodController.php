<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\PrakerinPeriod;
use App\Models\YearPeriod;
use Illuminate\Support\Facades\Validator;

class AddPrakerinPeriodController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "period_status" => "required",
                "year_period_id" => "required",
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            
            if($request->period_status !== "ACTIVE" && $request->period_status !== "INACTIVE"){
                return new ApiResource(false, "Invalid Period Status", null);
            }
            
            $getPrakerinPeriod = PrakerinPeriod::all()->count();
            $getYearPeriod = YearPeriod::find($request->year_period_id)->pluck("max_period");

            if($getPrakerinPeriod >= $getYearPeriod[0]){
                return new ApiResource( false, "the maximum period limit has been reached", null);
            }

            $period = PrakerinPeriod::create([
                "period_status" => $request->period_status,
                "year_period_id" => $request->year_period_id,
            ]);
            if(!$period){
                return new ApiResource( false, "Failed to add period", null);
            }
            return new ApiResource( true, "Success to add period", $period);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}