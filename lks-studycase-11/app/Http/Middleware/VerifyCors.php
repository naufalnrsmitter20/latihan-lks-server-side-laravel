<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyCors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request = $next($request);
        $request->headers->set("Allow-Access-Control-Origin", "*");
        $request->headers->set("Allow-Access-Control-Method", "GET, POST, PUT, DELETE, PATCH, OPTIONS");
        $request->headers->set("Allow-Access-Control-Headers", "Content-Type, Authorization");
        return $request;
    }
}