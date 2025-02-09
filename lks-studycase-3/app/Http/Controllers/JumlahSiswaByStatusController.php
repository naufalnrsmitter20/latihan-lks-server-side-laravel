<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Prakerin;

class JumlahSiswaByStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $dataUserditerima = Prakerin::where("status", "DITERIMA")->with("users")->latest()->count();
            $dataUserditolak = Prakerin::where("status", "DITOLAK")->with("users")->latest()->count();
            $dataUsermenunggu = Prakerin::where("status", "MENUNGGU")->with("users")->latest()->count();
            return new ApiResource(true,"success!", [
                "Jumlah siswa dierima" => $dataUserditerima,
                "Jumlah siswa ditolak" => $dataUserditolak,
                "Jumlah siswa menunggu" => $dataUsermenunggu,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}