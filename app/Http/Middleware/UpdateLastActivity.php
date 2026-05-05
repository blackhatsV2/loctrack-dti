<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class UpdateLastActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // Only update last_activity_at once per 60 seconds to avoid
            // hammering the (remote) database on every single request.
            $lastUpdate = session('_last_activity_updated_at', 0);
            if (now()->timestamp - $lastUpdate > 60) {
                auth()->user()->update(['last_activity_at' => now()]);
                session(['_last_activity_updated_at' => now()->timestamp]);
            }
        }
        return $next($request);
    }
}
