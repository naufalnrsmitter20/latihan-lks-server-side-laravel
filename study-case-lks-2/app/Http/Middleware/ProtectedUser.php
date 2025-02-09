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
        $user_payload_auth = auth()->guard("api")->user();
        if($user_payload_auth->role !== "ADMIN"){
            return response()->json([
                "status" => false,
                "message" => "Unauthorize"
            ], 401);
        }
        return $next($request);
    }
}