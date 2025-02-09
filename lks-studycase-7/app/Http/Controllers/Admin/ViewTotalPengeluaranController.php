<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogSupply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ViewTotalPengeluaranController extends Controller
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
            $data = LogSupply::join('bahans', 'log_supplies.bahan_id', '=', 'bahans.id')
                ->whereBetween("log_supplies.received_at", [$request->start_date, $request->end_date])
                ->select(
                    DB::raw("DATE(log_supplies.received_at) as tgl"),
                    DB::raw("SUM(bahans.qty * bahans.price) as total")
                )
                ->groupBy(DB::raw("DATE(log_supplies.received_at)"))
                ->get();
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
