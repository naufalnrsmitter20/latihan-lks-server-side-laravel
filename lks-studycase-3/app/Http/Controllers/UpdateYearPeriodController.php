<?php

namespace App\Http\Controllers;

use App\Models\YearPeriod;
use Illuminate\Http\Request;
use App\Models\PrakerinPeriod;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class UpdateYearPeriodController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "year" => "required",
                "max_period" => "required|integer",
            ]);
            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }

            $period = PrakerinPeriod::find($id)->update([
                "year" => $request->year,
                "max_period" => $request->max_period
            ]);
            
            if(!$period){
                return new ApiResource( false, "Failed to update period", null);
            }
            return new ApiResource( true, "Success to update period", $period);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}