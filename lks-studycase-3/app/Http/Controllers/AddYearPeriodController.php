<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\YearPeriod;
use Illuminate\Support\Facades\Validator;

class AddYearPeriodController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "year" => "required",
                "max_period" => "required|integer",
            ]);
            
            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            
            $data = YearPeriod::create([
                "year" => $request->year,
                "max_period" => $request->max_period
            ]);
            if(!$data){
                return new ApiResource(false, "Failed to create year period!", null);
            }
            return new ApiResource(true, "success to create year period!", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}