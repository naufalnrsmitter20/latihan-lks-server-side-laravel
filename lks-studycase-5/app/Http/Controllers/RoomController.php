<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    public function index()
    {
        try {
            return new ApiResource(true, "Room Payload", Room::all());
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
                "room_number" => "required|integer",
                "category_id" => "required|integer",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $data = Room::create([
                "room_number" => $request->room_number,
                "category_id" => $request->category_id,
            ]);
            $findcategory = Category::find($request->category_id);
            if (!$findcategory) {
                return new ApiResource(false, "Category Not Found", null);
            }
            if (!$data) {
                return new ApiResource(false, "Failed to create Room!", null);
            }
            return new ApiResource(true, "Success to create Room!", $data);
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
            $find = Room::find($id);
            if (!$find) {
                return new ApiResource(false, "Room Not Found", null);
            }
            return new ApiResource(true, "Room Payload", $find);
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
                "room_number" => "required|integer",
                "category_id" => "required|integer",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $findroom = Room::find($id);
            if (!$findroom) {
                return new ApiResource(false, "Room Not Found", null);
            }
            $findcategory = Category::find($request->category_id);
            if (!$findcategory) {
                return new ApiResource(false, "Category Not Found", null);
            }
            $data = Room::find($id)->update([
                "room_number" => $request->room_number,
                "category_id" => $request->category_id,
            ]);
            if (!$data) {
                return new ApiResource(false, "Failed to update Room!", null);
            }
            return new ApiResource(true, "Success to update Room!", $data);
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
            $find = Room::destroy($id);
            if (!$find) {
                return new ApiResource(false, "Room Not Found", null);
            }
            return new ApiResource(true, "Success to delete Room!", $find);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
