<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Ei middleware check kore user ta admin kina. Admin na hole dashboard e redirect kore dey.
class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Auth::user() diye current logged in user ke check kora hocche
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'You do not have admin access.');
        }

        return $next($request);
    }
}