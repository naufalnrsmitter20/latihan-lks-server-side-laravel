<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Industry;
use App\Models\Prakerin;
use App\Models\PrakerinPeriod;
use Illuminate\Support\Facades\Validator;

class RequestPrakerinPlace extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "user_id" => "required",
                "industry_id" => "required",
                "prakerin_period_id" => "required"
            ]);
            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $checkPrakerinPeriodStatus = PrakerinPeriod::find($request->prakerin_period_id);
            if($checkPrakerinPeriodStatus->period_status === "INACTIVE"){
                return new ApiResource(false, "Periode Prakerin Tidak Aktif!", null);
            }
            $current_user_payload = auth()->guard("api")->user();
            $userId = $current_user_payload->id;
            $checkUserId = $userId === $request->user_id;
            if(!$checkUserId){
                return new ApiResource(false, "User id is not same as token.user_id", null);
            }
            $userbyprakerin = Prakerin::where("user_id", $request->user_id)->exists();
            if($userbyprakerin){
                $a = Prakerin::where("user_id", $request->user_id)->latest()->firstOr(function($item){
                    return $item;
                });
                if($a->status === "MENUNGGU"){
                    return new ApiResource(false, "Anda tidak bisa request lagi saat status nya menunggu", null);
                }
                if($a->status === "DITERIMA"){
                    return new ApiResource(false, "Anda tidak bisa request lagi saat status nya diterima", null);
                }
                if($a->status === "DITOLAK"){
                    $prakerin = Prakerin::create([
                        "user_id" => $request->user_id,
                        "industry_id" => $request->industry_id,
                        "prakerin_period_id" => $request->prakerin_period_id,
                        "status" => "MENUNGGU"
                    ]);
                if(!$prakerin){
                    return new ApiResource(false, "Failed to create request!", null);
                }
                return new ApiResource(false, "Success to create request!", $prakerin);
                }
            } else if (!$userbyprakerin){
                $prakerin = Prakerin::create([
                        "user_id" => $request->user_id,
                        "industry_id" => $request->industry_id,
                        "prakerin_period_id" => $request->prakerin_period_id,
                        "status" => "MENUNGGU"
                    ]);
                if(!$prakerin){
                    return new ApiResource(false, "Failed to create request!", null);
                }
                return new ApiResource(false, "Success to create request!", $prakerin);
            }

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}