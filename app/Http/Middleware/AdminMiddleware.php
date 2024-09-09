<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // // if  have admin access
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        //if  have not admin access
        return redirect('/register')->with('error', 'You do not have admin access.');
    }
}