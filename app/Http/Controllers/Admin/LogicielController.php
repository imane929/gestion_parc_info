<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logiciel;
use App\Models\LicenceLogiciel;
use App\Models\InstallationLogiciel;
use App\Models\ActifInformatique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogicielController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Logiciel::class);

        $query = Logiciel::withCount(['licences', 'installations']);

        // Recherche
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('editeur', 'like', "%{$search}%")
                  ->orWhere('version', 'like', "%{$search}%");
            });
        }

        // Filtre par type
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filtre par éditeur
        if ($request->has('editeur')) {
            $query->where('editeur', $request->editeur);
        }

        $logiciels = $query->paginate(25);
        $types = ['os', 'bureau', 'serveur', 'web', 'mobile', 'autre'];
        $editeurs = Logiciel::distinct()->pluck('editeur');

        return view('admin.logiciels.index', compact('logiciels', 'types', 'editeurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Logiciel::class);

        $types = ['os', 'bureau', 'serveur', 'web', 'mobile', 'autre'];
        return view('admin.logiciels.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Logiciel::class);

        $validated = $request->validate([
            'nom' => 'required|string|max:200',
            'editeur' => 'required|string|max:150',
            'version' => 'required|string|max:50',
            'type' => 'required|in:os,bureau,serveur,web,mobile,autre',
            'description' => 'nullable|string',
        ]);

        Logiciel::create($validated);

        return redirect()->route('admin.logiciels.index')
            ->with('success', 'Logiciel créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Logiciel $logiciel)
    {
        $this->authorize('view', $logiciel);

        $logiciel->load([
            'licences' => function($query) {
                $query->orderBy('date_expiration');
            },
            'installations.actif',
            'installations.licence'
        ]);

        $actifs = ActifInformatique::all();
        $licencesDisponibles = $logiciel->licences()
            ->where('date_expiration', '>=', now())
            ->get()
            ->filter(function($licence) {
                return $licence->postes_disponibles > 0;
            });

        return view('admin.logiciels.show', compact('logiciel', 'actifs', 'licencesDisponibles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logiciel $logiciel)
    {
        $this->authorize('update', $logiciel);

        $types = ['os', 'bureau', 'serveur', 'web', 'mobile', 'autre'];
        return view('admin.logiciels.edit', compact('logiciel', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Logiciel $logiciel)
    {
        $this->authorize('update', $logiciel);

        $validated = $request->validate([
            'nom' => 'required|string|max:200',
            'editeur' => 'required|string|max:150',
            'version' => 'required|string|max:50',
            'type' => 'required|in:os,bureau,serveur,web,mobile,autre',
            'description' => 'nullable|string',
        ]);

        $logiciel->update($validated);

        return redirect()->route('admin.logiciels.show', $logiciel)
            ->with('success', 'Logiciel mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logiciel $logiciel)
    {
        $this->authorize('delete', $logiciel);

        try {
            // Vérifier s'il y a des installations
            if ($logiciel->installations_count > 0) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer le logiciel car il a des installations.');
            }

            // Supprimer les licences
            $logiciel->licences()->delete();
            
            $logiciel->delete();

            return redirect()->route('admin.logiciels.index')
                ->with('success', 'Logiciel supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erreur lors de la suppression du logiciel.');
        }
    }

    /**
     * Ajouter une licence
     */
    public function addLicence(Request $request, Logiciel $logiciel)
    {
        $this->authorize('manageLicenses', $logiciel);

        $validated = $request->validate([
            'cle_licence' => 'required|string|max:255|unique:licence_logiciels',
            'date_achat' => 'required|date',
            'date_expiration' => 'required|date|after_or_equal:date_achat',
            'nb_postes' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        LicenceLogiciel::create(array_merge($validated, [
            'logiciel_id' => $logiciel->id,
        ]));

        return redirect()->back()->with('success', 'Licence ajoutée avec succès.');
    }

    /**
     * Installer sur un actif
     */
    public function installer(Request $request, Logiciel $logiciel)
    {
        $this->authorize('manageInstallations', $logiciel);

        $validated = $request->validate([
            'licence_id' => 'required|exists:licence_logiciels,id',
            'actif_id' => 'required|exists:actifs_informatiques,id',
            'date_installation' => 'required|date',
        ]);

        $licence = LicenceLogiciel::findOrFail($validated['licence_id']);

        // Vérifier les postes disponibles
        if ($licence->postes_disponibles <= 0) {
            return redirect()->back()
                ->with('error', 'Aucun poste disponible sur cette licence.');
        }

        // Vérifier si déjà installé sur cet actif
        $existe = InstallationLogiciel::where('licence_logiciel_id', $licence->id)
            ->where('actif_informatique_id', $validated['actif_id'])
            ->exists();

        if ($existe) {
            return redirect()->back()
                ->with('error', 'Ce logiciel est déjà installé sur cet actif.');
        }

        InstallationLogiciel::create([
            'licence_logiciel_id' => $licence->id,
            'actif_informatique_id' => $validated['actif_id'],
            'date_installation' => $validated['date_installation'],
        ]);

        return redirect()->back()->with('success', 'Installation enregistrée avec succès.');
    }

    /**
     * Désinstaller
     */
    public function desinstaller(InstallationLogiciel $installation)
    {
        $this->authorize('manageInstallations', $installation->licence->logiciel);

        try {
            $installation->delete();
            return redirect()->back()->with('success', 'Installation supprimée.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    /**
     * Mettre à jour une licence
     */
    public function updateLicence(Request $request, LicenceLogiciel $licence)
    {
        $this->authorize('manageLicenses', $licence->logiciel);

        $validated = $request->validate([
            'cle_licence' => 'required|string|max:255|unique:licence_logiciels,cle_licence,' . $licence->id,
            'date_achat' => 'required|date',
            'date_expiration' => 'required|date|after_or_equal:date_achat',
            'nb_postes' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $licence->update($validated);

        return redirect()->back()->with('success', 'Licence mise à jour.');
    }

    /**
     * Supprimer une licence
     */
    public function deleteLicence(LicenceLogiciel $licence)
    {
        $this->authorize('manageLicenses', $licence->logiciel);

        try {
            // Vérifier les installations
            if ($licence->installations()->exists()) {
                return redirect()->back()
                    ->with('error', 'Impossible de supprimer la licence car elle a des installations.');
            }

            $licence->delete();
            return redirect()->back()->with('success', 'Licence supprimée.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression.');
        }
    }

    /**
     * Exporter les logiciels
     */
    public function export(Request $request)
    {
        $this->authorize('export-data');

        $logiciels = Logiciel::withCount(['licences', 'installations'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="logiciels_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($logiciels) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Nom', 'Éditeur', 'Version', 'Type', 'Nombre de licences', 
                'Installations', 'Postes utilisés', 'Postes disponibles'
            ]);

            foreach ($logiciels as $logiciel) {
                fputcsv($file, [
                    $logiciel->nom,
                    $logiciel->editeur,
                    $logiciel->version,
                    $logiciel->type,
                    $logiciel->licences_count,
                    $logiciel->installations_count,
                    $logiciel->postes_utilises,
                    $logiciel->postes_disponibles,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}