<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->roles_id === 2) {
            return $next($request);
        }

        abort(401, 'Unauthorized');
    }
}