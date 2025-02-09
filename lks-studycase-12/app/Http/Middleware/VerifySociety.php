<?php

namespace App\Http\Middleware;

use App\Models\Society;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySociety
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->get("token");
        if (!$token) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 403);
        }
        $findSociety = Society::where("login_tokens", $token)->first();
        if (!$findSociety) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 403);
        }
        return $next($request);
    }
}
