<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = $request->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        // Debug
        \Log::info('Checking permissions: ' . json_encode($permissions));
        \Log::info('User permissions: ' . json_encode($user->getAllPermissions()->pluck('name')));

        // Admin has access to everything
        if ($user->hasRoleByCode('admin')) {
            return $next($request);
        }

        // Check if user has any of the required permissions
        foreach ($permissions as $permission) {
            if ($user->can($permission)) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized. Required permissions: ' . implode(', ', $permissions)], 403);
        }

        abort(403, 'Unauthorized. You do not have the required permission(s).');
    }
}