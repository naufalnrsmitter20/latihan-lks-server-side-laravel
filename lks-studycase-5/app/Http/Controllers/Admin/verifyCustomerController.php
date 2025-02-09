<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;

class verifyCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "reservation_id" => "required|integer",
                "status" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            if ($request->status !== "REJECTED" && $request->status !== "VERIFIED") {
                return new ApiResource(false, "Invalid Status", null);
            }
            $checkreservation = Reservation::find($request->reservation_id);
            if (!$checkreservation) {
                return new ApiResource(false, "Reservation not found", null);
            }
            $admin = auth()->guard("api")->user();
            $data = Reservation::find($request->reservation_id)->update([
                "admin_id" => $admin->id,
                "status" => $request->status,
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to verify", null);
            }
            return new ApiResource(true, "success to verify", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
