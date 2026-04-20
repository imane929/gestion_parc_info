<?php

namespace Database\Seeders;

use App\Models\Adresse;
use App\Models\ContratMaintenance;
use App\Models\Prestataire;
use Illuminate\Database\Seeder;

class PrestataireSeeder extends Seeder
{
    public function run(): void
    {
        $prestataires = [
            [
                'nom' => 'TechServices SARL',
                'telephone' => '01 23 45 67 89',
                'email' => 'contact@techservices.fr',
                'adresse' => [
                    'pays' => 'France',
                    'ville' => 'Paris',
                    'quartier' => 'La Défense',
                    'rue' => '15 Avenue de l\'Arche',
                    'code_postal' => '92044',
                ],
            ],
            [
                'nom' => 'Maintenance Pro',
                'telephone' => '04 56 78 90 12',
                'email' => 'info@maintenance-pro.fr',
                'adresse' => [
                    'pays' => 'France',
                    'ville' => 'Lyon',
                    'quartier' => 'Part-Dieu',
                    'rue' => '25 Rue de la République',
                    'code_postal' => '69002',
                ],
            ],
            [
                'nom' => 'IT Solutions',
                'telephone' => '02 34 56 78 90',
                'email' => 'support@itsolutions.fr',
                'adresse' => [
                    'pays' => 'France',
                    'ville' => 'Marseille',
                    'quartier' => 'Vieux-Port',
                    'rue' => '8 Quai du Port',
                    'code_postal' => '13002',
                ],
            ],
            [
                'nom' => 'Network Experts',
                'telephone' => '03 45 67 89 01',
                'email' => 'services@network-experts.fr',
                'adresse' => [
                    'pays' => 'France',
                    'ville' => 'Toulouse',
                    'quartier' => 'Capitole',
                    'rue' => '12 Place du Capitole',
                    'code_postal' => '31000',
                ],
            ],
            [
                'nom' => 'Software Licensing Corp',
                'telephone' => '01 98 76 54 32',
                'email' => 'licensing@software-corp.fr',
                'adresse' => [
                    'pays' => 'France',
                    'ville' => 'Nantes',
                    'quartier' => 'Centre',
                    'rue' => '5 Rue de la Fosse',
                    'code_postal' => '44000',
                ],
            ],
        ];

        foreach ($prestataires as $prestataireData) {
            // Check if prestataire already exists
            $existingPrestataire = Prestataire::where('email', $prestataireData['email'])->first();
            if ($existingPrestataire) {
                continue;
            }

            // Créer l'adresse
            $adresse = Adresse::create($prestataireData['adresse']);

            // Créer le prestataire
            $prestataire = Prestataire::create([
                'nom' => $prestataireData['nom'],
                'telephone' => $prestataireData['telephone'],
                'email' => $prestataireData['email'],
                'adresse_id' => $adresse->id,
            ]);

            // Créer des contrats pour chaque prestataire
            $nbContrats = rand(1, 3);
            for ($i = 1; $i <= $nbContrats; $i++) {
                ContratMaintenance::create([
                    'prestataire_id' => $prestataire->id,
                    'numero' => 'CONTRAT-' . strtoupper(substr($prestataire->nom, 0, 3)) . '-' . 
                                str_pad($prestataire->id, 3, '0', STR_PAD_LEFT) . '-' . 
                                str_pad($i, 3, '0', STR_PAD_LEFT),
                    'date_debut' => now()->subMonths(rand(1, 12)),
                    'date_fin' => now()->addMonths(rand(6, 36)),
                    'sla' => $this->generateSLA(),
                ]);
            }
        }

        $this->command->info('Prestataires et contrats créés avec succès!');
    }

    private function generateSLA(): string
    {
        $slas = [
            "Temps de réponse: 2 heures ouvrables\nRésolution: 24 heures\nDisponibilité: 99.9%",
            "Temps de réponse: 4 heures\nRésolution: 48 heures\nDisponibilité: 99.5%",
            "Temps de réponse: 1 heure (urgent)\nRésolution: 8 heures\nDisponibilité: 99.99%",
            "Support 24/7\nTemps de réponse: 30 minutes\nRésolution: 4 heures\nDisponibilité: 99.95%",
        ];
        
        return $slas[array_rand($slas)];
    }
}