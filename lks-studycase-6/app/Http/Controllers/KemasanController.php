<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Kemasan;

class KemasanController extends Controller
{
    public function index()
    {
        try {
            return new ApiResource(true, "kemasan payload", Kemasan::all());
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
            $data = Kemasan::create(attributes: [
                "name" => $request->name,
                "stock" => $request->stock,
                "price" => $request->price
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to create kemasan", null);
            }
            return new ApiResource(true, "success to create kemasan", $data);
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
            $data = Kemasan::find($id);
            if (!$data) {
                return new ApiResource(false, "kemasan not found", null);
            }
            return new ApiResource(true, "kemasan payload", $data);
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
            $kemasan = Kemasan::find($id);
            if (!$kemasan) {
                return new ApiResource(false, "kemasan not found", null);
            }
            $data = Kemasan::find($id)->update([
                "name" => $request->name,
                "stock" => $request->stock,
                "price" => $request->price
            ]);
            if (!$data) {
                return new ApiResource(false, "failed to update kemasan", null);
            }
            return new ApiResource(true, "success to update kemasan", $data);
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
            $kemasan = Kemasan::find($id);
            if (!$kemasan) {
                return new ApiResource(false, "kemasan not found", null);
            }
            $data = Kemasan::destroy($id);
            return new ApiResource(true, "success to delete kemasan", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
