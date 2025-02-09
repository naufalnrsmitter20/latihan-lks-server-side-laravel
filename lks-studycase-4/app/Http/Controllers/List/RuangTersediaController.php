<?php

namespace App\Http\Controllers\List;

use App\Models\Verification;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Ruang;
use Illuminate\Support\Facades\Validator;

class RuangTersediaController extends Controller
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
            $startAt = $request->start_at;
            $endAt = $request->end_at;
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $availableRooms = Ruang::whereDoesntHave('verifications', function ($query) use ($startAt, $endAt) {
                $query->where('status', 'DISETUJUI')
                    ->where(function ($q) use ($startAt, $endAt) {
                        $q->whereBetween('start_at', [$startAt, $endAt])
                            ->orWhereBetween('end_at', [$startAt, $endAt])
                            ->orWhere(function ($subquery) use ($startAt, $endAt) {
                                $subquery->where('start_at', '<=', $startAt)
                                    ->where('end_at', '>=', $endAt);
                            });
                    });
            })->get();
            return new ApiResource(true, "payload", $availableRooms);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
