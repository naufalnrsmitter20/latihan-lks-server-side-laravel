<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyGasdang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard("api")->user();
        if ($user->role !== "GASDANG") {
            return response()->json([
                "status" => false,
                "message" => "Only gasdang can access this route!!"
            ]);
        }
        return $next($request);
    }
}
