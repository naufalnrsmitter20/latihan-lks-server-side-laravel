<?php

namespace App\Http\Controllers\Customer;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;

class ViewAvailableRoomController extends Controller
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
            $user = auth()->guard("api")->user();
            $room = Room::whereDoesntHave("reservations", function ($item) use ($request) {
                $item->whereNot("status", "PENDING")->where(function ($h) use ($request) {
                    $h->whereBetween("checkIn_at", [$request->checkIn_at, $request->checkOut_at])
                        ->orWhereBetween("checkOut_at", [$request->checkIn_at, $request->checkOut_at])
                        ->orWhere(function ($subqry) use ($request) {
                            $subqry->where("checkIn_at", "<=", $request->checkIn_at)
                                ->where("checkOut_at", ">=", $request->checkOut_at);
                        });
                });
            })->get();
            $reser = Reservation::where("user_id", $user->id)->where("status", "PENDING")->get();
            return new ApiResource(true, "payload", ["available room" => $room, "rencana checkIn" => $reser]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
