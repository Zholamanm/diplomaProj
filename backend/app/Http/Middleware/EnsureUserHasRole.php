<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$role)
    {

        if (!in_array($request->user()->role->id, $role)) {
            abort(403, 'no role access ');
        }

        return $next($request);

    }
}
