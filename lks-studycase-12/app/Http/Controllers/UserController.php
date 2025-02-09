<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\User;
use App\Models\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index1()
    {
        try {
            $data = User::with("validators")->get();
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
    public function index2()
    {
        try {
            $data = Society::with("regional")->get();
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
    public function store1(Request $request)
    {
        try {
            $data = User::create([
                "username" => $request->username,
                "password" => bcrypt($request->password),
            ]);
            if ($data) {
                Validator::create([
                    "user_id" => $data->id,
                    "role" => $request->role,
                    "name" => $data->username
                ]);
                return response()->json([
                    "message" => "success"
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function store2(Request $request)
    {
        try {
            $data = Society::create([
                "id_card_number" => $request->id_card_number,
                "password" => md5($request->password),
                "name" => $request->name,
                "born_date" => $request->born_date,
                "gender" => $request->gender,
                "address" => $request->address,
                "regional_id" => $request->regional_id,
            ]);
            if ($data) {
                return response()->json([
                    "message" => "success"
                ], 200);
            }
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
    public function destroy1(string $id)
    {
        try {
            $find = User::find($id);
            if (!$find) {
                return response()->json([
                    "message" => "not found"
                ], 404);
            }
            User::destroy($id);
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
