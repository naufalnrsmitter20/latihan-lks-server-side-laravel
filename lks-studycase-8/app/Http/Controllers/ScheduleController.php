<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduleController extends Controller
{
    public function index()
    {
        try {
            $data = Schedule::with(["from_place", "to_place"])->get();
            return response()->json(["status" => true, "message" => "success", "data" => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make(request()->all(), [
                "type" => "required",
                "line" => "required",
                "from_place_id" => "required",
                "to_place_id" => "required",
                "departure_time" => "date|required",
                "arrival_time" => "date|required|after:departure_time",
            ]);

            $findFromplaceId = Place::find($request->from_place_id);
            $findToplaceId = Place::find($request->to_place_id);
            if (!$findFromplaceId && !$findToplaceId) {
                return response()->json(["status" => false, "message" => "Id Not Found", "data" =>  null], 404);
            }

            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors(), "data" =>  null], 403);
            }

            $getLatLongPlace = [
                "latitude1" => $findFromplaceId->latitude,
                "latitude2" => $findToplaceId->latitude,
                "longitude1" => $findFromplaceId->longitude,
                "longitude2" => $findToplaceId->longitude,
            ];

            function distanceRumus($latitude1, $longitude1, $latitude2, $longitude2)
            {
                // Radius of Earth in kilometers
                $R = 6371;

                // Convert degrees to radians
                $latitude1Rad = deg2rad($latitude1);
                $latitude2Rad = deg2rad($latitude2);
                $longitudeDiffRad = deg2rad($longitude2 - $longitude1);

                // Calculate the distance
                $x = $longitudeDiffRad * cos(($latitude1Rad + $latitude2Rad) / 2);
                $y = $latitude2Rad - $latitude1Rad;
                $distance = sqrt($x * $x + $y * $y) * $R;

                return $distance; // Distance in kilometers
            }

            $distance = distanceRumus($getLatLongPlace["latitude1"], $getLatLongPlace["latitude2"], $getLatLongPlace["longitude1"], $getLatLongPlace["longitude2"]);
            $arrival_time = new \DateTime($request->arrival_time);
            $departure_time = new \DateTime($request->departure_time);
            $travel_time = $departure_time->diff($arrival_time);

            $total_seconds = ($travel_time->y * 360 * 30  * 24) + ($travel_time->m * 30 * 24) + ($travel_time->d * 24) + ($travel_time->h);

            if ($travel_time->invert) {
                $total_seconds *= -1;
            }

            $speed = (int)$distance / (int)$total_seconds;

            $data = Schedule::create([
                "type" => $request->type,
                "line" => $request->line,
                "from_place_id" => $request->from_place_id,
                "to_place_id" => $request->to_place_id,
                "departure_time" => $request->departure_time,
                "arrival_time" => $request->arrival_time,
                "travel_time" => $total_seconds,
                "distance" => $distance,
                "speed" => $speed,
            ]);
            if (!$data) {
                return response()->json([
                    "status" => 422,
                    "message" => "Data cannot be processed"
                ], 422);
            }

            return response()->json(["status" => 200, "message" => "create success", "data" => $data], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        try {

            $finduser = Schedule::find($id);
            if (!$finduser) {
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }
            $del = Schedule::destroy($id);
            if (!$del) {
                return response()->json(["status" => false, "message" => "data cannot be deleted"], 400);
            }
            return response()->json(["status" => true, "message" => "delete success", "data" => $del], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
