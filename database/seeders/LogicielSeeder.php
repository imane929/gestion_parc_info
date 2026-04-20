<?php

namespace Database\Seeders;

use App\Models\LicenceLogiciel;
use App\Models\Logiciel;
use Illuminate\Database\Seeder;

class LogicielSeeder extends Seeder
{
    public function run(): void
    {
        $logiciels = [
            // Systèmes d'exploitation
            ['nom' => 'Windows 10 Pro', 'editeur' => 'Microsoft', 'version' => '22H2', 'type' => 'os'],
            ['nom' => 'Windows 11 Pro', 'editeur' => 'Microsoft', 'version' => '23H2', 'type' => 'os'],
            ['nom' => 'Ubuntu Server', 'editeur' => 'Canonical', 'version' => '22.04 LTS', 'type' => 'os'],
            ['nom' => 'Red Hat Enterprise Linux', 'editeur' => 'Red Hat', 'version' => '8.7', 'type' => 'os'],
            
            // Suite bureautique
            ['nom' => 'Microsoft Office', 'editeur' => 'Microsoft', 'version' => '2021', 'type' => 'bureau'],
            ['nom' => 'Adobe Acrobat Pro', 'editeur' => 'Adobe', 'version' => '2023', 'type' => 'bureau'],
            ['nom' => 'LibreOffice', 'editeur' => 'The Document Foundation', 'version' => '7.5', 'type' => 'bureau'],
            
            // Développement
            ['nom' => 'Visual Studio Code', 'editeur' => 'Microsoft', 'version' => '1.85', 'type' => 'bureau'],
            ['nom' => 'PHPStorm', 'editeur' => 'JetBrains', 'version' => '2023.3', 'type' => 'bureau'],
            ['nom' => 'Git', 'editeur' => 'Git', 'version' => '2.42', 'type' => 'bureau'],
            
            // Bases de données
            ['nom' => 'Microsoft SQL Server', 'editeur' => 'Microsoft', 'version' => '2022', 'type' => 'serveur'],
            ['nom' => 'MySQL', 'editeur' => 'Oracle', 'version' => '8.0', 'type' => 'serveur'],
            ['nom' => 'PostgreSQL', 'editeur' => 'PostgreSQL', 'version' => '15', 'type' => 'serveur'],
            
            // Virtualisation
            ['nom' => 'VMware vSphere', 'editeur' => 'VMware', 'version' => '8.0', 'type' => 'serveur'],
            ['nom' => 'Docker Desktop', 'editeur' => 'Docker', 'version' => '4.25', 'type' => 'bureau'],
            
            // Sécurité
            ['nom' => 'Norton Antivirus', 'editeur' => 'Norton', 'version' => '2024', 'type' => 'bureau'],
            ['nom' => 'Malwarebytes', 'editeur' => 'Malwarebytes', 'version' => '4.6', 'type' => 'bureau'],
            
            // Graphisme
            ['nom' => 'Adobe Photoshop', 'editeur' => 'Adobe', 'version' => '2024', 'type' => 'bureau'],
            ['nom' => 'AutoCAD', 'editeur' => 'Autodesk', 'version' => '2024', 'type' => 'bureau'],
        ];

        foreach ($logiciels as $logicielData) {
            $existingLogiciel = Logiciel::where('nom', $logicielData['nom'])->first();
            if ($existingLogiciel) {
                $logiciel = $existingLogiciel;
            } else {
                $logiciel = Logiciel::create($logicielData);
            }

            // Créer des licences pour chaque logiciel (only if no licences exist)
            $existingLicences = LicenceLogiciel::where('logiciel_id', $logiciel->id)->count();
            if ($existingLicences > 0) {
                continue;
            }

            $nbLicences = match($logiciel->type) {
                'os' => rand(2, 5),
                'bureau' => rand(5, 20),
                'serveur' => rand(1, 3),
                default => rand(1, 5)
            };

            for ($i = 1; $i <= $nbLicences; $i++) {
                LicenceLogiciel::create([
                    'logiciel_id' => $logiciel->id,
                    'cle_licence' => 'LIC-' . strtoupper(substr($logiciel->nom, 0, 3)) . '-' . 
                                     str_pad($logiciel->id, 3, '0', STR_PAD_LEFT) . '-' . 
                                     str_pad($i, 3, '0', STR_PAD_LEFT) . '-' . 
                                     strtoupper(\Illuminate\Support\Str::random(8)),
                    'date_achat' => now()->subMonths(rand(1, 36)),
                    'date_expiration' => now()->addMonths(rand(6, 48)),
                    'nb_postes' => match($logiciel->type) {
                        'os' => 1,
                        'bureau' => rand(5, 50),
                        'serveur' => rand(1, 10),
                        default => rand(1, 10)
                    },
                ]);
            }
        }

        $this->command->info('Logiciels et licences créés avec succès!');
    }
}