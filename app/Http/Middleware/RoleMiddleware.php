<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            abort(403);
        }

        $userRole = strtolower((string) auth()->user()->role);
        $normalizedRoles = array_map('strtolower', $roles);

        if (! in_array($userRole, $normalizedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
