<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PieceJointe extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pieces_jointes';

    protected $fillable = [
        'objet_type',
        'objet_id',
        'nom_fichier',
        'chemin',
        'mime',
        'taille',
        'uploaded_by',
    ];

    protected $casts = [
        'taille' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Relation polymorphique: une pièce jointe peut appartenir à différents modèles
    public function objet()
    {
        return $this->morphTo();
    }

    // Une pièce jointe est uploadée par un utilisateur
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * MÉTHODES
     */

    public function getTailleFormateeAttribute()
    {
        $bytes = $this->taille;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getExtensionAttribute()
    {
        return pathinfo($this->nom_fichier, PATHINFO_EXTENSION);
    }

    public function estImage()
    {
        return str_starts_with($this->mime, 'image/');
    }

    public function estDocument()
    {
        return str_starts_with($this->mime, 'application/');
    }

    public function estPDF()
    {
        return $this->mime === 'application/pdf';
    }
}