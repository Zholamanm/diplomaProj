<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogBroadcastingAuthRequest
{
    public function handle($request, Closure $next)
    {
        \Log::info('Broadcasting auth request:', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'user_id' => optional($request->user())->id,
            'input' => $request->all(),
        ]);
        if ($request->is('broadcasting/auth')) {
            \Log::info('Broadcasting auth request headers', $request->headers->all());
            \Log::info('Broadcasting auth user', ['user' => optional($request->user())->id]);
        }
        return $next($request);
    }

}
