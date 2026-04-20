<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intervention extends Model
{
    use HasFactory;

    protected $table = 'interventions';

    protected $fillable = [
        'ticket_maintenance_id',
        'technicien_id',
        'date',
        'travaux',
        'temps_passe',
        'notes',
        'rapport',
    ];

    protected $casts = [
        'date' => 'date',
        'temps_passe' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * RELATIONS
     */

    // Une intervention appartient à un ticket
    public function ticket()
    {
        return $this->belongsTo(TicketMaintenance::class, 'ticket_maintenance_id');
    }

    // Une intervention est réalisée par un technicien
    public function technicien()
    {
        return $this->belongsTo(User::class, 'technicien_id');
    }

    /**
     * SCOPES
     */

    public function scopePourTicket($query, $ticketId)
    {
        return $query->where('ticket_maintenance_id', $ticketId);
    }

    public function scopePourTechnicien($query, $technicienId)
    {
        return $query->where('technicien_id', $technicienId);
    }

    public function scopeParPeriode($query, $debut, $fin)
    {
        return $query->whereBetween('date', [$debut, $fin]);
    }

    /**
     * MÉTHODES
     */

    public function getTempsFormateAttribute()
    {
        $heures = floor($this->temps_passe / 60);
        $minutes = $this->temps_passe % 60;
        
        if ($heures > 0) {
            return "{$heures}h {$minutes}min";
        }
        
        return "{$minutes}min";
    }

    public function getDateFormateeAttribute()
    {
        return $this->date->format('d/m/Y');
    }
}