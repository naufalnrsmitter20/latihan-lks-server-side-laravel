<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $page = $request->input("page", 0) ?? 0;
            $size = $request->input("size") ?? 10;
            $sortBy = $request->input("sortBy") ?? "title";
            $sortDir = $request->input("sortDir") ?? "asc";
            $data = Game::orderBy($sortBy, $sortDir)->paginate($size, ["*"], "page", $page + 1)->map(function ($item) {
                return [
                    "slug" => $item->slug,
                    "title" => $item->title,
                    "description" => $item->description,
                    // "thumbnail" => $item->thumbnail,
                    "uploadTimeStamp" => $item->updated_at,
                    "author" => $item->author,
                    "scoreCount" => $item->scoreCount,
                ];
            });
            return response()->json([
                "status" => "success",
                "slug" => [
                    "page" => $page,
                    "size" => $size,
                    "totalElements" => Game::all()->count(),
                    "content" => $data
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "title" => "required|min:3|max:60",
                "description" => "required|min:0|max:200"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $getUser = auth()->guard("api")->user();
            if (!$getUser) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "user not found"
                ], 401);
            }

            $gameSlug = str::slug($request->title);
            $exixtingSlug = Game::where("slug", $gameSlug)->exists();
            if ($exixtingSlug) {
                return response()->json([
                    "status" => "invalid",
                    "slug" => "Game title already exists"
                ], 400);
            }
            $game = Game::create([
                "title" => $request->title,
                "description" => $request->description,
                "slug" => $gameSlug,
                "user_id" => $getUser->id,
                "author" => $getUser->username
            ]);
            if (!$game) {
                return response()->json([
                    "status" => "failed",
                    "slug" => "create failed"
                ], 422);
            }
            return response()->json([
                "status" => "success",
                "slug" => $gameSlug
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        try {
            $data = Game::where("slug", $slug)->first();
            if (!$data) {
                return response()->json([
                    "status" => "not-found",
                    "slug" => "game not found"
                ], 404);
            }
            $gamePath = "/games" . $data->slug . "/" . $data->id . "/";
            return response()->json([
                "slug" => $data->slug,
                "title" => $data->title,
                "description" => $data->description,
                "uploadTimeStamp" => $data->updated_at,
                "author" => $data->author,
                "scoreCount" => $data->scoreCount,
                "thumbnail" => $data->thumbnail,
                "gamePath" => $gamePath
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    public function update($slug, Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "title" => "required|min:3|max:60",
                "description" => "required|min:0|max:200"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $getUser = auth()->guard("api")->user();
            if (!$getUser) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "user not found"
                ], 401);
            }
            $getGame = Game::where("slug", $slug)->first();
            if ($getGame->user_id != $getUser->id) {
                return response()->json([
                    "status" => "forbidden",
                    "message" => "You are not the game author"
                ], 403);
            }
            $data = Game::find($getGame->id)->update([
                "title" => $request->title,
                "description" => $request->description,
            ]);
            if (!$data) {
                return response()->json([
                    "status" => "failed",
                    "message" => "failed to update"
                ], 422);
            }
            return response()->json([
                "status" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    public function destroy($slug)
    {
        try {
            $getUser = auth()->guard("api")->user();
            if (!$getUser) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "user not found"
                ], 401);
            }
            $getGame = Game::where("slug", $slug)->first();
            if ($getGame->user_id != $getUser->id) {
                return response()->json([
                    "status" => "forbidden",
                    "message" => "You are not the game author"
                ], 403);
            }
            $del = Game::destroy($getGame->id);
            if (!$del) {
                return response()->json([
                    "status" => "failed",
                    "message" => "failed to delete"
                ], 422);
            }
            return response()->json([
                "status" => "success",
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
