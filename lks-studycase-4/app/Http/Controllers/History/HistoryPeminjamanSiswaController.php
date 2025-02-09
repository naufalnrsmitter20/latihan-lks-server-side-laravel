<?php

namespace App\Http\Controllers\History;

use App\Models\Ruang;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class HistoryPeminjamanSiswaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $userPayload = auth()->guard("api")->user();
            $data = Ruang::with("verifications")->whereHas("verifications", function ($h) use ($userPayload) {
                $h->where("siswa_id", $userPayload->id);
            })->get();
            return new ApiResource(true, "Success", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
