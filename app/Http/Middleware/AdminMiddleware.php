<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow users with is_admin = true to access admin pages.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in and is an admin
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Unauthorized. Admin access only.');
        }

        return $next($request);
    }
}
