<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Prakerin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RiwayatPengajuanController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "user_id" => "required",
            ]);
            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $user_payload = auth()->guard("api")->user();
            $checkId = $user_payload->id === $request->user_id;
            if(!$checkId){
                return new ApiResource(false, "User id is not same as token.user_id", null);
            }
            $pengajuan = User::with("prakerins")->find($request->user_id);
            return new ApiResource(false, "Success", $pengajuan);

        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}