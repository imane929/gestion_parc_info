<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PieceJointe;
use Illuminate\Support\Facades\Storage;

class PieceJointeController extends Controller
{
    public function destroy(PieceJointe $pieceJointe)
    {
        Storage::disk('public')->delete($pieceJointe->chemin);
        $pieceJointe->delete();
        return back()->with('success', 'File deleted successfully.');
    }

    public function download(PieceJointe $pieceJointe)
    {
        if (!Storage::disk('public')->exists($pieceJointe->chemin)) {
            return back()->with('error', 'File not found.');
        }
        return Storage::disk('public')->download($pieceJointe->chemin, $pieceJointe->nom_fichier);
    }
}