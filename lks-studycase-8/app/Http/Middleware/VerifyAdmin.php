<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userPayload = auth()->guard("api")->user();
        if ($userPayload->role !== "ADMIN") {
            return response()->json([
                "status" => 401,
                "message" => "Unauthorized access"
            ], 401);
        }
        return $next($request);
    }
}
