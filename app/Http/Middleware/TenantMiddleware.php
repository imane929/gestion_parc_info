<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si multi-tenant est activé, vérifier le tenant
        // Pour l'instant, on le laisse vide car optionnel
        return $next($request);
    }
}