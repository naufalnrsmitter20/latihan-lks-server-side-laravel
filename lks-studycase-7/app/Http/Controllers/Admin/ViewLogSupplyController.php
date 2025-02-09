<?php

namespace App\Http\Controllers\Admin;

use App\Models\LogSupply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ViewLogSupplyController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "start_date" => "date|required",
                "end_date" => "date|required|after:start_date"
            ]);
            if ($validated->fails()) {
                return response()->json([
                    "status" => false,
                    "message" => $validated->errors(),
                ], 403);
            }
            $data = LogSupply::with(["supplier", "bahan"])->whereBetween("received_at", [$request->start_date, $request->end_date])->orWhereBetween("received_at", [$request->start_date, $request->end_date])->get();
            return response()->json([
                "status" => true,
                "data" => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
