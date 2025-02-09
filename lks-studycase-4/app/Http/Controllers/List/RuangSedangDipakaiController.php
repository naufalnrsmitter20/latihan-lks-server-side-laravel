<?php

namespace App\Http\Controllers\List;

use App\Models\Verification;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RuangSedangDipakaiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "start_at" => "required|date",
                "end_at" => "required|date",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $verificationStatus = Verification::with("ruang")->where('status', 'DISETUJUI')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_at', [$request->start_at, $request->end_at])
                        ->orWhereBetween('end_at', [$request->start_at, $request->end_at])
                        ->orWhere(function ($subquery) use ($request) {
                            $subquery->where('start_at', '<=', $request->start_at)
                                ->where('end_at', '>=', $request->end_at);
                        });
                })
                ->get();
            return new ApiResource(true, "payload", $verificationStatus);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
