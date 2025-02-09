<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageScores extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    public function sorted($slug)
    {
        try {
            $game = Game::where("slug", $slug)->first();

            $score = Score::where("game_id", $game->id)
                ->with("player")
                ->select(["player_id", DB::raw("MAX(score) as score")])
                ->groupBy("player_id")
                ->get();
            return response()->json([
                "status" => "success",
                "data" => $score->map(function ($item) {
                    return [
                        "username" => $item->player->username,
                        "score" => $item->score,
                        "timestamp" => $item->updated_at,
                    ];
                })
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    // ->orderBy("score", "desc")

    /**
     * Store a newly created resource in storage.
     */
    public function store($slug, Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "score" => "required|integer"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $game = Game::where("slug", $slug)->first();
            $user = auth()->guard("api")->user();
            if (!$user) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "user not found"
                ], 400);
            }

            $findValidGameUser = Game::where("user_id", $user->id)->exists();
            if (!$findValidGameUser) {
                return response()->json([
                    "status" => "forbidden",
                    "message" => "You is Not Administrator this game!"
                ], 403);
            }


            Game::find($game->id)->update([
                "scoreCount" => $game->scoreCount ? $game->scoreCount + $request->score : $request->score
            ]);
            $data = Score::create([
                "player_id" => $user->id,
                "game_id" => $game->id,
                "score" => $request->score,
            ]);
            if (!$data) {
                return response()->json([
                    "status" => "failed",
                    "message" => "failed to insert score!"
                ], 422);
            }
            return response()->json([
                "status" => "success",
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
