<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Authorization is handled by the route middleware (role:admin|responsable_it|technicien|manager)
        // No additional authorization check needed here

        $query = User::with('roles');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtre par rôle
        if ($request->has('role') && !empty($request->role)) {
            $role = $request->role;
            $query->whereHas('roles', function($q) use ($role) {
                $q->where('code', $role);
            });
        }

        // Filtre par état
        if ($request->has('etat') && !empty($request->etat)) {
            $query->where('etat_compte', $request->etat);
        }

        $utilisateurs = $query->orderBy('created_at', 'desc')->paginate(25);
        $roles = Role::all();
        $etats = ['actif', 'inactif', 'suspendu'];

        return view('admin.utilisateurs.index', compact('utilisateurs', 'roles', 'etats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Authorization is handled by the route middleware
        $roles = Role::where('code', '!=', 'admin')->get();
        return view('admin.utilisateurs.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Authorization is handled by the route middleware
        
        $validated = $request->validate([
            'civilite' => 'nullable|in:M,Mme,Mlle',
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email|unique:utilisateurs,email',
            'telephone' => 'nullable|string|max:20',
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'etat_compte' => 'required|in:actif,inactif,suspendu,bloque',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            $utilisateur = User::create([
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'],
                'password' => Hash::make($validated['mot_de_passe']),
                'etat_compte' => $validated['etat_compte'],
                'email_verified_at' => now(),
            ]);

            $utilisateur->roles()->sync($validated['roles']);

            DB::commit();

            return redirect()->route('admin.utilisateurs.index')
                ->with('success', 'Utilisateur créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création de l\'utilisateur.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $utilisateur)
    {
        // Authorization is handled by the route middleware

        $utilisateur->load([
            'roles', 
            'actifsAffectes', 
            'ticketsCrees', 
            'ticketsAssignes',
            'affectationsActifs.actif'
        ]);

        return view('admin.utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $utilisateur)
    {
        // Authorization is handled by the route middleware

        $roles = Role::all();
        $utilisateur->load('roles');

        return view('admin.utilisateurs.edit', compact('utilisateur', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $utilisateur)
    {
        // Authorization is handled by the route middleware

        $validated = $request->validate([
            'civilite' => 'nullable|in:M,Mme,Mlle',
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('utilisateurs')->ignore($utilisateur->id),
            ],
            'telephone' => 'nullable|string|max:20',
            'mot_de_passe' => 'nullable|string|min:8|confirmed',
            'etat_compte' => 'required|in:actif,inactif,suspendu,bloque',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'nom' => $validated['nom'],
                'prenom' => $validated['prenom'],
                'email' => $validated['email'],
                'telephone' => $validated['telephone'],
                'etat_compte' => $validated['etat_compte'],
            ];

            if (!empty($validated['mot_de_passe'])) {
                $data['password'] = Hash::make($validated['mot_de_passe']);
            }

            $utilisateur->update($data);

            // Vérifier si l'utilisateur a la permission de changer les rôles
            if ($request->user()->can('changeRole', $utilisateur)) {
                $utilisateur->roles()->sync($validated['roles']);
            }

            DB::commit();

            return redirect()->route('admin.utilisateurs.index')
                ->with('success', 'Utilisateur mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de la mise à jour de l\'utilisateur.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $utilisateur)
    {
        // Authorization is handled by the route middleware

        // Empêcher la suppression de soi-même
        if (auth()->user()->id === $utilisateur->id) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        try {
            $utilisateur->delete();
            return redirect()->route('admin.utilisateurs.index')
                ->with('success', 'Utilisateur supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de l\'utilisateur.');
        }
    }

    /**
     * Activer/désactiver un utilisateur
     */
    public function toggleStatus(User $utilisateur)
    {
        // Authorization is handled by the route middleware

        $nouvelEtat = $utilisateur->etat_compte === 'actif' ? 'inactif' : 'actif';
        $utilisateur->update(['etat_compte' => $nouvelEtat]);

        $message = $nouvelEtat === 'actif' 
            ? 'Utilisateur activé avec succès.' 
            : 'Utilisateur désactivé avec succès.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Afficher le profil utilisateur
     */
    public function profile()
    {
        $utilisateur = auth()->user();
        return view('admin.utilisateurs.profile', compact('utilisateur'));
    }

    /**
     * Mettre à jour le profil utilisateur
     */
    public function updateProfile(Request $request)
    {
        $utilisateur = auth()->user();

        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                Rule::unique('utilisateurs')->ignore($utilisateur->id),
            ],
            'telephone' => 'nullable|string|max:20',
            'mot_de_passe_actuel' => 'nullable|string',
            'nouveau_mot_de_passe' => 'nullable|string|min:8|confirmed',
        ]);

        // Vérifier le mot de passe actuel si un nouveau est fourni
        if (!empty($validated['nouveau_mot_de_passe'])) {
            if (!Hash::check($validated['mot_de_passe_actuel'], $utilisateur->password)) {
                return redirect()->back()
                    ->with('error', 'Le mot de passe actuel est incorrect.');
            }

            $utilisateur->password = Hash::make($validated['nouveau_mot_de_passe']);
        }

        $utilisateur->nom = $validated['nom'];
        $utilisateur->prenom = $validated['prenom'];
        $utilisateur->email = $validated['email'];
        $utilisateur->telephone = $validated['telephone'];
        $utilisateur->save();

        return redirect()->route('admin.utilisateurs.profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}
