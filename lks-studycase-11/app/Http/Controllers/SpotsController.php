<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Spot;
use App\Models\User;
use App\Models\Vaccine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpotsController extends Controller
{
    public function index()
    {
        try {
            $data = Spot::with("vaccines")->get();
            $dataVaccines = Vaccine::all();
            return response()->json([
                "data" => $data->map(function ($x) use ($dataVaccines) {
                    return [
                        "id" => $x->id,
                        "name" => $x->name,
                        "address" => $x->address,
                        "serve" => $x->serve,
                        "capacity" => $x->capacity,
                        "available_vaccines" => $dataVaccines->mapWithKeys(function ($y) use ($x) {
                            return [$y->name => $x->vaccines->contains($y->id)];
                        })
                    ];
                })
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
            $token = $request->get("token");
            $date = date("Y-m-d");
            if ($request->has("date")) {
                $date = $request->get("date");
            }
            $getSociety = Society::where("login_tokens", $token)->first();
            $data = Spot::find($id);
            $fixData = Spot::with(["vaccinations" => function ($item) use ($date) {
                $item->where("date", $date);
            }])->find($id)->vaccinations->count();

            return response()->json([
                "message" => "success",
                "data" => [
                    "date" => $date,
                    "spot" => $data,
                    "vaccinations_count" => $fixData !== null ? $fixData : []
                ]
            ],  200);
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
                "name" => "string|required",
                "address" => "string|required",
                "serve" => "integer|required",
                "capacity" => "integer|required",
                "vaccine_id" => "array|required",
                "vaccine_id.*" => "integer|required",
                "regional_id" => "integer|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $data = Spot::create([
                "name" => $request->name,
                "address" => $request->address,
                "serve" => $request->serve,
                "capacity" => $request->capacity,
                "regional_id" => $request->regional_id
            ]);
            $checkVaccines = Vaccine::whereIn("id", $request->vaccine_id)->get();
            $checkVaccinesExist = Vaccine::whereIn("id", $request->vaccine_id)->get();
            if (!$checkVaccinesExist) {
                return response()->json([
                    "message" => "Invalid Vaccine Id!"
                ], 403);
            }
            if ($checkVaccines->count() > $request->serve) {
                return response()->json([
                    "message" => "jumlah vaksin melebihi serve"
                ], 403);
            }
            $findData = Spot::find($data->id);
            $findData->vaccines()->attach($request->vaccine_id);
            return response()->json([
                "message" => "success",
                "data" => Spot::with("vaccines")->find($data->id)
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
