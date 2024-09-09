<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class managerMiddleware
{/*
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if  have manager access
        if (Auth::check() && Auth::user()->role === 'manager') {
            return $next($request);
        }

        // if  have not manager access
        return redirect('/')->with('error', 'You do not have admin access.');
    }
}
