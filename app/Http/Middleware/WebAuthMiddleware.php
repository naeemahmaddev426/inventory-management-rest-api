<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebAuthMiddleware
{
    /**
     * Handle an incoming request.
     * Redirect to login if no session token is present.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! session('auth_token')) {
            return redirect()->route('dashboard.login')
                ->with('error', 'Please log in to access the dashboard.');
        }

        return $next($request);
    }
}
