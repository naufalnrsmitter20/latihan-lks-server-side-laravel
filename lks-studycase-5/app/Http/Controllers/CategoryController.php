<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            return new ApiResource(true, "Category Payload", Category::all());
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $data = Category::create([
                "name" => $request->name,
            ]);
            if (!$data) {
                return new ApiResource(false, "Failed to create Category!", null);
            }
            return new ApiResource(true, "Success to create Category!", $data);
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
            $find = Category::find($id);
            if (!$find) {
                return new ApiResource(false, "Category Not Found", null);
            }
            return new ApiResource(true, "Category Payload", $find);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, string $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $findCategory = Category::find($id);
            if (!$findCategory) {
                return new ApiResource(false, "Category Not Found", null);
            }
            $data = Category::find($id)->update([
                "name" => $request->name,
            ]);
            if (!$data) {
                return new ApiResource(false, "Failed to update Category!", null);
            }
            return new ApiResource(true, "Success to update Category!", $data);
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
            $find = Category::destroy($id);
            if (!$find) {
                return new ApiResource(false, "Category Not Found", null);
            }
            return new ApiResource(true, "Success to delete Category!", $find);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
