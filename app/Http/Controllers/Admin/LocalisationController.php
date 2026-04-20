<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Localisation;
use App\Models\ActifInformatique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LocalisationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Localisation::class);

        $query = Localisation::withCount('actifs');

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('site', 'like', "%{$search}%")
                  ->orWhere('batiment', 'like', "%{$search}%")
                  ->orWhere('etage', 'like', "%{$search}%")
                  ->orWhere('bureau', 'like', "%{$search}%");
            });
        }

        // Filtre par site
        if ($request->has('site')) {
            $query->where('site', $request->site);
        }

        $localisations = $query->paginate(25);
        $sites = Localisation::distinct()->pluck('site');

        return view('admin.localisations.index', compact('localisations', 'sites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Localisation::class);

        $sites = Localisation::distinct()->pluck('site');
        return view('admin.localisations.create', compact('sites'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Localisation::class);

        $validated = $request->validate([
            'site' => 'required|string|max:150',
            'batiment' => 'nullable|string|max:100',
            'etage' => 'nullable|string|max:50',
            'bureau' => 'nullable|string|max:100',
        ]);

        // Vérifier l'unicité
        $existe = Localisation::where('site', $validated['site'])
            ->where('batiment', $validated['batiment'])
            ->where('etage', $validated['etage'])
            ->where('bureau', $validated['bureau'])
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('error', 'Cette localisation existe déjà.')
                ->withInput();
        }

        Localisation::create($validated);

        return redirect()->route('admin.localisations.index')
            ->with('success', 'Localisation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Localisation $localisation)
    {
        $this->authorize('view', $localisation);

        $localisation->load(['actifs.utilisateurAffecte', 'actifs.localisation']);
        
        // Actifs par type dans cette localisation
        $actifsParType = $localisation->actifs()
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type');

        return view('admin.localisations.show', compact('localisation', 'actifsParType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Localisation $localisation)
    {
        $this->authorize('update', $localisation);

        $sites = Localisation::distinct()->pluck('site');
        return view('admin.localisations.edit', compact('localisation', 'sites'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Localisation $localisation)
    {
        $this->authorize('update', $localisation);

        $validated = $request->validate([
            'site' => 'required|string|max:150',
            'batiment' => 'nullable|string|max:100',
            'etage' => 'nullable|string|max:50',
            'bureau' => 'nullable|string|max:100',
        ]);

        // Vérifier l'unicité (sauf la localisation courante)
        $existe = Localisation::where('site', $validated['site'])
            ->where('batiment', $validated['batiment'])
            ->where('etage', $validated['etage'])
            ->where('bureau', $validated['bureau'])
            ->where('id', '!=', $localisation->id)
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('error', 'Cette localisation existe déjà.')
                ->withInput();
        }

        $localisation->update($validated);

        return redirect()->route('admin.localisations.show', $localisation)
            ->with('success', 'Localisation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Localisation $localisation)
    {
        $this->authorize('delete', $localisation);

        // Vérifier si des actifs utilisent cette localisation
        if ($localisation->actifs()->exists()) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer la localisation car des actifs y sont associés.');
        }

        try {
            $localisation->delete();
            return redirect()->route('admin.localisations.index')
                ->with('success', 'Localisation supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression de la localisation.');
        }
    }

    /**
     * Déplacer des actifs vers une autre localisation
     */
    public function deplacerActifs(Request $request, Localisation $localisation)
    {
        $this->authorize('update', $localisation);

        $validated = $request->validate([
            'nouvelle_localisation_id' => 'required|exists:localisations,id',
            'actifs' => 'required|array',
            'actifs.*' => 'exists:actifs_informatiques,id',
        ]);

        DB::beginTransaction();
        try {
            ActifInformatique::whereIn('id', $validated['actifs'])
                ->update(['localisation_id' => $validated['nouvelle_localisation_id']]);

            DB::commit();

            return redirect()->back()
                ->with('success', count($validated['actifs']) . ' actifs déplacés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors du déplacement des actifs.');
        }
    }

    /**
     * Exporter les localisations
     */
    public function export()
    {
        $this->authorize('export-data');

        $localisations = Localisation::withCount('actifs')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="localisations_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($localisations) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Site', 'Bâtiment', 'Étage', 'Bureau', 'Nombre d\'actifs']);

            foreach ($localisations as $localisation) {
                fputcsv($file, [
                    $localisation->site,
                    $localisation->batiment ?? '',
                    $localisation->etage ?? '',
                    $localisation->bureau ?? '',
                    $localisation->actifs_count,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}