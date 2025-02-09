<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;

class DataSiswaBelumMengajukan extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            
            // $datatolak = User::where("role", ["STUDENT"])->with("prakerins")->get()->filter(function($t){
            //     return $
            // });

            $databiasa = User::doesntHave("prakerins")->where("role", ["STUDENT"])->get();

            return new ApiResource(true,"success!", [
                "belum mengajukan prakerin" => $databiasa,
                // "ditolak" => $datatolak
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}