<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServeGameFile extends Controller
{
    public function index($slug, $version)
    {
        try {
            $game = Game::where("slug", $slug)->first();
            $v = Version::where("v", $version)->first();
            return response()->json([
                "game" => $game,
                "version" => $v
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => $e->getCode(),
                "message" => $e->getMessage()
            ], $e->getCode());
        }
    }
}
