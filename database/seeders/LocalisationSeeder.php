<?php

namespace Database\Seeders;

use App\Models\Localisation;
use Illuminate\Database\Seeder;

class LocalisationSeeder extends Seeder
{
    public function run(): void
    {
        $localisations = [
            ['site' => 'Siège', 'batiment' => 'Principal', 'etage' => '1', 'bureau' => '101'],
            ['site' => 'Siège', 'batiment' => 'Principal', 'etage' => '1', 'bureau' => '102'],
            ['site' => 'Siège', 'batiment' => 'Principal', 'etage' => '2', 'bureau' => '201'],
            ['site' => 'Siège', 'batiment' => 'Principal', 'etage' => '2', 'bureau' => '202'],
            ['site' => 'Siège', 'batiment' => 'Principal', 'etage' => '3', 'bureau' => '301'],
            ['site' => 'Siège', 'batiment' => 'Principal', 'etage' => '3', 'bureau' => '302'],
            ['site' => 'Agence Paris', 'batiment' => 'Tour A', 'etage' => '5', 'bureau' => '501'],
            ['site' => 'Agence Paris', 'batiment' => 'Tour A', 'etage' => '5', 'bureau' => '502'],
            ['site' => 'Agence Lyon', 'batiment' => 'Centre', 'etage' => '2', 'bureau' => '210'],
            ['site' => 'Agence Lyon', 'batiment' => 'Centre', 'etage' => '2', 'bureau' => '211'],
            ['site' => 'Agence Marseille', 'batiment' => 'Port', 'etage' => '1', 'bureau' => '110'],
            ['site' => 'Agence Marseille', 'batiment' => 'Port', 'etage' => '1', 'bureau' => '111'],
            ['site' => 'Salle Serveurs', 'batiment' => 'Principal', 'etage' => 'RDC', 'bureau' => 'Salle 01'],
            ['site' => 'Salle Serveurs', 'batiment' => 'Principal', 'etage' => 'RDC', 'bureau' => 'Salle 02'],
        ];

        foreach ($localisations as $localisation) {
            Localisation::firstOrCreate([
                'site' => $localisation['site'],
                'batiment' => $localisation['batiment'],
                'etage' => $localisation['etage'],
                'bureau' => $localisation['bureau'],
            ], $localisation);
        }

        $this->command->info('Localisations créées avec succès!');
    }
}