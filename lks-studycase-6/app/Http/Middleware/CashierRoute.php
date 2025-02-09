<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CashierRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->guard("api")->user();
        if ($user->role != 'CASHIER') {
            return response()->json([
                "status" => false,
                "message" => "Only Cashier can access this route!"
            ], 401);
        }
        return $next($request);
    }
}
