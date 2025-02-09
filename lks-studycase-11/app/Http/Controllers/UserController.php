<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use App\Models\Regional;
use App\Models\Society;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $dataUser = User::all();
            $dataSociety = Society::all();

            return response()->json([
                "data" => [
                    "user" => $dataUser,
                    "society" => $dataSociety
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUser(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "username" => "string|required|unique:users,username",
                "password" => "string|required"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            User::create([
                "username" => $request->username,
                "password" => md5($request->password),
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
    public function storeSociety(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "name" => "string|required",
                "password" => "string|required",
                "id_card_number" => "string|required|unique:societies,id_card_number",
                "born_date" => "date|required",
                "gender" => "string|required",
                "address" => "string|required",
                "regional_id" => "integer|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $checkRegional = Regional::find($request->regional_id);
            if (!$checkRegional) {
                return response()->json([
                    "message" => "regional not found"
                ], 404);
            }
            Society::create([
                "name" => $request->name,
                "password" => md5($request->password),
                "id_card_number" => $request->id_card_number,
                "born_date" => $request->born_date,
                "gender" => $request->gender,
                "address" => $request->address,
                "regional_id" => $request->regional_id,
            ]);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function updateUser(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "username" => "string",
                "password" => "string"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            User::find($id)->update([
                "username" => $request->username,
                "password" => md5($request->password),
            ]);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function updateSociety(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "name" => "string",
                "password" => "string",
                "id_card_number" => "string|unique:societies,id_card_number",
                "born_date" => "date",
                "gender" => "string",
                "address" => "string",
                "regional_id" => "integer",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 403);
            }
            $checkRegional = Regional::find($request->regional_id);
            if (!$checkRegional) {
                return response()->json([
                    "message" => "regional not found"
                ], 404);
            }
            Society::find($id)->update([
                "name" => $request->username,
                "password" => md5($request->password),
                "id_card_number" => $request->id_card_number,
                "born_date" => $request->born_date,
                "gender" => $request->gender,
                "address" => $request->address,
                "regional_id" => $request->regional_id,
            ]);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyUser(string $id)
    {
        try {
            User::destroy($id);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function destroySociety(string $id)
    {
        try {
            Society::destroy($id);
            return response()->json([
                "message" => "success"
            ], status: 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
