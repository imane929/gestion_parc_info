<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JournalActivite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Display a listing of the activities.
     */
    public function index(Request $request)
    {
        $query = JournalActivite::with('utilisateur');

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('utilisateur_id', $request->user_id);
        }

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Get unique actions for filter dropdown
        $actions = JournalActivite::distinct()->pluck('action');

        $activities = $query->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.activities.index', compact('activities', 'actions'));
    }

    /**
     * Display the activity details.
     */
    public function show(JournalActivite $activity)
    {
        $activity->load('utilisateur', 'objet');
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Get activities for dashboard widget (AJAX).
     */
    public function recent(Request $request)
    {
        $limit = $request->get('limit', 10);
        $activities = JournalActivite::with('utilisateur')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        return response()->json($activities);
    }
}
