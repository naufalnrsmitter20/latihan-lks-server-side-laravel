<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Partai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManagePartai extends Controller
{
    public function index()
    {
        try {
            $data = Partai::with("kandidats")->get();
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show($id)
    {
        try {
            $data = Partai::with(["kandidats", "kandidats.uservote"])->find($id);
            return response()->json([
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "nama_partai" => "string|required",
                "no_urut" => "integer|required",
                "logo" => "image|required|mimes:png,jpg,svg,jpeg",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $file = $request->file("logo");
            $imagePath = str_replace(":", "_", now()->format("H:i:s") . "_" . $file->getClientOriginalName());
            $file->move(public_path("image/"),  $imagePath);
            $data = Partai::create([
                "nama_partai" => $request->nama_partai,
                "no_urut" => $request->no_urut,
                "logo" => "image/" .  $imagePath,
            ]);
            return response()->json([
                "message" => "success",
                "data" => ["Partai" => $data]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "kandidat_id.*" => "integer",
                "kandidat_id" => "required|array"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $findPartai = Partai::find($id);
            $findCandidates = Kandidat::whereIn("id", $request->kandidat_id)->exists();
            $getAllKandidat = Kandidat::whereIn("id", $request->kandidat_id)->get();
            if (!$findCandidates) {
                return response()->json([
                    // "message" => "invalid",
                    "message" => "invalid id of candidates"
                ], 404);
            }
            $getLengthCandidate = $getAllKandidat->count();
            foreach ($getAllKandidat as $idx) {
                $verifyPresident = $idx->role === "PRESIDEN";
                $verifyDPR = $idx->role === "DPR";
                $verifyDPD = $idx->role === "DPD";
                if ($verifyPresident && $getLengthCandidate > 1) {
                    return response()->json([
                        "data" => "invalid",
                        "message" => "presiden hanya boleh memiliki 1 partai"
                    ], 400);
                } else if ($verifyDPR && $getLengthCandidate > 5) {
                    return response()->json([
                        "data" => "invalid",
                        "message" => "partai tidak boleh memiliki lebih dari 5 DPR"
                    ], 400);
                } else if ($verifyDPD && $getLengthCandidate > 5) {
                    return response()->json([
                        "data" => "invalid",
                        "message" => "partai tidak boleh memiliki lebih dari 5 DPD"
                    ], 400);
                }
            }
            Kandidat::whereIn("id", $request->kandidat_id)->update([
                "partai_id" => $id
            ]);
            Kandidat::where("partai_id", $id)
                ->whereNotIn("id", $request->kandidat_id)
                ->update([
                    "partai_id" => null
                ]);
            return response()->json([
                "message" => "success",
                "data" => ["Partai" => $findPartai, "candidates" => $getAllKandidat]
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
            $findCandidate = Partai::find($id);
            if (!$findCandidate) {
                return response()->json([
                    "message" => "invalid id Partai",
                ], 400);
            }
            Partai::destroy($id);
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
