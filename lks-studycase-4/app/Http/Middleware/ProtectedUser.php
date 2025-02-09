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
        $userPayload = auth()->guard("api")->user();
        if($userPayload->role !== "ADMIN"){
            return response()->json(["status" => false, "message" =>"Only admin can access this route!", null],401);
        }
        return $next($request);
    }
}