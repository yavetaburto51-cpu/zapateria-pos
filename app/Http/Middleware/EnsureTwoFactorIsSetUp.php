<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTwoFactorIsSetUp
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->two_factor_confirmed_at) {
            if ($request->routeIs('2fa.setup') || $request->routeIs('2fa.enable') || $request->routeIs('logout')) {
                return $next($request);
            }

            return redirect()->route('2fa.setup');
        }

        return $next($request);
    }
}
