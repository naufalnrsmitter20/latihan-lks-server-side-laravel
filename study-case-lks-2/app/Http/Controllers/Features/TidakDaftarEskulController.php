<?php

namespace App\Http\Controllers\Features;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class TidakDaftarEskulController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $user = User::all();
            $data = $user->filter(function($item){
                $i = $item->eskul()->get();
                return count($i) === 0 && $item->role === "SISWA";
            });
            return new ApiResource(true, "Success", [
                "Data siswa yang tidak mendaftar eskul",
                "Data" => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}