<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActifInformatique extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'actifs_informatiques';

    protected $fillable = [
        'code_inventaire',
        'type',
        'marque',
        'modele',
        'numero_serie',
        'etat',
        'date_achat',
        'garantie_fin',
        'description',
        'localisation_id',
        'utilisateur_affecte_id',
    ];

    protected $casts = [
        'date_achat' => 'date',
        'garantie_fin' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un actif a une localisation
    public function localisation()
    {
        return $this->belongsTo(Localisation::class, 'localisation_id');
    }

    // Un actif peut être affecté à un utilisateur
    public function utilisateurAffecte()
    {
        return $this->belongsTo(User::class, 'utilisateur_affecte_id');
    }

    // Un actif a plusieurs affectations (historique)
    public function affectations()
    {
        return $this->hasMany(AffectationActif::class, 'actif_informatique_id');
    }

    // Un actif a plusieurs tickets de maintenance
    public function tickets()
    {
        return $this->hasMany(TicketMaintenance::class, 'actif_informatique_id');
    }

    // Un actif a plusieurs maintenances préventives
    public function maintenancesPreventives()
    {
        return $this->hasMany(MaintenancePreventive::class, 'actif_informatique_id');
    }

    // Un actif a plusieurs installations de logiciels
    public function installationsLogiciels()
    {
        return $this->hasMany(InstallationLogiciel::class, 'actif_informatique_id');
    }

    // Un actif a un historique de modifications
    public function historiques()
    {
        return $this->hasMany(HistoriqueActif::class, 'actif_informatique_id');
    }

    // Un actif peut avoir plusieurs commentaires
    public function commentaires()
    {
        return $this->morphMany(Commentaire::class, 'objet');
    }

    // Un actif peut avoir plusieurs pièces jointes
    public function piecesJointes()
    {
        return $this->morphMany(PieceJointe::class, 'objet');
    }

    /**
     * SCOPES
     */

    public function scopeParType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeParEtat($query, $etat)
    {
        return $query->where('etat', $etat);
    }

    public function scopeAvecGarantieValide($query)
    {
        return $query->whereNotNull('garantie_fin')
                     ->where('garantie_fin', '>=', now()->toDateString());
    }

    public function getGarantieFinAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return \Carbon\Carbon::parse($value);
    }

    public function scopeSansAffectation($query)
    {
        return $query->whereNull('utilisateur_affecte_id');
    }

    public function scopeRechercher($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('code_inventaire', 'like', "%{$search}%")
              ->orWhere('marque', 'like', "%{$search}%")
              ->orWhere('modele', 'like', "%{$search}%")
              ->orWhere('numero_serie', 'like', "%{$search}%");
        });
    }

    /**
     * MÉTHODES
     */

    public function getNomCompletAttribute()
    {
        return "{$this->marque} {$this->modele} ({$this->code_inventaire})";
    }

    public function getAgeAttribute()
    {
        if (!$this->date_achat) {
            return null;
        }
        
        return $this->date_achat->diffInYears(now());
    }

    public function getJoursRestantsGarantieAttribute()
    {
        if (!$this->garantie_fin) {
            return null;
        }
        
        return now()->diffInDays($this->garantie_fin, false);
    }

    public function garantieEstValide()
    {
        if (!$this->garantie_fin) {
            return false;
        }
        
        return $this->garantie_fin >= now();
    }

    public function estAffecte()
    {
        return !is_null($this->utilisateur_affecte_id);
    }

    public function affecterA(User $utilisateur)
    {
        // Créer une nouvelle affectation
        $affectation = AffectationActif::create([
            'actif_informatique_id' => $this->id,
            'utilisateur_id' => $utilisateur->id,
            'date_debut' => now(),
        ]);

        // Mettre à jour l'affectation actuelle
        $this->utilisateur_affecte_id = $utilisateur->id;
        $this->save();

        // Historique
        HistoriqueActif::create([
            'actif_informatique_id' => $this->id,
            'evenement' => 'affectation',
            'details' => "Affecté à {$utilisateur->full_name}",
        ]);

        return $affectation;
    }

    public function desaffecter()
    {
        // Clôturer l'affectation actuelle
        $affectation = $this->affectations()
            ->whereNull('date_fin')
            ->first();
            
        if ($affectation) {
            $affectation->date_fin = now();
            $affectation->save();
        }

        // Supprimer l'affectation actuelle
        $ancienUtilisateur = $this->utilisateurAffecte;
        $this->utilisateur_affecte_id = null;
        $this->save();

        // Historique
        if ($ancienUtilisateur) {
            HistoriqueActif::create([
                'actif_informatique_id' => $this->id,
                'evenement' => 'desaffectation',
                'details' => "Désaffecté de {$ancienUtilisateur->full_name}",
            ]);
        }

        return $this;
    }
}