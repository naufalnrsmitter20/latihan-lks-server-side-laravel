<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class IndustryController extends Controller
{
    public function index()
    {
        try {
            $industry = Industry::all();
            if(!$industry){
                return new ApiResource(false, "industry not found", null);
            }
            return new ApiResource(true, "industry payload", $industry);
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
                "industry_name" => "required|string",
                "industry_desc" => "required|string",
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            $industry = Industry::create([
                "industry_name" => $request->industry_name,
                "industry_desc" => $request->industry_desc,
            ]);
            return new ApiResource(true, "Success to create industry!", $industry);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $industry = Industry::find($id);
            if(!$industry){
                return new ApiResource(false, "industry not found", null);
            }
            return new ApiResource(true, "industry by id payload", $industry);
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
                "industry_name" => "required|string",
                "industry_desc" => "required|string",
            ]);

            if($validator->fails()){
                return new ApiResource( false, $validator->errors(), null);
            }
            $industry = Industry::find($id)->update([
               "industry_name" => $request->industry_name,
                "industry_desc" => $request->industry_desc,
            ]);
            return new ApiResource(true, "Success to update industry!", $industry);
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
            $industrypayload = Industry::find($id);
            if(!$industrypayload){
                return new ApiResource(false, "industry not found", null);
            }
            Industry::destroy($id);
            return new ApiResource(true, "success to delete industry", []);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}