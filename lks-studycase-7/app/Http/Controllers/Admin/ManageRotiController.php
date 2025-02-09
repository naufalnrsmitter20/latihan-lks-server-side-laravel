<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roti;
use Illuminate\Http\Request;

class ManageRotiController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                "status" => true,
                "data" => Roti::all()
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
            $validated = $request->validate([
                "name" => "string|required",
                "qty" => "integer|required",
                "price" => "required"
            ]);
            $data = Roti::create($validated);
            return response()->json([
                "status" => true,
                "message" => "sukses menambahkan roti",
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
            if (!Roti::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "roti not found"
                ], 404);
            }
            return response()->json([
                "status" => true,
                "data" => Roti::find($id)
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
                "name" => "string",
                "qty" => "integer",
                "price" => "integer"
            ]);
            if (!Roti::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "roti not found"
                ], 404);
            }
            $data = Roti::find($id)->update($validated);
            return response()->json([
                "status" => true,
                "message" => "sukses mengupdate roti",
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
            if (!Roti::find($id)) {
                return response()->json([
                    "status" => false,
                    "message" => "roti not found"
                ], 404);
            }
            $data = Roti::destroy($id);
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
