<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->has("token")) {
        //     $token = $request->get("token");
        //     $findSociety = User::where("login_tokens", $token)->first();
        //     $decodeToken = md5($findSociety->id_card_number . $findSociety->password);
        //     if (!$token) {
        //         return response()->json([
        //             "message" => "Token Not Provided"
        //         ], 401);
        //     }
        //     if ($token === $decodeToken) {
        return $next($request);
        //     } else {
        //         return response()->json([
        //             "message" => "Invalid Token"
        //         ], 401);
        //     }
        // } else {
        //     return response()->json([
        //         "message" => "Token Not Provided"
        //     ], 401);
        // }
    }
}