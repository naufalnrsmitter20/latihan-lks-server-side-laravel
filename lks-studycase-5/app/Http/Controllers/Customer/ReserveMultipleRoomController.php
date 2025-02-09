<?php

namespace App\Http\Controllers\Customer;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Support\Facades\Validator;

class ReserveMultipleRoomController extends Controller
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
                "room_id" => "required|array",
                "room_id.*" => "integer"
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $userPayload = auth()->guard("api")->user();
            $findUser = User::find($userPayload->id);
            if (!$findUser) {
                return new ApiResource(false, "User Not Found", null);
            }
            $findRoom = Room::whereIn("id", $request->room_id)->get();
            if (!$findRoom) {
                return new ApiResource(false, "Room Not Found", null);
            }
            $validateRoom = Room::where("id", $request->room_id)->whereHas("reservations", function ($item) use ($request) {
                $item->where("status", "VERIFIED")->where(function ($h) use ($request) {
                    $h->whereBetween("checkIn_at", [$request->checkIn_at, $request->checkOut_at])
                        ->orWhereBetween("checkOut_at", [$request->checkIn_at, $request->checkOut_at])
                        ->orWhere(function ($subqry) use ($request) {
                            $subqry->where("checkIn_at", "<=", $request->checkIn_at)
                                ->where("checkOut_at", ">=", $request->checkOut_at);
                        });
                });
            })->exists();
            if ($validateRoom) {
                return new ApiResource(false, "Ruangan Ini sudah dipesan!", null);
            }
            $reservation = Reservation::create([
                "checkIn_at" => $request->checkIn_at,
                "checkOut_at" => $request->checkOut_at,
                "user_id" => $userPayload->id,
            ]);

            $curr_reservation = Reservation::find($reservation->id);
            $curr_reservation->rooms()->attach($request->room_id);
            return new ApiResource(true, "success to reserve", $curr_reservation->rooms()->get());
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
