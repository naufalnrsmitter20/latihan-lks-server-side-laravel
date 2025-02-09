<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Pest\version;

class GameFileUpload extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($slug, Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "thumbnail" => "required|image|mimes:png,jpg,jpeg,svg,jpeg",
            ]);
            if ($validate->fails()) {
                return response()->json([
                    "status" => "invalid",
                    "message" => $validate->errors()->first()
                ], 400);
            }
            $getGame = Game::where("slug", $slug)->first();
            if (!$getGame) {
                return response()->json([
                    "status" => "error",
                    "message" => "Game not found"
                ], 404);
            }
            $latestVersion = Version::where('game_id', $getGame->id)->max('v');
            $version = $latestVersion ? $latestVersion + 1 : 1;
            $extension = $request->thumbnail->extension();
            $gamePath = "{$getGame->slug}/{$version}/thumbnail.{$extension}";
            $thumbnailPath = public_path("games/{$gamePath}");

            // Ensure the directory exists
            $directory = dirname($thumbnailPath);
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }

            // Move the file
            $request->thumbnail->move(dirname($thumbnailPath), basename($thumbnailPath));

            // Create version entry
            $data = Version::create([
                "game_id" => $getGame->id,
                "v" => (int)$version,
                "thumbnail" => "games/{$gamePath}",
                "gamePath" => "games/{$getGame->slug}/{$version}/"
            ]);
            if (!$data) {
                return response()->json([
                    "status" => "error",
                    "data" => "failed to create"
                ], 400);
            }
            return response()->json([
                "status" => "success",
                "data" => $data
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
// "thumbnail": "/games/:slug/:version/thumbnail.png",