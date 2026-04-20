<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueActif extends Model
{
    use HasFactory;

    protected $table = 'historique_actifs';

    protected $fillable = [
        'actif_informatique_id',
        'evenement',
        'details',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Un historique appartient à un actif
    public function actif()
    {
        return $this->belongsTo(ActifInformatique::class, 'actif_informatique_id');
    }

    /**
     * SCOPES
     */

    public function scopeParEvenement($query, $evenement)
    {
        return $query->where('evenement', $evenement);
    }

    public function scopeRecent($query, $limit = 50)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    /**
     * MÉTHODES
     */

    public function getDateFormateeAttribute()
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}