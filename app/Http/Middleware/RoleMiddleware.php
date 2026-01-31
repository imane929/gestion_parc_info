<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;
        
        // Check if user has required role
        if (!in_array($userRole, $roles)) {
            abort(403, 'Accès non autorisé. Rôle requis: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}