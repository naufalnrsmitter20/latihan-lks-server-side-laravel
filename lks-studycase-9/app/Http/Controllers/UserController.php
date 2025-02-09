<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = User::where("username", "NOT LIKE", "%admin%")->get();
            $totalElements = $data->count();
            return response()->json([
                "totalElements" => $totalElements,
                "content" => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
    public function show($username)
    {
        try {
            $data = User::where("username", $username)->first();
            $game = Game::where("user_id", $data->id)->get();
            $getScore = Game::with("scores")->where("user_id", $data->id);
            return response()->json([
                "username" => $data->username,
                "registeredTimestamp" => $data->created_at,
                "authoredGames" => $game->map(function ($item) {
                    return [
                        "slug" => $item->slug,
                        "title" => $item->title,
                        "description" => $item->description,
                    ];
                }),
                "highscores" => $getScore->get()->map(function ($item) {
                    return [
                        "game" => [
                            "slug" => $item->slug,
                            "title" => $item->title,
                            "description" => $item->description,
                        ],
                        "score" => $item->scores->max("score"),
                        "timestamp" => $item->updated_at
                    ];
                })
            ], 200);
            // return response()->json($game, 200);
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
                "username" => "required|unique:users,username|min:4|max:60",
                "password" => "required|min:5|max:10"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $role = "USER";
            if ($request->username && str_contains($request->username, "admin")) {
                $role = "ADMIN";
            }
            $data = User::create([
                "username" => $request->username,
                "password" => Hash::make($request->password),
                "role" => $role
            ]);
            return response()->json([
                "status" => "success",
                "username" => $data->username
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                "username" => "required|unique:users,username|min:4|max:60",
                "password" => "required|min:5|max:10"
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $finduser = User::find($id);
            if (!$finduser) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "user not found"
                ], 403);
            }
            User::find($id)->update([
                "username" => $request->username,
                "password" => Hash::make($request->password)
            ]);

            return response()->json([
                "status" => "success",
                "username" => $request->username
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $finduser = User::find($id);
            if (!$finduser) {
                return response()->json([
                    "status" => "not-found",
                    "message" => "user not found"
                ], 403);
            }
            User::destroy($id);
            return response()->json([
                "status" => "success",
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
