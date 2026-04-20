<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User as Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Notification::where('utilisateur_id', Auth::id());

        // Filtre par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par statut
        if ($request->has('lu')) {
            if ($request->lu === '1') {
                $query->whereNotNull('lu_at');
            } else {
                $query->whereNull('lu_at');
            }
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(25);
        $nonLuesCount = Notification::where('utilisateur_id', Auth::id())
            ->whereNull('lu_at')
            ->count();

        return view('admin.notifications.index', compact('notifications', 'nonLuesCount'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function marquerLue(Notification $notification)
    {
        // Vérifier que la notification appartient à l'utilisateur connecté
        if ($notification->utilisateur_id !== Auth::id()) {
            abort(403);
        }

        $notification->marquerCommeLue();

        return response()->json(['success' => true]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function marquerToutesLues()
    {
        Notification::where('utilisateur_id', Auth::id())
            ->whereNull('lu_at')
            ->update(['lu_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy(Request $request, Notification $notification)
    {
        // Vérifier que la notification appartient à l'utilisateur connecté
        if ($notification->utilisateur_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification supprimée.');
    }

    /**
     * Supprimer toutes les notifications lues
     */
    public function supprimerLues(Request $request)
    {
        Notification::where('utilisateur_id', Auth::id())
            ->whereNotNull('lu_at')
            ->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Toutes les notifications lues ont été supprimées.');
    }

    /**
     * Get unread notifications count for API.
     */
    public function unreadCountApi()
    {
        return response()->json([
            'count' => Auth::user()->notifications()->whereNull('lu_at')->count()
        ]);
    }
}
