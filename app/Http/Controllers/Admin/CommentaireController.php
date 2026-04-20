<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commentaire;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'objet_type' => 'required|string',
            'objet_id' => 'required|integer',
            'contenu' => 'required|string',
        ]);

        $commentaire = Commentaire::create([
            'utilisateur_id' => auth()->id(),
            'objet_type' => $validated['objet_type'],
            'objet_id' => $validated['objet_id'],
            'contenu' => $validated['contenu'],
        ]);

        return back()->with('success', 'Comment added successfully.');
    }

    public function destroy(Commentaire $commentaire)
    {
        $commentaire->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }
}