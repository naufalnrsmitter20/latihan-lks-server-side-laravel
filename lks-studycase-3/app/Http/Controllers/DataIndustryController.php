<?php

namespace App\Http\Controllers;

use App\Models\PrakerinPeriod;
use App\Models\User;
use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class DataIndustryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make(request()->all(), [
                "prakerin_period_id" => "required",
                "status" => "required|string"
            ]);
            
            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            
            $data = Industry::with("prakerins")->get()->map(function($item) use ($request){
                $getItem = $item;
                $filteredPeriod = $getItem->prakerins->filter(function($fg) use ($request){
                    return $fg->prakerin_period_id === $request->prakerin_period_id;
                });
                if(!$filteredPeriod){
                    return null;
                }
                if($request->status === "ALL"){
                    return $filteredPeriod;
                } else if($request->status === "DITOLAK"){
                    $praker = $getItem;
                    $filteredTolak = $praker->prakerins->map(fn($h)=>$h)->filter(function($tl) use ($request){
                        $filteredbyperiod = $tl->prakerin_period_id === $request->prakerin_period_id;
                        return $tl->status === "DITOLAK" && $filteredbyperiod;
                    })->map(function($idf){
                        $findUser = User::with(["prakerins.prakerin_periods", "prakerins.users"])->find($idf->user_id)->prakerins->last();
                        return $findUser;
                        
                    });
                    return  ["industry" => Arr::except($praker->toArray(), "prakerins"), "data" => $filteredTolak];
                } else if($request->status === "DITERIMA"){
                    $praker = $getItem;
                    $filteredterima = $praker->prakerins->map(fn($h)=>$h)->filter(function($tl) use($request){
                        $filteredbyperiod = $tl->prakerin_period_id === $request->prakerin_period_id;
                        return $tl->status === "DITERIMA" && $filteredbyperiod;
                    })->map(function($idf){
                        $findUser = User::find($idf->user_id);
                        $findperiod = PrakerinPeriod::find($idf->prakerin_period_id);
                        return [
                            "prakerin" => $idf,
                            "siswa" => $findUser,
                            "period" => $findperiod
                        ];
                    });
                    return  ["industry" => Arr::except($praker->toArray(), "prakerins"), "data" => $filteredterima];
                } else{
                    return "Data tidak ditemukan!";
                }
            });
            if(!$data){
                return new ApiResource(false,"Failed to get Data!", null);
            }
            return new ApiResource(true,"success!", $data);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}