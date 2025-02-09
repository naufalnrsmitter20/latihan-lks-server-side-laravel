<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Society;
use App\Models\Spot;
use App\Models\Vaccination;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VaccinationsController extends Controller
{
    public function index()
    {
        try {
            $data = Vaccination::with(["spot", "spot.regional", "vaccine", "doctor"])->get();
            return response()->json([
                "vaccinations" => [
                    "first" => $data->first(),
                    "second" => $data->last()
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
            $validate = Validator::make($request->all(), [
                "spot_id" => "integer|required",
                "date" => "date|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $token = $request->get("token");
            $findSociety = Society::where("login_tokens", $token)->first();
            $getSociety = $findSociety->vaccinations->count();
            // $findVaccination = Vaccination::where("society_id", $findSociety->id);
            $findConsultation = Consultation::where("society_id", $findSociety->id)->first();
            if ($findConsultation->status !== "accepted") {
                return response()->json([
                    "message" => "Your consultation must be accepted by doctor before"
                ], 401);
            }
            if ($getSociety === 0) {
                $data = Vaccination::create([
                    "society_id" => $findSociety->id,
                    "spot_id" => $request->spot_id,
                    "date" => $request->date,
                    "dose" => 1,
                ]);
                return response()->json([
                    "message" => "success",
                    "data" => $data
                ], status: 200);
            } else if ($getSociety === 1) {
                $getDataVaccination = Vaccination::where("society_id", $findSociety->id)->first();
                $getExistingDate = new DateTime($getDataVaccination->date);
                $getCurrentDate = new DateTime($request->date);
                $difference = $getExistingDate->diff($getCurrentDate);
                if ($difference->days < 30) {
                    return response()->json([
                        "message" => "Wait at least +30 days from 1st Vaccination",
                    ], status: 401);
                } else {
                    $data = Vaccination::create([
                        "society_id" => $findSociety->id,
                        "spot_id" => $request->spot_id,
                        "date" => $request->date,
                        "dose" => 1
                    ]);
                    return response()->json([
                        "message" => "success",
                        "data" => $data
                    ], status: 200);
                }
            } else if ($getSociety === 2) {
                return response()->json([
                    "message" => "Society has been 2x vaccinated",
                ], status: 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function verify(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "doctor_id" => "integer|required",
                "vaccine_id" => "integer|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $check = Vaccination::find($id);
            if (!$check) {
                return response()->json([
                    "message" => "Not Found",
                ], status: 404);
            }
            Vaccination::find($id)->update([
                "doctor_id" => $request->doctor_id,
                "vaccine_id" => $request->vaccine_id
            ]);
            return response()->json([
                "message" => "success",
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}