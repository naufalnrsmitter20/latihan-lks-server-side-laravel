<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    public function index()
    {
        try {
            $data = Place::all();
            return response()->json(["status" => true, "message" => "success", "data" => $data], 200);
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
            $validate = Validator::make(request()->all(), [
                "name" => "string|required",
                "latitude" => "required",
                "longitude" => "required",
                "description" => "required|string",
                "image_path" => "required|image|mimes:png,jpg,svg,jpeg",
            ]);


            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors()->first(), "data" =>  null], 403);
            }

            $image_name = time() . "." . $request->image_path->extension();
            $request->image_path->move(public_path("images"), $image_name);

            $data = Place::create([
                "name" => $request->name,
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
                "description" => $request->description,
                "image_path" => "images/" . $image_name,
            ]);
            if (!$data) {
                return response()->json([
                    "status" => false,
                    "message" => "Data cannot be processed"
                ], 422);
            }

            return response()->json(["status" => 200, "message" => "create success", "data" => $data], 200);
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
            $data = Place::find($id);
            if (!$data) {
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }
            return response()->json(["status" => true, "message" => "success", "data" => $data], 200);
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
            $validate = Validator::make(request()->all(), [
                "name" => "string|required",
                "latitude" => "required",
                "image_path" => "nullable|image|mimes:png,jpg,jpeg,svg",
                "longitude" => "required",
                "description" => "required|string",
            ]);

            if ($validate->fails()) {
                return response()->json(["status" => false, "message" => $validate->errors()->first(), "data" =>  null], 403);
            }

            $finduser = Place::find($id);
            if (!$finduser) {
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }
            if ($request->hasFile("image_path")) {
                $image_name = time() . "." . $request->image_path->extension();
                $request->image_path->move(public_path("images"), $image_name);
            }

            Place::find($id)->update([
                "name" => $request->name,
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
                "description" => $request->description,
                "image_path" => "images/" . $image_name,
            ]);

            return response()->json(["status" => true, "data" => [
                "name" => $request->name,
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
                "description" => $request->description,
                "image_path" => $request->image_path,
            ], "message" => "update success"], 200);
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

            $finduser = Place::find($id);
            if (!$finduser) {
                return response()->json(["status" => false, "message" => "not found", "data" => null], 404);
            }
            $del = Place::destroy($id);
            if (!$del) {
                return response()->json(["status" => false, "message" => "data cannot be deleted"], 400);
            }
            return response()->json(["status" => true, "message" => "delete success", "data" => $del], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
