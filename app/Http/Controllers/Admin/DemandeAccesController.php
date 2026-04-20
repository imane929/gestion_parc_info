<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemandeAcces;
use App\Models\User;
use App\Models\Notification;
use App\Mail\AccesApprouveMail;
use App\Mail\AccesRejeteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DemandeAccesController extends Controller
{
    public function index()
    {
        $demandes = DemandeAcces::with('traitePar')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.demandes-acces.index', compact('demandes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'departement' => 'required|string|max:255',
            'raison' => 'required|string|max:1000',
        ]);

        // Check if email already exists in users
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->with('error', 'This email is already registered in the system.')->withInput();
        }

        // Check if there's already a pending request
        $existingRequest = DemandeAcces::where('email', $request->email)
            ->where('statut', 'en_attente')
            ->first();
        if ($existingRequest) {
            return back()->with('error', 'You already have a pending access request.')->withInput();
        }

        // Create the access request
        $demande = DemandeAcces::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'departement' => $request->departement,
            'raison' => $request->raison,
            'statut' => 'en_attente',
        ]);

        // Create notification for all admins
        $admins = User::whereHas('roles', function ($q) {
            $q->where('code', 'admin');
        })->get();

        foreach ($admins as $admin) {
            Notification::create([
                'utilisateur_id' => $admin->id,
                'titre' => 'Nouvelle demande d\'accès',
                'message' => $demande->prenom . ' ' . $demande->nom . ' (' . $demande->email . ') a demandé un accès pour le département: ' . $demande->departement,
                'type' => 'demande_acces',
                'lien' => route('admin.demandes-acces.index'),
            ]);
        }

        return redirect()->route('login')->with('success', 'Your access request has been submitted successfully. You will be notified once an administrator reviews it.');
    }

    public function approve(Request $request, DemandeAcces $demande)
    {
        if ($demande->statut !== 'en_attente') {
            return back()->with('error', 'This request has already been processed.');
        }

        $request->validate([
            'mot_de_passe' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:utilisateur,technicien,responsable_it,manager',
        ]);

        DB::beginTransaction();
        try {
            // Create the user
            $user = User::create([
                'nom' => $demande->nom,
                'prenom' => $demande->prenom,
                'email' => $demande->email,
                'password' => Hash::make($request->mot_de_passe),
                'etat_compte' => 'actif',
                'email_verified_at' => now(),
            ]);

            // Assign the role
            $role = DB::table('roles')->where('code', $request->role)->first();
            if ($role) {
                DB::table('role_utilisateur')->insert([
                    'role_id' => $role->id,
                    'model_id' => $user->id,
                ]);
            }

            // Update the request
            $demande->update([
                'statut' => 'approuvee',
                'traitée_par' => auth()->id(),
                'traitée_at' => now(),
                'commentaire' => 'Approved with role: ' . $request->role,
            ]);

            // Send email to the user with their credentials
            try {
                Mail::to($demande->email)->send(new AccesApprouveMail($demande, $request->mot_de_passe));
            } catch (\Exception $e) {
                // Log error but don't fail the request
                \Log::error('Failed to send approval email: ' . $e->getMessage());
            }

            DB::commit();

            return redirect()->route('admin.demandes-acces.index')
                ->with('success', 'Access request approved. User created successfully. An email has been sent to the user.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, DemandeAcces $demande)
    {
        if ($demande->statut !== 'en_attente') {
            return back()->with('error', 'This request has already been processed.');
        }

        $demande->update([
            'statut' => 'rejetee',
            'traitée_par' => auth()->id(),
            'traitée_at' => now(),
            'commentaire' => $request->commentaire ?? 'Request rejected',
        ]);

        // Send rejection email to the user
        try {
            Mail::to($demande->email)->send(new AccesRejeteMail($demande));
        } catch (\Exception $e) {
            \Log::error('Failed to send rejection email: ' . $e->getMessage());
        }

        return redirect()->route('admin.demandes-acces.index')
            ->with('success', 'Access request rejected. An email has been sent to the user.');
    }
}
