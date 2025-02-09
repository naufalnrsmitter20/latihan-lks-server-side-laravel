<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = auth()->guard("api")->user();
        if($authUser->role === "STUDENT"){
            return response()->json(["status"=>false, "message" => "Only teacher can access this route!", null], 401);
        }
        return $next($request);
    }
}