<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use Illuminate\Support\Facades\Validator;

class RuangController extends Controller
{
    public function index()
    {
        try {
            return new ApiResource(true, "ruang payload", Ruang::all());
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
            "nama_ruang" => "required|string",
           ]);
           if($validator->fails()){
            return new ApiResource(false, $validator->errors(), null);
           }
           $data = Ruang::create([
            "nama_ruang" => $request->nama_ruang,
           ]);
           return new ApiResource(true, "ruang payload", $data);

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
            $data = Ruang::find($id);
            if(!$data){
                return new ApiResource(false, "ruang not found", null);
            }
            return new ApiResource(true, "ruang payload", $data);
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
                "nama_ruang" => "required|string",
               ]);
               if($validator->fails()){
                return new ApiResource(false, $validator->errors(), null);
               }
               $data = Ruang::find($id)->update([
                "nama_ruang" => $request->nama_ruang,
               ]);
               return new ApiResource(true, "ruang payload", $data);
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
            $data = Ruang::find($id);
            if(!$data){
                return new ApiResource(false, "ruang not found", null);
            }
             Ruang::destroy($id);
            return new ApiResource(true, "Success to delete", null);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}