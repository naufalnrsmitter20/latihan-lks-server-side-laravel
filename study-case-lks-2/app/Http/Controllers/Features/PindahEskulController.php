<?php

namespace App\Http\Controllers\Features;

use App\Models\User;
use App\Models\Eskul;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PindahEskulController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "user_id" => "required",
                "current_eskul_id" => "required",
                "eskul_id" => "required",
            ]);
            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $userId = $request->user_id;
            $eskulId = $request->eskul_id;
            $current_eskulId = $request->current_eskul_id;
            $user = User::find($userId);
            if(!$user){
                return new ApiResource(false, "user not found", null);
            }
            $eskulid = Eskul::find($eskulId);
            if(!$eskulid){
                return new ApiResource(false, "eskul not found", resource: null);
            }
            $currEskulid = Eskul::find($current_eskulId);
            if(!$currEskulid){
                return new ApiResource(false, "current eskul not found", null);
            }
            // $eskuls = Eskul::whereIn("id", $eskulId)->get();
            // foreach ($eskuls as $eskul) {
            //     if($eskul->status === "CLOSE"){
            //         return new ApiResource(false, "Pendaftaran Ditutup", null);
            //     }
            // }
            $exitingsIdEskul = collect($user->eskul()->select("eskuls.id")->get())->whereIn("id", $eskulId);
            if(count($exitingsIdEskul) !== 0){
                return new ApiResource(false, "Siswa sudah terdaftar di eskul ini!", null);
            }
            $findEskulInUser = collect($user->eskul()->select("eskuls.id")->get())->whereIn("id", $current_eskulId);
            if(!$findEskulInUser){
                return new ApiResource(false, "Siswa tidak mengikuti eskul dengan id " . $current_eskulId, null);
            }
            $deletecurrent = $user->eskul()->detach($current_eskulId);
            $addincoming = $user->eskul()->attach($eskulId);
            if(!$deletecurrent && !$addincoming){
                return new ApiResource(false, "Gagal mengubah eskul", null);
            }
            return new ApiResource(true, "Sukses mengubah eskul", $user->eskul()->get());
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}