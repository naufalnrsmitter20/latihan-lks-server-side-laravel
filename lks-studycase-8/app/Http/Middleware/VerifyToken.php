<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header("Authorization");
        if (!$token) {
            return response()->json(["status" => false, "message" => "Token Not Provided", "data" => "Unauthorized user"], 401);
        }
        if (auth()->guard("api")->user() === null) {
            return response()->json(["status" => false, "message" => "Invalid Token!", "data" => "Unauthorized user"], 401);
        }
        return $next($request);
    }
}
