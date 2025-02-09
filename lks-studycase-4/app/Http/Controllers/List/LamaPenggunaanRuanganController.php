<?php

namespace App\Http\Controllers\List;

use App\Models\Verification;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\User;
use DateTime;

class LamaPenggunaanRuanganController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $data = Verification::with("ruang")->where("status", "DISETUJUI")->get()->map(function ($item) {
                $dateStart = new DateTime($item->start_at);
                $dateEnd = new DateTime($item->end_at);

                $interval = $dateStart->diff($dateEnd);
                $lama = $interval->format('%H:%I:%S');
                $a = User::all()->every(function ($item, $key) {
                    return $item->role === "SISWA";
                });
                $b = User::groupBy("role")->get();
                return [
                    "payload" => $item,
                    "lama penggunaan" => $lama,
                    "datestart" => $dateStart,
                    "dateend" => $dateEnd,
                    "interval" => $interval,
                    "lama" => $lama,
                    "a" => $a,
                    "b" => $b,
                ];
            });
            return new ApiResource(true, "payload", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
