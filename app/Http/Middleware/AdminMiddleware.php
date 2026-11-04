<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // Check if user has admin role
        if (Auth::user()->role !== 'admin') {
            // Logout the user
            Auth::guard('web')->logout();
            
            // Invalidate session
            $request->session()->invalidate();
            
            // Regenerate CSRF token
            $request->session()->regenerateToken();
            
            return redirect()->route('login')->with('error', 'You do not have admin access.');
        }

        return $next($request);
    }
}