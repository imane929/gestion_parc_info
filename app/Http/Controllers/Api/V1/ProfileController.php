<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Récupérer le profil de l'utilisateur connecté
     */
    public function index(Request $request)
    {
        $utilisateur = $request->user()->load('roles');
        
        $data = [
            'id' => $utilisateur->id,
            'uuid' => $utilisateur->uuid,
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'full_name' => $utilisateur->full_name,
            'email' => $utilisateur->email,
            'telephone' => $utilisateur->telephone,
            'etat_compte' => $utilisateur->etat_compte,
            'derniere_connexion_at' => $utilisateur->derniere_connexion_at,
            'photo_url' => $utilisateur->photo_url,
            'email_verified_at' => $utilisateur->email_verified_at,
            'created_at' => $utilisateur->created_at,
            'updated_at' => $utilisateur->updated_at,
            'roles' => $utilisateur->getRoleNames(),
            'permissions' => $utilisateur->getAllPermissions()->pluck('name'),
        ];

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Mettre à jour le profil
     */
    public function update(Request $request)
    {
        $utilisateur = $request->user();

        $validator = \Validator::make($request->all(), [
            'nom' => 'sometimes|required|string|max:100',
            'prenom' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:utilisateurs,email,' . $utilisateur->id,
            'telephone' => 'sometimes|nullable|string|max:20',
            'photo' => 'sometimes|nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        // Gérer l'upload de photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profiles', 'public');
            $data['photo_url'] = Storage::url($path);
            
            // Supprimer l'ancienne photo si elle existe
            if ($utilisateur->photo_url) {
                $oldPath = str_replace('/storage/', '', $utilisateur->photo_url);
                Storage::disk('public')->delete($oldPath);
            }
        }

        $utilisateur->update($data);

        return response()->json([
            'message' => 'Profil mis à jour avec succès',
            'data' => $utilisateur->makeHidden('mot_de_passe'),
        ]);
    }

    /**
     * Changer le mot de passe
     */
    public function changePassword(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'mot_de_passe_actuel' => 'required|string',
            'nouveau_mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $utilisateur = $request->user();

        if (!Hash::check($request->mot_de_passe_actuel, $utilisateur->mot_de_passe)) {
            throw ValidationException::withMessages([
                'mot_de_passe_actuel' => ['Le mot de passe actuel est incorrect.'],
            ]);
        }

        $utilisateur->update([
            'mot_de_passe' => Hash::make($request->nouveau_mot_de_passe),
        ]);

        return response()->json([
            'message' => 'Mot de passe changé avec succès',
        ]);
    }

    /**
     * Récupérer les notifications de l'utilisateur
     */
    public function notifications(Request $request)
    {
        $query = $request->user()->notifications();

        if ($request->has('lu')) {
            if ($request->lu === '1') {
                $query->whereNotNull('lu_at');
            } else {
                $query->whereNull('lu_at');
            }
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'data' => $notifications->items(),
            'meta' => [
                'total' => $notifications->total(),
                'per_page' => $notifications->perPage(),
                'current_page' => $notifications->currentPage(),
                'last_page' => $notifications->lastPage(),
                'non_lues' => $request->user()->notifications()->whereNull('lu_at')->count(),
            ],
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function marquerNotificationLue(Request $request, $notificationId)
    {
        $notification = $request->user()->notifications()->findOrFail($notificationId);
        $notification->marquerCommeLue();

        return response()->json([
            'message' => 'Notification marquée comme lue',
        ]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function marquerToutesNotificationsLues(Request $request)
    {
        $request->user()->notifications()
            ->whereNull('lu_at')
            ->update(['lu_at' => now()]);

        return response()->json([
            'message' => 'Toutes les notifications ont été marquées comme lues',
        ]);
    }

    /**
     * Récupérer les tickets de l'utilisateur
     */
    public function mesTickets(Request $request)
    {
        $utilisateur = $request->user();
        $query = \App\Models\TicketMaintenance::with(['assigneA', 'actif']);

        // L'utilisateur voit ses tickets créés ou assignés
        if ($utilisateur->hasRole('utilisateur') && !$utilisateur->hasAnyRole(['admin', 'responsable_it', 'technicien'])) {
            $query->where('created_by', $utilisateur->id);
        } else {
            $query->where(function($q) use ($utilisateur) {
                $q->where('created_by', $utilisateur->id)
                  ->orWhere('assigne_a', $utilisateur->id);
            });
        }

        // Filtres
        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->has('priorite')) {
            $query->where('priorite', $request->priorite);
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(20);

        return response()->json([
            'data' => $tickets->items(),
            'meta' => [
                'total' => $tickets->total(),
                'per_page' => $tickets->perPage(),
                'current_page' => $tickets->currentPage(),
                'last_page' => $tickets->lastPage(),
            ],
        ]);
    }

    /**
     * Récupérer les actifs affectés à l'utilisateur
     */
    public function mesActifs(Request $request)
    {
        $actifs = $request->user()->actifsAffectes()->with('localisation')->paginate(20);

        return response()->json([
            'data' => $actifs->items(),
            'meta' => [
                'total' => $actifs->total(),
                'per_page' => $actifs->perPage(),
                'current_page' => $actifs->currentPage(),
                'last_page' => $actifs->lastPage(),
            ],
        ]);
    }

    /**
     * Récupérer les interventions de l'utilisateur (pour les techniciens)
     */
    public function mesInterventions(Request $request)
    {
        if (!$request->user()->estTechnicien()) {
            return response()->json([
                'message' => 'Accès réservé aux techniciens',
            ], 403);
        }

        $interventions = $request->user()->interventions()
            ->with(['ticket', 'ticket.actif'])
            ->orderBy('date', 'desc')
            ->paginate(20);

        // Statistiques
        $stats = [
            'total' => $interventions->total(),
            'temps_total' => $interventions->sum('temps_passe'),
            'dernier_mois' => $request->user()->interventions()
                ->where('date', '>=', now()->subDays(30))
                ->count(),
        ];

        return response()->json([
            'data' => $interventions->items(),
            'meta' => [
                'total' => $interventions->total(),
                'per_page' => $interventions->perPage(),
                'current_page' => $interventions->currentPage(),
                'last_page' => $interventions->lastPage(),
                'stats' => $stats,
            ],
        ]);
    }

    /**
     * Générer un token API
     */
    public function generateApiToken(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'abilities' => 'array',
            'abilities.*' => 'string|in:read,write,delete',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $abilities = $request->abilities ?? ['read'];
        $token = $request->user()->createToken($request->name, $abilities);

        return response()->json([
            'message' => 'Token API généré',
            'token' => $token->plainTextToken,
            'token_name' => $token->accessToken->name,
            'abilities' => $abilities,
            'created_at' => $token->accessToken->created_at,
        ], 201);
    }

    /**
     * Récupérer les tokens API de l'utilisateur
     */
    public function apiTokens(Request $request)
    {
        $tokens = $request->user()->tokens()->get()->map(function($token) {
            return [
                'id' => $token->id,
                'name' => $token->name,
                'abilities' => $token->abilities,
                'last_used_at' => $token->last_used_at,
                'created_at' => $token->created_at,
            ];
        });

        return response()->json([
            'data' => $tokens,
        ]);
    }

    /**
     * Révoquer un token API
     */
    public function revokeApiToken(Request $request, $tokenId)
    {
        $token = $request->user()->tokens()->findOrFail($tokenId);
        $token->delete();

        return response()->json([
            'message' => 'Token API révoqué',
        ]);
    }

    /**
     * Révoquer tous les tokens API
     */
    public function revokeAllApiTokens(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Tous les tokens API ont été révoqués',
        ]);
    }

    /**
     * Vérifier les permissions de l'utilisateur
     */
    public function checkPermissions(Request $request)
    {
        $permissions = $request->input('permissions', []);
        
        $results = [];
        foreach ($permissions as $permission) {
            $results[$permission] = $request->user()->can($permission);
        }

        return response()->json([
            'data' => $results,
        ]);
    }
}