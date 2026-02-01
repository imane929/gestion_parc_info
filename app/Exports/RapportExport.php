<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RapportExport implements FromCollection, WithHeadings, WithTitle, WithMapping, WithStyles
{
    protected $data;
    protected $type;
    protected $periode;
    
    public function __construct($data, $type, $periode)
    {
        $this->data = $data;
        $this->type = $type;
        $this->periode = $periode;
    }
    
    public function collection()
    {
        return collect($this->data);
    }
    
    public function headings(): array
    {
        switch ($this->type) {
            case 'equipements':
                return ['ID', 'Nom', 'Type', 'Marque', 'Modèle', 'Numéro de série', 'État', 'Localisation', 'Date d\'acquisition'];
            
            case 'utilisateurs':
                return ['ID', 'Nom', 'Email', 'Rôle', 'Date d\'inscription', 'Dernière connexion'];
            
            case 'tickets':
                return ['ID', 'Titre', 'Équipement', 'Description', 'Priorité', 'Statut', 'Technicien', 'Solution', 'Date d\'ouverture'];
            
            case 'affectations':
                return ['ID', 'Équipement', 'Utilisateur', 'Date d\'affectation', 'Date de retour', 'Raison', 'Statut'];
            
            default:
                return ['ID', 'Nom', 'Date'];
        }
    }
    
    public function map($item): array
    {
        switch ($this->type) {
            case 'equipements':
                return [
                    $item->id,
                    $item->nom,
                    $item->type,
                    $item->marque ?? '',
                    $item->modele ?? '',
                    $item->numero_serie ?? '',
                    $item->etat,
                    $item->localisation,
                    $item->date_acquisition ? date('d/m/Y', strtotime($item->date_acquisition)) : ''
                ];
            
            case 'utilisateurs':
                return [
                    $item->id,
                    $item->name,
                    $item->email,
                    $item->role,
                    $item->created_at->format('d/m/Y H:i'),
                    $item->last_login_at ? $item->last_login_at->format('d/m/Y H:i') : 'Jamais'
                ];
            
            case 'tickets':
                return [
                    $item->id,
                    $item->titre,
                    $item->equipement->nom ?? 'N/A',
                    $item->description,
                    $item->priorite,
                    $item->statut,
                    $item->technicien->name ?? 'Non assigné',
                    $item->solution ?? '',
                    $item->created_at->format('d/m/Y H:i')
                ];
            
            case 'affectations':
                return [
                    $item->id,
                    $item->equipement->nom ?? 'N/A',
                    $item->user->name ?? 'N/A',
                    $item->date_affectation->format('d/m/Y'),
                    $item->date_retour ? $item->date_retour->format('d/m/Y') : 'En cours',
                    $item->raison ?? '',
                    $item->date_retour ? 'Retourné' : 'Actif'
                ];
            
            default:
                return [$item->id, $item->name ?? 'N/A', $item->created_at->format('d/m/Y')];
        }
    }
    
    public function title(): string
    {
        return ucfirst($this->type);
    }
    
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => '4f46e5']
                ]
            ],
            
            // Style for entire sheet
            'A:Z' => [
                'alignment' => [
                    'wrapText' => true,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }
}