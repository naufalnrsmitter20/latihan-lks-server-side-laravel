<?php

namespace App\Http\Controllers\Features;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Eskul;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DaftarEskulController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
       try {
        $validator = Validator::make($request->all(), [
            "user_id" => "required",
            "eskul_id" => "required|max:3|exists:eskuls,id",
            "eskul_id.*" => "integer|exists:eskuls,id"
        ]);
        if($validator->fails()){
            return new ApiResource(false, $validator->errors(), null);
        }
        if($request->user_id !== auth()->guard("api")->user()->id){
            return new ApiResource(false, "Anda tidak diizinkan mendaftarkan orang lain ke dalam eskul!", null);
        }

        $user = User::find($request->user_id);
        $eskuls = Eskul::whereIn("id", $request->eskul_id)->get();

        if(!$user){
            return new ApiResource(false, "User tidak ditemukan", null);
        }
        
        foreach ($eskuls as $eskul) {
            if($eskul->status === "CLOSE"){
                return new ApiResource(false, "Pendaftaran Ditutup", null);
            }
        }
        $existingEskulCount = $user->eskul()->count();
        if($existingEskulCount + count($request->eskul_id) > 3){
            return new ApiResource(false, "Anda hanya bisa mendaftarkan maksimal 3 ekskul!", null);
        } 
        $exitingsIdEskul = collect($user->eskul()->select("eskuls.id")->get())->whereIn("id", $request->eskul_id);
        if(count($exitingsIdEskul) !== 0){
            return new ApiResource(false, "Anda sudah terdaftar di eskul ini!", null);
        }
        
        $user->eskul()->attach($request->eskul_id);

        return new ApiResource(true, "Success to register eskul!",  [
            "user" => $user,
            "eskul yang diiuti" => $user->eskul()->get(),
        ] );
       } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => $e->getMessage()
        ], 500);
       }
    }
}