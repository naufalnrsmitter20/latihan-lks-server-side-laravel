<?php

namespace App\Http\Controllers;

use App\Models\AvailablePosition;
use App\Models\JobVacancy;
use App\Models\Society;
use App\Models\Validation;
use Illuminate\Http\Request;

class JobVacancyController extends Controller
{
    public function index()
    {
        try {
            $data = JobVacancy::with(["job_category", "available_positions"])->get();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function show(Request $request, $id)
    {
        try {
            $data = JobVacancy::with(["job_category", "available_positions", "available_positions.job_apply_positions"])->find($id);
            $token = $request->get("token");
            $getSocietyData = Society::where("login_tokens", $token)->first();
            $verifyValidations = Validation::where("society_id", $getSocietyData->id)->where("status", "accepted")->first();
            if (!$verifyValidations) {
                return response()->json([
                    "message" => "Your data validator must be accepted by validator before"
                ], 403);
            }
            return response()->json([
                "vacancy" => [
                    "id" => $data->id,
                    "company" => $data->company,
                    "address" => $data->address,
                    "description" => $data->description,
                    "job_category" => [
                        "id" => $data->job_category->id,
                        "job_category" => $data->job_category->job_category,
                    ],
                    "available_positions" => $data->available_positions->map(function ($ap) {
                        return [
                            "id" => $ap->id,
                            "position" => $ap->position,
                            "capacity" => $ap->capacity,
                            "apply_capacity" => $ap->apply_capacity,
                            "job_apply_positions_count" => $ap->job_apply_positions->count(),
                        ];
                    })
                ]
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
            $data = JobVacancy::create([
                "job_category_id" => $request->job_category_id,
                "company" => $request->company,
                "address" => $request->address,
                "description" => $request->description,
            ]);
            if ($data) {
                return response()->json([
                    "message" => "success"
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
