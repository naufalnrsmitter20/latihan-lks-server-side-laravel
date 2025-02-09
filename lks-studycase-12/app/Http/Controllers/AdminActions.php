<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\Models\Society;
use App\Models\Validation;
use Illuminate\Http\Request;

class AdminActions extends Controller
{
    public function validate_society(Request $request, $id)
    {
        try {
            $findValidation = Validation::find($id);
            if (!$findValidation) {
                return response()->json([
                    "message" => "not found"
                ], 404);
            }
            $data = Validation::find($id)->update([
                "status" => $request->status,
                "validator_id" => $request->validator_id,
                "validator_notes" => $request->validator_notes,
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
    public function insert_job_category(Request $request)
    {
        try {
            $data = JobCategory::create([
                "job_category" => $request->job_category,
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
