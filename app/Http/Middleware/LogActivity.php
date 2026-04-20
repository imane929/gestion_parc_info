<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\JournalActivite;

class LogActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Ne logger que les méthodes importantes (POST, PUT, PATCH, DELETE)
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->logActivity($request, $response);
        }

        return $response;
    }

    private function logActivity(Request $request, Response $response): void
    {
        $user = $request->user();
        
        if (!$user) {
            return;
        }

        $action = $this->getActionFromRequest($request);
        $objetType = $this->getObjectTypeFromRequest($request);
        $objetId = $this->getObjectIdFromRequest($request);

        if ($action && $objetType) {
            JournalActivite::create([
                'utilisateur_id' => $user->id,
                'action' => $action,
                'objet_type' => $objetType,
                'objet_id' => $objetId,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'donnees_avant' => $this->getBeforeData($request),
                'donnees_apres' => $this->getAfterData($request, $response),
            ]);
        }
    }

    private function getActionFromRequest(Request $request): ?string
    {
        $method = $request->method();
        $route = $request->route();

        if (!$route) {
            return null;
        }

        $actionName = $route->getActionName();
        
        if (str_contains($actionName, 'store')) {
            return 'create';
        } elseif (str_contains($actionName, 'update')) {
            return 'update';
        } elseif (str_contains($actionName, 'destroy')) {
            return 'delete';
        }

        return match($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => null,
        };
    }

    private function getObjectTypeFromRequest(Request $request): ?string
    {
        $route = $request->route();
        
        if (!$route) {
            return null;
        }

        // Extraire le nom du modèle depuis la route
        foreach ($route->parameters() as $parameter) {
            if (is_object($parameter)) {
                return get_class($parameter);
            }
        }

        // Essayer de deviner depuis l'URI
        $uri = $request->path();
        $segments = explode('/', $uri);
        
        foreach ($segments as $segment) {
            if (in_array($segment, ['utilisateurs', 'actifs', 'tickets', 'logiciels', 'contrats'])) {
                return match($segment) {
                    'utilisateurs' => 'App\Models\User',
                    'actifs' => 'App\Models\ActifInformatique',
                    'tickets' => 'App\Models\TicketMaintenance',
                    'logiciels' => 'App\Models\Logiciel',
                    'contrats' => 'App\Models\ContratMaintenance',
                    default => null,
                };
            }
        }

        return null;
    }

    private function getObjectIdFromRequest(Request $request): ?int
    {
        $route = $request->route();
        
        if (!$route) {
            return null;
        }

        foreach ($route->parameters() as $parameter) {
            if (is_object($parameter) && method_exists($parameter, 'getKey')) {
                return $parameter->getKey();
            } elseif (is_numeric($parameter)) {
                return (int) $parameter;
            }
        }

        return null;
    }

    private function getBeforeData(Request $request): ?array
    {
        // Pour les updates, on pourrait récupérer les données avant modification
        // C'est plus complexe et nécessite une implémentation spécifique
        return null;
    }

    private function getAfterData(Request $request, Response $response): ?array
    {
        // Récupérer les données après modification depuis la requête
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {
            return $request->except(['password', '_token', '_method']);
        }

        return null;
    }
}