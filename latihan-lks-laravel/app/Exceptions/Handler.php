<?php

namespace App\Exceptions;

use App\Http\Resources\ApiResources;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class Handler extends Exception
{
    protected $dontReport = [
        \Tymon\JWTAuth\Exceptions\TokenInvalidException::class,
        \Tymon\JWTAuth\Exceptions\TokenExpiredException::class,
        \Tymon\JWTAuth\Exceptions\JWTException::class
    ];
    public function render(Request $request, Throwable $exception)
    {
        if($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException ) {
            return new ApiResources(401, "Token Invalid", null);
        };
        if($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
            return new ApiResources(401, "Token Expired", null);
        };
       if ($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return new ApiResources(401, "Token Not Provided", null);
       }
     
        return new ApiResources(400, "Something went wrong", null);
    }
    
}