<?php

namespace App\Http\Controllers\Features;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiResource;
use App\Models\Eskul;
use Illuminate\Http\Request;

class JumlahPesertaEskul extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $eskul = Eskul::all();
            $data = $eskul->map(function($item){
                return [
                    "Eskul" => $item,
                    "Jumlah Siswa" => count($item->user()->get())
                ];
            });
            return new ApiResource(true, "Success", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}