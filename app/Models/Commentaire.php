<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commentaire extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'commentaires';

    protected $fillable = [
        'utilisateur_id',
        'objet_type',
        'objet_id',
        'contenu',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un commentaire appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    // Relation polymorphique: un commentaire peut concerner différents modèles
    public function objet()
    {
        return $this->morphTo();
    }

    /**
     * SCOPES
     */

    public function scopePourObjet($query, $objetType, $objetId)
    {
        return $query->where('objet_type', $objetType)
                     ->where('objet_id', $objetId);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * MÉTHODES
     */

    public function getAuteurAttribute()
    {
        return $this->utilisateur ? $this->utilisateur->full_name : 'Utilisateur inconnu';
    }

    public function getDateFormateeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    public function getContenuTronqueAttribute($length = 100)
    {
        if (strlen($this->contenu) <= $length) {
            return $this->contenu;
        }
        
        return substr($this->contenu, 0, $length) . '...';
    }
}