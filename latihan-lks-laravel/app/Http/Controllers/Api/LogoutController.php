<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ApiResources;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
    try {
        if(auth()->guard("api")->check()) auth()->guard("api")->logout();
        return new ApiResources(200, "Success to Logout", [
            "payload" => auth()->guard("api")->user(),
            "status" => true
        ]);
    } catch (\Exception $e) {
        return response()->json([
            "status" => false,
            "message" => $e->getMessage()
        ], $e->getCode());
    }
    }
}