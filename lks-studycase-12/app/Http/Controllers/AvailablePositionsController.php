<?php

namespace App\Http\Controllers;

use App\Models\AvailablePosition;
use Illuminate\Http\Request;

class AvailablePositionsController extends Controller
{
    public function index()
    {
        try {
            $data = AvailablePosition::with("job_vacancy")->get();
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
            $data = AvailablePosition::create([
                "job_vacancy_id" => $request->job_vacancy_id,
                "position" => $request->position,
                "capacity" => $request->capacity,
                "apply_capacity" => $request->apply_capacity,
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
