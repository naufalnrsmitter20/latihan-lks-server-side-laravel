<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Society;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsultationsController extends Controller
{
    public function index()
    {
        try {
            $data = Consultation::all();
            return response()->json([
                "consultations" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function requestConsultation(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "disease_history" => "string|required",
                "current_symptoms" => "string|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $token = $request->get("token");
            $findSociety = Society::where("login_tokens", $token)->first();
            Consultation::create([
                "disease_history" => $request->disease_history,
                "current_symptoms" => $request->current_symptoms,
                "society_id" => $findSociety->id
            ]);

            return response()->json([
                "message" => "Request consultation sent successful"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function VerifyConsultation(Request $request, $id)
    {
        try {
            $findUser = User::find($request->doctor_id);
            Consultation::find($id)->update([
                "status" => $request->status,
                "doctor_notes" => $request->doctor_notes,
                "doctor_id" => $findUser->id,
            ]);
            return response()->json([
                "message" => "success to verify Consultations!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}