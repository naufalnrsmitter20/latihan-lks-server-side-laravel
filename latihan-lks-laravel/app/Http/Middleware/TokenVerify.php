<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResources;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TokenVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $authorizationHeader = $request->header("Authorization");
        if(!$authorizationHeader){
            return new ApiResources(401, "Token Not Provided!", null);
        }
        if(auth()->guard("api")->user() == null){
            return new ApiResources(401, "Invallid Token!", null);
        }
       
        return $next($request);
    }
}