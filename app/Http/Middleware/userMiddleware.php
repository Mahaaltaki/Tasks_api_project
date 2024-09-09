<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class userMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response

    
    {
        // if  have user access
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        }

        // if the user have not user access
        return redirect('/register')->with('error', 'You can not access.');
    }
}