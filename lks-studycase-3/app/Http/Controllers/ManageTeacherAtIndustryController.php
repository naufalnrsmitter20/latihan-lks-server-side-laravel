<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Industry;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class ManageTeacherAtIndustryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "teacher_id" => "required",
                "industry_id" => "required"
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $checkIsTeacher = User::find( $request->teacher_id);
            if($checkIsTeacher->role !== "TEACHER"){
                return new ApiResource(false, "User ini Bukan Guru!", null);
            }
            $data = Industry::find($request->industry_id)->update([
                "teacher_id" => $request->teacher_id,
            ]);
            if(!$data){
                return new ApiResource(false, "Failed to add teacher in industry!", null);
            }
            return new ApiResource(true, "Succcess to add teacher in industry!", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}