<?php

namespace Database\Seeders;

use App\Models\ActifInformatique;
use App\Models\Localisation;
use App\Models\User;
use Illuminate\Database\Seeder;

class ActifInformatiqueSeeder extends Seeder
{
    public function run(): void
    {
        $localisations = Localisation::all();
        $utilisateurs = User::all(); // Utiliser tous les utilisateurs au cas où le filtre par rôle échoue
        $techniciens = User::all();

        if ($localisations->isEmpty()) {
            $this->command->warn('Aucune localisation trouvée. Skipping ActifInformatiqueSeeder.');
            return;
        }

        // Skip if already seeded
        if (ActifInformatique::where('code_inventaire', 'INV-PC-0001')->exists()) {
            $this->command->info('Actifs informatiques déjà créés, skipping...');
            return;
        }

        // Créer des PC
        for ($i = 1; $i <= 30; $i++) {
            $actif = ActifInformatique::create([
                'code_inventaire' => 'INV-PC-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'type' => 'pc',
                'marque' => $this->getMarquePC(),
                'modele' => $this->getModelePC(),
                'numero_serie' => 'SN-PC-' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'etat' => $this->getEtat(),
                'date_achat' => now()->subMonths(rand(0, 36)),
                'garantie_fin' => rand(0, 1) ? now()->addMonths(rand(1, 24)) : null,
                'localisation_id' => $localisations->random()->id,
                'utilisateur_affecte_id' => ($utilisateurs->isNotEmpty() && rand(0, 1)) ? $utilisateurs->random()->id : null,
            ]);

            // Créer des affectations historiques
            if ($actif->utilisateur_affecte_id) {
                \App\Models\AffectationActif::create([
                    'actif_informatique_id' => $actif->id,
                    'utilisateur_id' => $actif->utilisateur_affecte_id,
                    'date_debut' => $actif->date_achat->addDays(rand(1, 30)),
                ]);
            }
        }

        // Créer des imprimantes
        for ($i = 1; $i <= 10; $i++) {
            ActifInformatique::create([
                'code_inventaire' => 'INV-IMP-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'type' => 'imprimante',
                'marque' => $this->getMarqueImprimante(),
                'modele' => $this->getModeleImprimante(),
                'numero_serie' => 'SN-IMP-' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'etat' => $this->getEtat(),
                'date_achat' => now()->subMonths(rand(0, 48)),
                'garantie_fin' => rand(0, 1) ? now()->addMonths(rand(1, 12)) : null,
                'localisation_id' => $localisations->random()->id,
                'utilisateur_affecte_id' => null,
            ]);
        }

        // Créer des serveurs
        for ($i = 1; $i <= 5; $i++) {
            ActifInformatique::create([
                'code_inventaire' => 'INV-SRV-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'type' => 'serveur',
                'marque' => $this->getMarqueServeur(),
                'modele' => $this->getModeleServeur(),
                'numero_serie' => 'SN-SRV-' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'etat' => $this->getEtat(),
                'date_achat' => now()->subMonths(rand(0, 60)),
                'garantie_fin' => rand(0, 1) ? now()->addMonths(rand(1, 36)) : null,
                'localisation_id' => $localisations->where('site', 'Salle Serveurs')->random()->id,
                'utilisateur_affecte_id' => null,
            ]);
        }

        // Créer des équipements réseau
        for ($i = 1; $i <= 8; $i++) {
            ActifInformatique::create([
                'code_inventaire' => 'INV-RES-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'type' => 'reseau',
                'marque' => $this->getMarqueReseau(),
                'modele' => $this->getModeleReseau(),
                'numero_serie' => 'SN-RES-' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'etat' => $this->getEtat(),
                'date_achat' => now()->subMonths(rand(0, 48)),
                'garantie_fin' => rand(0, 1) ? now()->addMonths(rand(1, 24)) : null,
                'localisation_id' => $localisations->where('site', 'Salle Serveurs')->random()->id,
                'utilisateur_affecte_id' => null,
            ]);
        }

        $this->command->info('Actifs informatiques créés avec succès!');
    }

    private function getMarquePC(): string
    {
        $marques = ['Dell', 'HP', 'Lenovo', 'Apple', 'Asus', 'Acer'];
        return $marques[array_rand($marques)];
    }

    private function getModelePC(): string
    {
        $modeles = ['OptiPlex', 'ProDesk', 'ThinkCentre', 'iMac', 'VivoBook', 'Aspire'];
        $numeros = ['3040', '400G5', 'M720q', '27"', 'X515', 'A315'];
        return $modeles[array_rand($modeles)] . ' ' . $numeros[array_rand($numeros)];
    }

    private function getMarqueImprimante(): string
    {
        $marques = ['HP', 'Epson', 'Brother', 'Canon', 'Xerox'];
        return $marques[array_rand($marques)];
    }

    private function getModeleImprimante(): string
    {
        $modeles = ['LaserJet', 'WorkForce', 'HL-L', 'imageRUNNER', 'VersaLink'];
        $numeros = ['Pro M404', 'Pro 7720', '2350DW', 'C3025', 'C400'];
        return $modeles[array_rand($modeles)] . ' ' . $numeros[array_rand($numeros)];
    }

    private function getMarqueServeur(): string
    {
        $marques = ['Dell', 'HP', 'IBM', 'Supermicro', 'Fujitsu'];
        return $marques[array_rand($marques)];
    }

    private function getModeleServeur(): string
    {
        $modeles = ['PowerEdge', 'ProLiant', 'System x', 'SuperServer', 'PRIMERGY'];
        $numeros = ['R740', 'DL380', '3650M5', 'SYS-2029', 'RX2540'];
        return $modeles[array_rand($modeles)] . ' ' . $numeros[array_rand($numeros)];
    }

    private function getMarqueReseau(): string
    {
        $marques = ['Cisco', 'HP', 'Juniper', 'Ubiquiti', 'Netgear'];
        return $marques[array_rand($marques)];
    }

    private function getModeleReseau(): string
    {
        $modeles = ['Catalyst', 'Aruba', 'EX Series', 'UniFi', 'GS Series'];
        $numeros = ['2960X', '2930F', '2300', 'USG', '752TP'];
        return $modeles[array_rand($modeles)] . ' ' . $numeros[array_rand($numeros)];
    }

    private function getEtat(): string
    {
        $etats = ['neuf', 'bon', 'moyen', 'mauvais'];
        $probas = [10, 60, 25, 5]; // Probabilités en pourcentage
        $rand = rand(1, 100);
        $cumul = 0;
        
        foreach ($probas as $index => $prob) {
            $cumul += $prob;
            if ($rand <= $cumul) {
                return $etats[$index];
            }
        }
        
        return 'bon';
    }
}