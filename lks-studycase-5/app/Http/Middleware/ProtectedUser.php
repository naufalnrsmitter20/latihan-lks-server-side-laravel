<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = auth()->guard("api")->user();
        if ($admin->role !== "ADMIN") {
            return response()->json([
                "status" => false,
                "message" => "Only Admin Ca Access this route!"
            ], 401);
        }
        return $next($request);
    }
}
