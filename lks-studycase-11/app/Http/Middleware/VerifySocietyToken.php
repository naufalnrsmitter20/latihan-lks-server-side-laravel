<?php

namespace App\Http\Middleware;

use App\Models\Society;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifySocietyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has("token")) {
            $token = $request->get("token");
            $findSociety = Society::where("login_tokens", $token)->first();
            $decodeToken = md5($findSociety->id_card_number . $findSociety->password);
            if (!$token) {
                return response()->json([
                    "message" => "Token Not Provided"
                ], 401);
            }
            if ($token === $decodeToken) {
                return $next($request);
            } else {
                return response()->json([
                    "message" => "Invalid Token"
                ], 401);
            }
        } else {
            return response()->json([
                "message" => "Token Not Provided"
            ], 401);
        }
    }
}