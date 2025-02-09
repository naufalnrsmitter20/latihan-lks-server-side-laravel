<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use App\Models\Spot;
use App\Models\User;
use Illuminate\Http\Request;

class MedicalController extends Controller
{
    public function index()
    {
        try {
            $data = Medical::with(["spot", "user"])->get();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $fidnSpot = Spot::find($request->spot_id);
            if (!$fidnSpot) {
                return response()->json([
                    "message" => "spot not found"
                ], 404);
            }
            $findUser = User::find($id);
            Medical::create([
                "name" => $findUser->username,
                "role" => $request->role,
                "user_id" => $id,
                "spot_id" => $request->spot_id
            ]);
            return response()->json([
                "message" => "success"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}