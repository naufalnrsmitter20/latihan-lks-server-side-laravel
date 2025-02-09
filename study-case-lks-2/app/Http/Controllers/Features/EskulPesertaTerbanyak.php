<?php

namespace App\Http\Controllers\Features;

use App\Models\Eskul;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;

class EskulPesertaTerbanyak extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $eskul = Eskul::all();
            $data = $eskul->sortByDesc(function($item, $key){
                return count($item->user()->get());
            });
            return new ApiResource(true, "Success", array_slice($data->values()->all(), 0, 3));
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}