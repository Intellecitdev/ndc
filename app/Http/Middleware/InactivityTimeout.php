<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * "You will be automatically logged out after N minutes of inactivity."
 * Background polling (user.live) keeps the session alive but does not count
 * as activity, so idle users are still logged out on time.
 */
class InactivityTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $last = $request->session()->get('last_activity_at');
            if ($last && now()->getTimestamp() - $last > config('session.lifetime') * 60) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => 'Session expired.', 'logout' => true], 401)
                    : redirect()->route('login')->with('status', 'You have been logged out due to inactivity.');
            }

            if (! $request->routeIs('user.live')) {
                $request->session()->put('last_activity_at', now()->getTimestamp());
            }
        }

        return $next($request);
    }
}
