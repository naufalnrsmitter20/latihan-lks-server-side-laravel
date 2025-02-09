<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Route;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RouteController extends Controller
{
    public function index(Request $request)
    {
        try {
            $from_place_qry = $request->input("from_place_name");
            $to_place_qry = $request->input("to_place_name");
            $data = Route::with(["schedules" => function ($qry) {
                $qry->orderBy("departure_time", "asc");
            }, "from_place", "to_place"])->whereHas("from_place", function ($item) use ($from_place_qry) {
                ($item)->where("name", "like", "%$from_place_qry%");
            })->whereHas("to_place", function ($item) use ($to_place_qry) {
                ($item)->where("name", "like", "%$to_place_qry%");
            })->limit(5)->get();
            return response()->json(["status" => true, "message" => "success", "data" => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make(request()->all(), [
                "from_place_id" => "required",
                "to_place_id" => "required",
                "schedule_id" => "array|required",
                // "schedule_id.*" => "exists:schedules,id",
            ]);

            $findFromplaceId = Place::find($request->from_place_id);
            $findToplaceId = Place::find($request->to_place_id);
            if (!$findFromplaceId && !$findToplaceId) {
                return response()->json(["status" => false, "message" => "Id Not Found", "data" =>  null], 404);
            }

            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors()->first(), "data" =>  null], 403);
            }

            $fidValidFromPlaceId = Schedule::where("from_place_id", $request->from_place_id)->exists();
            $fidValidToPlaceId = Schedule::where("to_place_id", $request->to_place_id)->exists();
            if (!$fidValidFromPlaceId || !$fidValidToPlaceId) {
                return response()->json(["status" => false, "message" => "Invalid from place id or to place id!", "data" =>  null], 404);
            }
            $data = Route::create([
                "from_place_id" => $request->from_place_id,
                "to_place_id" => $request->to_place_id,
            ]);
            $dataRoute = Route::find($data->id);
            $dataRoute->schedules()->attach($request->schedule_id);
            if (!$data) {
                return response()->json([
                    "status" => 422,
                    "message" => "Data cannot be processed"
                ], 422);
            }

            // DB::enableQueryLog();
            // dd(DB::getQueryLog());

            return response()->json(["status" => 200, "message" => "create success", "data" => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
