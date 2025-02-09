<?php

namespace App\Http\Controllers;

use App\Models\AvailablePosition;
use App\Models\JobApplyPosition;
use App\Models\JobApplySociety;
use App\Models\Society;
use App\Models\JobVacancy;
use App\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApplyingJobsController extends Controller
{
    public function index()
    {
        try {
            $data = JobVacancy::with(["job_category", "available_positions", "available_positions.job_apply_positions", "available_positions.job_apply_positions.society"])->get();
            return response()->json([
                "vacancies" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "notes" => "string|required",
                "job_vacancy_id" => "integer|required",
                "available_position_id" => "array|required",
                "available_position_id.*" => "integer|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 401);
            }
            $token = $request->get("token");
            $getSocietyData = Society::where("login_tokens", $token)->first();
            $verifyValidations = Validation::where("society_id", $getSocietyData->id)->where("status", "accepted")->first();
            if (!$verifyValidations) {
                return response()->json([
                    "message" => "Your data validator must be accepted by validator before"
                ], 403);
            }
            $checkAvailablePosition = AvailablePosition::whereIn("id", $request->available_position_id)->exists();
            if (!$checkAvailablePosition) {
                return response()->json([
                    "message" => "position not found"
                ], 404);
            }
            $appplySociety = JobApplySociety::create([
                "notes" => $request->notes,
                "job_vacancy_id" => $request->job_vacancy_id,
                "date" => now(),
                "society_id" => $getSocietyData->id,
            ]);
            if ($appplySociety) {
                $getAvailablePosition = AvailablePosition::whereIn("id", $request->available_position_id)->get();
                foreach ($getAvailablePosition as $item) {
                    JobApplyPosition::create([
                        "date" => now(),
                        "society_id" => $getSocietyData->id,
                        "job_vacancy_id" => $request->job_vacancy_id,
                        "job_apply_society_id" => $appplySociety->id,
                        "available_position_id" => $item->id
                    ]);
                }
                return response()->json([
                    "message" => "Appliying for job successfull"
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
