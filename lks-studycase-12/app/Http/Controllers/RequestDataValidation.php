<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Validation;
use Illuminate\Http\Request;

class RequestDataValidation extends Controller
{
    public function index()
    {
        try {
            $data = Validation::with(["validator", "job_category", "society"])->get();
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
    public function store(Request $request)
    {
        try {
            $token = $request->get("token");
            $findSociety = Society::where("login_tokens", $token)->first();
            $data = Validation::create([
                "work_experience" => $request->work_experience,
                "job_category_id" => $request->job_category_id,
                "job_position" => $request->job_position,
                "reason_accepted" => $request->reason_accepted,
                "society_id" => $findSociety->id,
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
