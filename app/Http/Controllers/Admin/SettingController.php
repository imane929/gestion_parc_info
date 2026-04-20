<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parametre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Afficher la page des paramètres
     */
    public function index()
    {
        $this->authorize('settings.view');

        $parametres = Parametre::orderBy('groupe')->orderBy('cle')->get();
        $groupes = Parametre::distinct()->pluck('groupe');

        return view('admin.settings.index', compact('parametres', 'groupes'));
    }

    /**
     * Afficher les paramètres par groupe
     */
    public function groupe($groupe)
    {
        $this->authorize('settings.view');

        $parametres = Parametre::where('groupe', $groupe)->orderBy('cle')->get();
        
        if ($parametres->isEmpty()) {
            abort(404, 'Groupe de paramètres non trouvé');
        }

        return view('admin.settings.groupe', compact('parametres', 'groupe'));
    }

    /**
     * Afficher le formulaire d'édition d'un paramètre
     */
    public function edit(Parametre $parametre)
    {
        $this->authorize('settings.edit');

        $types = [
            'string' => 'Texte',
            'text' => 'Texte long',
            'integer' => 'Nombre entier',
            'decimal' => 'Nombre décimal',
            'boolean' => 'Oui/Non',
            'email' => 'Email',
            'url' => 'URL',
            'date' => 'Date',
            'json' => 'JSON',
        ];

        return view('admin.settings.edit', compact('parametre', 'types'));
    }

    /**
     * Mettre à jour un paramètre
     */
    public function update(Request $request, Parametre $parametre)
    {
        $this->authorize('settings.edit');

        $validated = $request->validate([
            'valeur' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $parametre->update($validated);

        // Vider le cache des paramètres
        Cache::forget('parametre_' . $parametre->cle);

        return redirect()->route('admin.settings.groupe', $parametre->groupe)
            ->with('success', 'Paramètre mis à jour.');
    }

    /**
     * Mettre à jour plusieurs paramètres
     */
    public function updateMultiple(Request $request)
    {
        $this->authorize('settings.edit');

        $groupe = $request->input('groupe');
        
        foreach ($request->all() as $key => $value) {
            if (str_starts_with($key, 'param_')) {
                $cle = substr($key, 6); // Enlever 'param_'
                
                $parametre = Parametre::where('groupe', $groupe)
                    ->where('cle', $cle)
                    ->first();
                
                if ($parametre) {
                    $parametre->update(['valeur' => $value]);
                    
                    // Vider le cache
                    Cache::forget('parametre_' . $cle);
                }
            }
        }

        return redirect()->route('admin.settings.groupe', $groupe)
            ->with('success', 'Paramètres mis à jour.');
    }

    /**
     * Créer un nouveau paramètre
     */
    public function create()
    {
        $this->authorize('settings.edit');

        $groupes = Parametre::distinct()->pluck('groupe');
        $types = [
            'string' => 'Texte',
            'text' => 'Texte long',
            'integer' => 'Nombre entier',
            'decimal' => 'Nombre décimal',
            'boolean' => 'Oui/Non',
            'email' => 'Email',
            'url' => 'URL',
            'date' => 'Date',
            'json' => 'JSON',
        ];

        return view('admin.settings.create', compact('groupes', 'types'));
    }

    /**
     * Stocker un nouveau paramètre
     */
    public function store(Request $request)
    {
        $this->authorize('settings.edit');

        $validated = $request->validate([
            'cle' => 'required|string|max:100|unique:parametres',
            'valeur' => 'required|string',
            'groupe' => 'required|string|max:50',
            'description' => 'nullable|string',
            'type' => 'required|in:string,text,integer,decimal,boolean,email,url,date,json',
        ]);

        Parametre::create($validated);

        return redirect()->route('admin.settings.groupe', $validated['groupe'])
            ->with('success', 'Paramètre créé.');
    }

    /**
     * Supprimer un paramètre
     */
    public function destroy(Parametre $parametre)
    {
        $this->authorize('settings.edit');

        // Empêcher la suppression des paramètres système critiques
        $parametresCritiques = ['app_name', 'app_version', 'email_from_address'];
        
        if (in_array($parametre->cle, $parametresCritiques)) {
            return redirect()->back()
                ->with('error', 'Impossible de supprimer ce paramètre système.');
        }

        $groupe = $parametre->groupe;
        $parametre->delete();

        // Vider le cache
        Cache::forget('parametre_' . $parametre->cle);

        return redirect()->route('admin.settings.groupe', $groupe)
            ->with('success', 'Paramètre supprimé.');
    }

    /**
     * Réinitialiser les paramètres par défaut
     */
    public function reset(Request $request)
    {
        $this->authorize('settings.edit');

        $groupe = $request->input('groupe');

        // Définir les valeurs par défaut selon le groupe
        $defaults = $this->getDefaultValues($groupe);

        foreach ($defaults as $cle => $valeur) {
            $parametre = Parametre::where('groupe', $groupe)
                ->where('cle', $cle)
                ->first();
            
            if ($parametre) {
                $parametre->update(['valeur' => $valeur]);
                Cache::forget('parametre_' . $cle);
            }
        }

        return redirect()->route('admin.settings.groupe', $groupe)
            ->with('success', 'Paramètres réinitialisés aux valeurs par défaut.');
    }

    /**
     * Obtenir les valeurs par défaut
     */
    private function getDefaultValues($groupe)
    {
        $defaults = [
            'systeme' => [
                'app_name' => 'Gestion Parc Informatique',
                'app_version' => '1.0.0',
                'maintenance_mode' => 'false',
            ],
            'email' => [
                'email_from_address' => 'noreply@parc-informatique.test',
                'email_from_name' => 'Gestion Parc Informatique',
                'email_notifications' => 'true',
            ],
            'tickets' => [
                'ticket_auto_assign' => 'false',
                'ticket_priority_default' => 'moyenne',
                'ticket_response_time' => '24',
                'ticket_resolution_time' => '72',
            ],
            'actifs' => [
                'asset_warranty_alert_days' => '30',
                'asset_maintenance_interval' => '180',
                'asset_inventory_prefix' => 'INV',
            ],
            'licences' => [
                'license_expiration_alert_days' => '60',
                'license_auto_renewal' => 'false',
            ],
        ];

        return $defaults[$groupe] ?? [];
    }

    /**
     * Importer des paramètres
     */
    public function import(Request $request)
    {
        $this->authorize('settings.edit');

        $request->validate([
            'fichier' => 'required|file|mimes:json',
        ]);

        $contenu = file_get_contents($request->file('fichier')->getRealPath());
        $parametres = json_decode($contenu, true);

        if (!is_array($parametres)) {
            return redirect()->back()
                ->with('error', 'Format de fichier invalide.');
        }

        DB::beginTransaction();
        try {
            foreach ($parametres as $parametre) {
                Parametre::updateOrCreate(
                    ['cle' => $parametre['cle']],
                    [
                        'valeur' => $parametre['valeur'],
                        'groupe' => $parametre['groupe'],
                        'description' => $parametre['description'] ?? null,
                    ]
                );
            }

            DB::commit();
            
            // Vider tout le cache des paramètres
            Cache::flush();

            return redirect()->route('admin.settings.index')
                ->with('success', 'Paramètres importés avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erreur lors de l\'importation.');
        }
    }

    /**
     * Exporter des paramètres
     */
    public function export(Request $request)
    {
        $this->authorize('settings.view');

        $groupe = $request->input('groupe');
        
        $query = Parametre::query();
        if ($groupe) {
            $query->where('groupe', $groupe);
        }

        $parametres = $query->get()->map(function($param) {
            return [
                'cle' => $param->cle,
                'valeur' => $param->valeur,
                'groupe' => $param->groupe,
                'description' => $param->description,
                'created_at' => $param->created_at,
                'updated_at' => $param->updated_at,
            ];
        });

        $filename = $groupe ? "parametres_{$groupe}" : 'parametres';
        $filename .= '_' . date('Y-m-d') . '.json';

        return response()->json($parametres, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}