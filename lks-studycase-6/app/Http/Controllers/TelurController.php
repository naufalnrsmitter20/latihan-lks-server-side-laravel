<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Telur;

class TelurController extends Controller
{
    public function index()
    {
        try {
            return new ApiResource(true, "telur payload", Telur::all());
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
            $data = Telur::create(attributes: [
                "name" => $request->name,
                "stock" => $request->stock,
                "price" => $request->price
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to create telur", null);
            }
            return new ApiResource(true, "success to create telur", $data);
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
            $data = Telur::find($id);
            if (!$data) {
                return new ApiResource(false, "telur not found", null);
            }
            return new ApiResource(true, "telur payload", $data);
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
            $telur = Telur::find($id);
            if (!$telur) {
                return new ApiResource(false, "telur not found", null);
            }
            $data = Telur::find($id)->update([
                "name" => $request->name,
                "stock" => $request->stock,
                "price" => $request->price
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to update telur", null);
            }
            return new ApiResource(true, "success to update telur", $data);
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
            $telur = Telur::find($id);
            if (!$telur) {
                return new ApiResource(false, "telur not found", null);
            }
            $data = Telur::destroy($id);
            return new ApiResource(true, "success to delete telur", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
