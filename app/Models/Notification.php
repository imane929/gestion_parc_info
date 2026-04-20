<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'utilisateur_id',
        'type',
        'titre',
        'message',
        'lu_at',
        'canal',
        'meta',
    ];

    protected $casts = [
        'lu_at' => 'datetime',
        'meta' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une notification appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    /**
     * SCOPES
     */

    public function scopeNonLues($query)
    {
        return $query->whereNull('lu_at');
    }

    public function scopePourUtilisateur($query, $userId)
    {
        return $query->where('utilisateur_id', $userId);
    }

    public function scopeParType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * MÉTHODES
     */

    public function marquerCommeLue()
    {
        $this->lu_at = now();
        $this->save();
    }

    public function estLue()
    {
        return !is_null($this->lu_at);
    }
}