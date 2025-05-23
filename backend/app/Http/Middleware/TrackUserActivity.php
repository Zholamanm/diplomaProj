<?php

namespace App\Http\Middleware;

use App\Events\UserOnlineStatusChanged;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class TrackUserActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cacheKey = 'user-is-online-' . $user->id;

            if (!Cache::has($cacheKey)) {
                $user->update([
                    'last_seen_at' => now(),
                    'is_online' => true,
                ]);

                broadcast(new UserOnlineStatusChanged($user->id, true))->toOthers();

                Cache::put($cacheKey, true, 60);
            }
        }

        return $next($request);
    }
}
