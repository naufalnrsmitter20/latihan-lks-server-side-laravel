<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class TestingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::all();
        $arrDot = Arr::dot($user->map(fn($item)=> $item->eskul()->get()->pluck("pivot")->select(["created_at"])));
        return new ApiResource(200, "Success", $arrDot);
    }
}