<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Vote;
use App\Models\Partai;
use App\Models\Kandidat;
use App\Models\Votetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateVote extends Controller
{
    public function index()
    {
        try {
            $data = Vote::with(["kota", "provinsi", "votetype", "partais", "partais.kandidats", "kandidats"])->get();
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
    public function get_type()
    {
        try {
            $data = Votetype::all();
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
    public function insert_voteType(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "type" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $data = Votetype::create([
                "type" => $request->type
            ]);
            return response()->json([
                "message" => "success",
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
                "kota_id" => "integer|nullable",
                "provinsi_id" => "integer|nullable",
                "votetype_id" => "integer|required",
                "status" => "string|nullable",
                "start_date" => "date|nullable",
                "end_date" => "date|nullable",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }

            $start_date = $request->date("start_date");
            $end_date = $request->date("end_date");

            $findVotetype = Votetype::find($request->votetype_id);
            if ($findVotetype->type === "PILPRES" && !$start_date && !$end_date) {
                return response()->json([
                    "message" => "Pemilihan dengan type PILPRES harus menyertakan waktu pemilihan!"
                ], 400);
            }
            if ($findVotetype->type !== "PILPRES" && !$request->kota_id && !$request->provinsi_id) {
                return response()->json([
                    "message" => "Pemilihan dengan type selain PILPRES harus menyertakan kota dan provinsi!"
                ], 400);
            }

            if ($request->start_date !== $request->end_date) {
                return response()->json([
                    "message" => "Pemilihan tidak boleh lebih dari 1 hari"
                ], 400);
            }

            $checkIsCurrentTime = Vote::whereBetween("start_date", [$start_date, $end_date])->orWhereBetween("end_date", [$start_date, $end_date])
                ->exists();
            if ($checkIsCurrentTime && $findVotetype->type === "PILPRES") {
                return response()->json([
                    "message" => "vote sudah ada pada waktu tersebut!",
                ], 400);
            }

            $minAge = 0;
            $tipePemilihan = "";

            $findCurrentPilpres = Votetype::with("vote")->whereHas("vote")->where("type", "PILPRES")->get()->filter(function ($qry) {
                return $qry->vote->status === "ACTIVE";
            })->first();

            if ($findVotetype->type === "PILPRES") {
                $tipePemilihan = "PILPRES";
                $minAge = 17;
            } else if ($findVotetype->type === "PILWANTAI" && $findCurrentPilpres) {
                $tipePemilihan = "PILWANTAI";
                $minAge = 15;
                $start_date = $findCurrentPilpres->vote->start_date;
                $end_date = $findCurrentPilpres->vote->end_date;
            } else if ($findVotetype->type === "PILKADA" && $findCurrentPilpres) {
                $tipePemilihan = "PILKADA";
                $minAge = 30;
                $start_date = $findCurrentPilpres->vote->start_date;
                $end_date = $findCurrentPilpres->vote->end_date;
            } else if (!$findCurrentPilpres) {
                return response()->json([
                    "message" => "aktifkan status PILPRES saat ini untuk menambahkan voting pemilihan DPR dan DPD!",
                ], 400);
            }


            $data = Vote::create([
                "kota_id" => $findVotetype->type !== "PILPRES" ? $request->kota_id : null,
                "provinsi_id" => $findVotetype->type !== "PILPRES" ? $request->provinsi_id : null,
                "votetype_id" => $request->votetype_id,
                "status" => $request->status ?? "NOTACTIVE",
                "min_age" => $minAge,
                "tipe_pemilihan" => $tipePemilihan,
                "start_date" => $tipePemilihan === "PILPRES" ? str_replace("00:00:00", "", $start_date) . Carbon::createFromTime(7, 0, 0)->format("H:i:s") : $start_date,
                "end_date" => $tipePemilihan === "PILPRES" ? str_replace("00:00:00", "", $end_date) . Carbon::createFromTime(12, 0, 0)->format("H:i:s") : $end_date,
            ]);
            return response()->json([
                "message" => "success",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function activate($id, Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "status" => "string|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $checkIdVote = Vote::find($id);
            if (!$checkIdVote) {
                return response()->json([
                    "message" => "vote id is not valid!"
                ], 400);
            }

            Vote::find($id)->update([
                "status" => $request->status
            ]);
            return response()->json([
                "message" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function upsert_candidates(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "kandidat_id" => "required|array",
                "kandidat_id.*" => "required|integer",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $checCurrentVote = Vote::find($id);
            if (!$checCurrentVote) {
                return response()->json([
                    "message" => "Invalid Vote id"
                ], 401);
            }

            $findVoteType = Votetype::find($checCurrentVote->votetype_id);

            if ($findVoteType->type === "PILWANTAI") {
                return response()->json([
                    "message" => "Voting dewan perwakilan rakyat harus melalui partai!"
                ], 401);
            }

            $checkKandidat = Kandidat::whereIn("id", $request->kandidat_id)->exists();
            $getKandidatById = Kandidat::whereIn("id", $request->kandidat_id)->get();
            if (!$checkKandidat) {
                return response()->json([
                    "message" => "id kandidat tidak valid!"
                ], 401);
            }

            foreach ($getKandidatById as $candidate) {
                if ($findVoteType->type === "PILPRES" && $candidate->role !== "PRESIDEN") {
                    return response()->json([
                        "message" => "Kandidat Pilpres harus kandidat dengan role presiden!"
                    ], 400);
                }
                if ($findVoteType->type === "PILKADA" && $candidate->role !== "DPR") {
                    return response()->json([
                        "message" => "Kandidat Pemilihan dewan perwakilan rakyat dan daearah harus kandidat dengan role presiden!"
                    ], 400);
                }
                Kandidat::where("id", $candidate->id)->update([
                    "vote_id" => $id
                ]);
            }
            Kandidat::where("vote_id", $id)
                ->whereNotIn("id", $request->kandidat_id)
                ->update([
                    "vote_id" => null
                ]);
            return response()->json([
                "message" => "success",
                "data" => [
                    "vote" => Vote::find($id),
                    "kandidat" => $getKandidatById
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }

    public function upsert_partai(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "partai_id" => "required|array",
                "partai_id.*" => "required|integer",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }

            $checCurrentVote = Vote::find($id);
            if (!$checCurrentVote) {
                return response()->json([
                    "message" => "Invalid Vote id"
                ], 401);
            }

            $findVoteType = Votetype::find($checCurrentVote->votetype_id);

            if ($findVoteType->type === "PILKADA" && $findVoteType->type === "PILPRES") {
                return response()->json([
                    "message" => "Voting pilpres dewan perwakilan daerah tidak perlu melalui partai!"
                ], 401);
            }
            $checkPartai = Partai::whereIn("id", $request->partai_id)->exists();
            $getPartaiById = Partai::with("kandidats")->whereIn("id", $request->partai_id)->get();
            if (!$checkPartai) {
                return response()->json([
                    "message" => "id partai tidak valid!"
                ], 401);
            }
            foreach ($getPartaiById as $partai) {
                $partai->update(['vote_id' => $id]);
                $partai->kandidats()->update(['vote_id' => $id]); // Update kandidat terkait
            }

            Partai::where("vote_id", $id)->whereNotIn("id", $request->partai_id)->update([
                "vote_id" => null
            ]);

            return response()->json([
                "message" => "success",
                "data" => [
                    "vote" => Vote::find($id),
                    "partai" => $getPartaiById
                ],
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
            $checCurrentVote = Vote::find($id);
            if (!$checCurrentVote) {
                return response()->json([
                    "message" => "Invalid Vote id"
                ], 401);
            }
            Vote::destroy($id);
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
