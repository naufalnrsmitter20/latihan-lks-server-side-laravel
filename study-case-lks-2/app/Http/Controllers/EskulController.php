<?php

namespace App\Http\Controllers;

use App\Models\Eskul;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class EskulController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
           $eskul = Eskul::all();
           if(!$eskul){
            return new ApiResource(false, "Eskul not found", null);
        }
        return new ApiResource(true, "Eskul Payload", $eskul);
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
            $validator = Validator::make($request->all(), [
                "name" => "required|string",
                "desc" => "required|string",
                "status" => "required|string",
                "user_id" => "integer",
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }

           $eskul = Eskul::create([
            "name" => $request->name,
            "desc" => $request->desc,
            "status" => $request->status,
           ]);

           return new ApiResource(true, "Success to create Eskul!", $eskul);
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
            $eskul = Eskul::find($id);
            if(!$eskul){
                return new ApiResource(false, "Eskul not found", null);
            }
                return new ApiResource(true, "Eskul by id Payload", $eskul);
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
            $validator = Validator::make($request->all(), [
                  "name" => "required|string",
                "desc" => "required|string",
                "status" => "required|string",
                "user_id" => "integer",
            ]);

            if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
            }
            
            $checkIdEskul = Eskul::find($id);
            
            if(!$checkIdEskul){
                return new ApiResource(false, "Eskul not found, please check valid id Eskul!", null);
            }

           $eskul = Eskul::find($id)->update([
            "name" => $request->name,
            "desc" => $request->desc,
            "status" => $request->status,
           ]);

           return new ApiResource($eskul, "Success to update Eskul!", [
            "name" => $request->name,
            "desc" => $request->desc,
            "status" => $request->status,
           ]);
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
            $checkIdEskul = Eskul::find($id);
            
            if(!$checkIdEskul){
                return new ApiResource(false, "Eskul not found, please check valid id Eskul!", null);
            }
            $eskul = Eskul::destroy($id);
            if(!$eskul){
                return new ApiResource(false, "Failed to delete Eskul", null);
            }
                return new ApiResource(true, "success to delete Eskul!", []);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}