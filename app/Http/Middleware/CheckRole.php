<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // Admin bypasses ALL role checks
        if ($user->hasRoleByCode('admin') || $user->hasRole('admin')) {
            return $next($request);
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            // Handle multiple roles separated by |
            if (str_contains($role, '|')) {
                $subRoles = explode('|', $role);
                foreach ($subRoles as $subRole) {
                    // Use hasRoleByCode for more reliable role checking
                    if ($user->hasRoleByCode($subRole) || $user->hasRole($subRole)) {
                        return $next($request);
                    }
                }
                continue;
            }

            // Use hasRoleByCode for more reliable role checking
            if ($user->hasRoleByCode($role) || $user->hasRole($role)) {
                return $next($request);
            }
        }

        // If user doesn't have required role, redirect to dashboard silently (no error message)
        return redirect()->route('admin.dashboard');
    }
}