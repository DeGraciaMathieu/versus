<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param string|array $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if ($request->user()->hasOhasOneOfTheseRole($roles)) {
            return $next($request);
        }

        abort(403);
    }
}
