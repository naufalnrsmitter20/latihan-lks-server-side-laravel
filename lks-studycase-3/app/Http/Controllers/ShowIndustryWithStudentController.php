<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Industry;
use App\Models\Prakerin;
use Illuminate\Support\Facades\Validator;

class ShowIndustryWithStudentController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "prakerin_period_id" => "required",
                "teacher_id" => "required",
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $getindustry = Industry::with(["prakerins.users", "prakerins.prakerin_periods"])->where("teacher_id", $request->teacher_id)->whereHas("prakerins",fn($item)=> $item->where("prakerin_period_id", $request->prakerin_period_id))->get();
            return new ApiResource(true, "Success", $getindustry);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}