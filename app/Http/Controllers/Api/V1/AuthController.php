<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User as Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    /**
     * Inscription d'un nouvel utilisateur
     */
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|string|email|unique:utilisateurs,email',
            'telephone' => 'nullable|string|max:20',
            'mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

        $utilisateur = Utilisateur::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
            'etat_compte' => 'actif',
            'email_verified_at' => now(),
        ]);

        // Assigner le rôle utilisateur par défaut
        $utilisateur->assignRole('utilisateur');

        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Utilisateur créé avec succès',
            'utilisateur' => $utilisateur->makeHidden('mot_de_passe'),
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    /**
     * Connexion de l'utilisateur
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'mot_de_passe' => 'required|string',
        ]);

        $utilisateur = Utilisateur::where('email', $request->email)->first();

        if (!$utilisateur || !Hash::check($request->mot_de_passe, $utilisateur->mot_de_passe)) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants fournis sont incorrects.'],
            ]);
        }

        if ($utilisateur->etat_compte !== 'actif') {
            return response()->json([
                'message' => 'Votre compte est ' . $utilisateur->etat_compte,
            ], 403);
        }

        // Mettre à jour la dernière connexion
        $utilisateur->update(['derniere_connexion_at' => now()]);

        $token = $utilisateur->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie',
            'utilisateur' => $utilisateur->makeHidden('mot_de_passe'),
            'token' => $token,
            'token_type' => 'Bearer',
            'roles' => $utilisateur->getRoleNames(),
            'permissions' => $utilisateur->getAllPermissions()->pluck('name'),
        ]);
    }

    /**
     * Déconnexion de l'utilisateur
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie',
        ]);
    }

    /**
     * Déconnexion de tous les appareils
     */
    public function logoutAll(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion de tous les appareils réussie',
        ]);
    }

    /**
     * Récupérer l'utilisateur courant
     */
    public function me(Request $request)
    {
        $utilisateur = $request->user();
        
        return response()->json([
            'utilisateur' => $utilisateur->load('roles'),
            'roles' => $utilisateur->getRoleNames(),
            'permissions' => $utilisateur->getAllPermissions()->pluck('name'),
        ]);
    }

    /**
     * Rafraîchir le token
     */
    public function refresh(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Token rafraîchi',
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Changer le mot de passe
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'mot_de_passe_actuel' => 'required|string',
            'nouveau_mot_de_passe' => 'required|string|min:8|confirmed',
        ]);

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
     * Demander une réinitialisation de mot de passe
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // TODO: Implémenter la logique d'envoi d'email
        // Pour l'instant, on retourne juste un message

        return response()->json([
            'message' => 'Si un compte existe avec cet email, vous recevrez un lien de réinitialisation.',
        ]);
    }

    /**
     * Vérifier la validité du token
     */
    public function checkToken(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['valid' => false], 401);
        }

        $accessToken = PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return response()->json(['valid' => false], 401);
        }

        $utilisateur = $accessToken->tokenable;

        if (!$utilisateur || $utilisateur->etat_compte !== 'actif') {
            return response()->json(['valid' => false], 401);
        }

        return response()->json(['valid' => true]);
    }
}