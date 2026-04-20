<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DemandeAcces;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Entry point for system administration.
     */
    public function index()
    {
        // Handled by role:admin middleware in web.php
        $stats = [
            'users_count' => User::count(),
            'pending_requests' => DemandeAcces::where('statut', 'en_attente')->count(),
            'unread_messages' => ContactMessage::where('lu', false)->count(),
        ];

        return view('admin.index', compact('stats'));
    }

    /**
     * System settings overview.
     */
    public function settings()
    {
        $this->authorize('settings.view');
        return redirect()->route('admin.settings.index');
    }
}
