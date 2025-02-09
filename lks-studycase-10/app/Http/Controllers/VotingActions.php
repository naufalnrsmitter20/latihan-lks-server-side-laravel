<?php

namespace App\Http\Controllers;

use App\Models\Biodata;
use App\Models\Kandidat;
use App\Models\Partai;
use App\Models\User;
use App\Models\UserVote;
use App\Models\Vote;
use App\Models\Votetype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VotingActions extends Controller
{
    public function index($id)
    {
        try {
            $defaultData = Vote::all();
            $findVoteType = Vote::find($id);
            if (!$findVoteType) {
                return response()->json([
                    "data" => $defaultData
                ], 200);
            }
            if ($findVoteType->tipe_pemilihan === "PILWANTAI") {
                $vote = Vote::with(["partais", "partais.kandidats", "partais.kandidats.uservote", "votetype", "kota", "provinsi"])->where("id", $id)->first();
                return response()->json([
                    "data" => $vote
                ], 200);
            }
            if ($findVoteType->tipe_pemilihan === "PILKADA") {
                $vote = Vote::with(["kandidats", "kandidats.uservote", "votetype", "kota", "provinsi"])->where("id", $id)->first();
                return response()->json([
                    "data" => $vote
                ], 200);
            }
            if ($findVoteType->tipe_pemilihan === "PILPRES") {
                $vote = Vote::with(["kandidats", "kandidats.uservote", "votetype"])->where("id", $id)->first();
                return response()->json([
                    "data" => $vote
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
    public function voting(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "kandidat_id" => "integer|required",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $checCurrentVote = Vote::find($id);
            if ($checCurrentVote->status === "NOTACTIVE") {
                return response()->json([
                    "message" => "Voting Belum Diaaktifkan, Hubungi Admin!"
                ], 400);
            }
            if (!$checCurrentVote) {
                return response()->json([
                    "message" => "Invalid Vote id"
                ], 401);
            }
            $user = auth()->guard("api")->user();
            if (!$user) {
                return response()->json([
                    "message" => "unauthorize"
                ], 403);
            }
            $checkBiodataUser = User::whereHas("biodata")->exists();
            if (!$checkBiodataUser) {
                return response()->json([
                    "message" => "anda belum melengkapi biodata!"
                ], 400);
            }

            // $checkCandidateExist = Vote::whereHas("kandidats", function ($qry) use ($request) {
            //     $qry->kandidats->where("id", $request->kandidat_id);
            // })->get();
            $checkCandidateExist = Kandidat::where("vote_id", $id)->get();
            if (!$checkCandidateExist) {
                return response()->json([
                    "message" => "Kandidat Tidak Tersedia Pada Vote Ini!!"
                ], 400);
            }

            $findUserVote = UserVote::where("user_id", $user->id)
                ->where("vote_id", $id)->exists();
            if ($findUserVote) {
                return response()->json([
                    "message" => "anda hanya bisa vote 1 kali!"
                ], 400);
            }


            // $findVoteUser = User::where("id", $user->id)
            //     ->whereHas("userVote")->exists();

            // if ($findVoteUser) {
            //     return response()->json([
            //         "message" => "anda hanya bisa vote 1 kali!"
            //     ], 400);
            // }

            $findBiodataUser = User::with("biodata")->where("id", $user->id)->first();
            $findVoteByType = Vote::with("voteType")->where("id", $id)->first();
            if ($findVoteByType->voteType->type !== "PILPRES" && $findBiodataUser->biodata->provinsi_id !== $findVoteByType->provinsi_id && $findBiodataUser->biodata->kota_id !== $findVoteByType->kota_id) {
                return response()->json([
                    "message" => "Anda hanya diperbolehkan melakukan voting pada provinsi dan kota anda!"
                ], 400);
            }
            if ($findBiodataUser->biodata->age < $checCurrentVote->min_age) {
                return response()->json([
                    "message" => "anda tidak cukup umur untuk melakukan voting!"
                ], 400);
            }
            $data = UserVote::create([
                "user_id" => $user->id,
                "vote_id" => (int)$id,
                "kandidat_id" => $request->kandidat_id
            ]);
            if (!$data) {
                return response()->json([
                    "message" => "data cannot processed"
                ], 400);
            }
            return response()->json([
                "message" => "success to vote",
                "data" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "line" => $e->getLine(),
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
