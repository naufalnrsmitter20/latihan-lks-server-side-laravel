<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class viewUsedRoomNumberController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "checkIn_at" => "required|date",
                "checkOut_at" => "required|date|after:checkIn_at",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $room = Room::whereHas("reservations", function ($item) use ($request) {
                $item->where("status", "VERIFIED")->where(function ($h) use ($request) {
                    $h->whereBetween("checkIn_at", [$request->checkIn_at, $request->checkOut_at])
                        ->orWhereBetween("checkOut_at", [$request->checkIn_at, $request->checkOut_at])
                        ->orWhere(function ($subqry) use ($request) {
                            $subqry->where("checkIn_at", "<=", $request->checkIn_at)
                                ->where("checkOut_at", ">=", $request->checkOut_at);
                        });
                });
            })->get();
            return new ApiResource(true, "payload", [
                "Room Number" => ($room->pluck("room_number")->implode(", "))
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
