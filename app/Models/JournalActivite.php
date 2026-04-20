<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalActivite extends Model
{
    use HasFactory;

    protected $table = 'journal_activite';

    protected $fillable = [
        'utilisateur_id',
        'action',
        'objet_type',
        'objet_id',
        'ip',
        'user_agent',
        'donnees_avant',
        'donnees_apres',
    ];

    protected $casts = [
        'donnees_avant' => 'array',
        'donnees_apres' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une activité est réalisée par un utilisateur (peut être null pour les actions système)
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // Relation polymorphique: l'activité peut concerner différents modèles
    public function objet()
    {
        return $this->morphTo();
    }

    /**
     * SCOPES
     */

    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('utilisateur_id', $userId);
    }

    public function scopeParAction($query, $action)
    {
        return $query->where('action', $action);
    }

    public function scopeParObjet($query, $objetType, $objetId)
    {
        return $query->where('objet_type', $objetType)
                     ->where('objet_id', $objetId);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * MÉTHODES
     */

    public function getDescriptionAttribute()
    {
        $user = $this->utilisateur ? $this->utilisateur->full_name : 'Système';
        $action = $this->action;
        $objetType = class_basename($this->objet_type);
        
        return "{$user} a {$action} un(e) {$objetType}";
    }
}