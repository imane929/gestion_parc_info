<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketMaintenance extends Model
{
    use HasFactory ;

    protected $table = 'tickets_maintenance';

    protected $fillable = [
        'numero',
        'actif_informatique_id',
        'sujet',
        'description',
        'priorite',
        'statut',
        'assigne_a',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un ticket appartient à un actif (optionnel)
    public function actif()
    {
        return $this->belongsTo(ActifInformatique::class, 'actif_informatique_id');
    }

    // Un ticket est créé par un utilisateur
    public function createur()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Un ticket peut être assigné à un utilisateur (technicien)
    public function assigneA()
    {
        return $this->belongsTo(User::class, 'assigne_a');
    }

    // Un ticket peut avoir plusieurs interventions
    public function interventions()
    {
        return $this->hasMany(Intervention::class, 'ticket_maintenance_id');
    }

    // Un ticket peut avoir plusieurs commentaires
    public function commentaires()
    {
        return $this->morphMany(Commentaire::class, 'objet');
    }

    // Un ticket peut avoir plusieurs pièces jointes
    public function piecesJointes()
    {
        return $this->morphMany(PieceJointe::class, 'objet');
    }

    /**
     * SCOPES
     */

    public function scopeOuverts($query)
    {
        return $query->where('statut', 'ouvert');
    }

    public function scopeEnCours($query)
    {
        return $query->where('statut', 'en_cours');
    }

    public function scopeResolus($query)
    {
        return $query->where('statut', 'resolu');
    }

    public function scopeParPriorite($query, $priorite)
    {
        return $query->where('priorite', $priorite);
    }

    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('created_by', $userId)
              ->orWhere('assigne_a', $userId);
        });
    }

    public function scopeRecents($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * MÉTHODES
     */

    public function getDureeOuvertureAttribute()
    {
        if ($this->statut === 'resolu' || $this->statut === 'ferme') {
            // Trouver la dernière intervention pour avoir la date de résolution
            $derniereIntervention = $this->interventions()->latest()->first();
            $dateFin = $derniereIntervention ? $derniereIntervention->created_at : $this->updated_at;
            
            return $this->created_at->diffInDays($dateFin);
        }
        
        return $this->created_at->diffInDays(now());
    }

    public function estOuvert()
    {
        return $this->statut === 'ouvert';
    }

    public function estEnCours()
    {
        return $this->statut === 'en_cours';
    }

    public function estResolu()
    {
        return $this->statut === 'resolu';
    }

    public function assignerA(User $technicien)
    {
        $this->assigne_a = $technicien->id;
        $this->statut = 'en_cours';
        $this->save();
        
        return $this;
    }

    public function resoudre()
    {
        $this->statut = 'resolu';
        $this->save();
        
        return $this;
    }

    public function fermer()
    {
        $this->statut = 'ferme';
        $this->save();
        
        return $this;
    }

    public function getTempsTotalInterventionAttribute()
    {
        return $this->interventions()->sum('temps_passe');
    }

    public function getInterventionsCountAttribute()
    {
        return $this->interventions()->count();
    }
}