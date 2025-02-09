<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageCandidates extends Controller
{
    public function index()
    {
        try {
            $data = Kandidat::with("partai")->get();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "nama_kandidat" => "string|required",
                "no_urut" => "integer|required",
                "image" => "required|image|mimes:png,jpg,svg,jpeg",
                "role" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $file = $request->file("image");
            $imagePath = str_replace(":", "_", now()->format("H:i:s") . "_" . $file->getClientOriginalName());
            $file->move(public_path("image/"),  $imagePath);
            $data = Kandidat::create([
                "nama_kandidat" => $request->nama_kandidat,
                "no_urut" => $request->no_urut,
                "role" => $request->role,
                "image" => "image/" . $imagePath,
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $findCandidate = Kandidat::find($id);
            if (!$findCandidate) {
                return response()->json([
                    "message" => "invalid id kandidat",
                ], 400);
            }
            Kandidat::destroy($id);
            return response()->json([
                "message" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
