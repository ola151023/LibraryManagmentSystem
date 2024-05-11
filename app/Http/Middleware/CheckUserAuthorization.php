<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user is authenticated
        if (Auth::guard('sanctum')->check()) {


            // Proceed with the request
            return $next($request);
        }


        return response()->json(['error' => 'Unauthorized'], 401);
    }

}
