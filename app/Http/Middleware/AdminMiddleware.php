<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has an 'admin' role
        if (auth()->check() && auth()->user()->role && auth()->user()->role->name === 'superadmin') {
            return $next($request);
        }

        // Redirect non-admin users to home page
        return redirect()->route('home')->with('error', 'You do not have access to this page.');
    }
}
