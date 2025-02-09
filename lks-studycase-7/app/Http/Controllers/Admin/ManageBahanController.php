<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\LogSupply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageBahanController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                "status" => true,
                "data" => Bahan::all()
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = Validator::make($request->all(), [
                "name" => "string|required",
                "qty" => "integer|required",
                "price" => "integer|required",
            ]);

            if ($validated->fails()) {
                return response()->json([
                    "status" => true,
                    "message" => $validated->errors(),
                ], 403);
            }

            $data = Bahan::create([
                "name" => $request->name,
                "qty" => $request->qty,
                "price" => $request->price,
            ]);

            return response()->json([
                "status" => true,
                "message" => "sukses menambahkan bahan",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            if (!Bahan::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "bahan not found"
                ], 404);
            }
            return response()->json([
                "status" => true,
                "data" => Bahan::find($id)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validated = $request->validate([
                "name" => "string|required",
                "qty" => "integer|required",
                "price" => "integer|required",
            ]);
            if (!Bahan::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "bahan not found"
                ], 404);
            }
            $data = Bahan::find($id)->update($validated);
            return response()->json([
                "status" => true,
                "message" => "sukses mengupdate bahan",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (!Bahan::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "bahan not found"
                ], 404);
            }
            $data = Bahan::destroy($id);
            return response()->json([
                "status" => true,
                "message" => "sukses menghapus data!"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
