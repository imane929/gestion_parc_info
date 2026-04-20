<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UtilisateurSeeder extends Seeder
{
    public function run(): void
    {
        // Créer l'administrateur
        $admin = User::firstOrCreate(
            ['email' => 'admin@assetflow.com'],
            [
                'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
                'nom' => 'System',
                'prenom' => 'Admin',
                'telephone' => '0123456789',
                'password' => Hash::make('admin123'),
                'etat_compte' => 'actif',
                'email_verified_at' => now(),
            ]
        );
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Créer le gestionnaire IT
        $gestionnaire = User::firstOrCreate(
            ['email' => 'gestionnaire.it@assetflow.com'],
            [
                'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
                'nom' => 'Jourchi',
                'prenom' => 'Imane',
                'telephone' => '0123456790',
                'password' => Hash::make('gestionnaire123'),
                'etat_compte' => 'actif',
                'email_verified_at' => now(),
            ]
        );
        if (!$gestionnaire->hasRole('responsable_it')) {
            $gestionnaire->assignRole('responsable_it');
        }

        // Créer des techniciens
        $techniciens = [
            ['nom' => 'Jourchi', 'prenom' => 'Nizar', 'email' => 'nizarjourchi@assetflow.com'],
            ['nom' => 'Housni', 'prenom' => 'Siham', 'email' => 'sihamhousni@assetflow.com'],
            ['nom' => 'Rifak', 'prenom' => 'Meryem', 'email' => 'meryemrifak@assetflow.com'],
            ['nom' => 'Nkairi', 'prenom' => 'Dikra', 'email' => 'dikrankairi@assetflow.com'],
        ];

        foreach ($techniciens as $tech) {
            $technicien = User::firstOrCreate(
                ['email' => $tech['email']],
                [
                    'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
                    'nom' => $tech['nom'],
                    'prenom' => $tech['prenom'],
                    'telephone' => '01' . rand(234567, 989898),
                    'password' => Hash::make('technicien123'),
                    'etat_compte' => 'actif',
                    'email_verified_at' => now(),
                ]
            );
            if (!$technicien->hasRole('technicien')) {
                $technicien->assignRole('technicien');
            }
        }

        // Créer des utilisateurs standard
        for ($i = 1; $i <= 20; $i++) {
            $utilisateur = User::firstOrCreate(
                ['email' => 'user' . $i . '@assetflow.com'],
                [
                    'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
                    'nom' => 'Utilisateur' . $i,
                    'prenom' => 'Prénom' . $i,
                    'telephone' => '01' . rand(234567, 989898),
                    'password' => Hash::make('user123'),
                    'etat_compte' => 'actif',
                    'email_verified_at' => now(),
                ]
            );
            if (!$utilisateur->hasRole('utilisateur')) {
                $utilisateur->assignRole('utilisateur');
            }
        }

        // Créer un manager supplémentaire
        $manager = User::firstOrCreate(
            ['email' => 'manager@assetflow.com'],
            [
                'uuid' => \Ramsey\Uuid\Uuid::uuid4(),
                'nom' => 'Manager',
                'prenom' => 'Thomas',
                'telephone' => '0123456791',
                'password' => Hash::make('manager123'),
                'etat_compte' => 'actif',
                'email_verified_at' => now(),
            ]
        );
        if (!$manager->hasRole('manager')) {
            $manager->assignRole('manager');
        }

        // Sync to role_utilisateur table (custom pivot)
        $this->syncRoleUtilisateurTable();

        $this->command->info('Utilisateurs créés avec succès!');
    }

    private function syncRoleUtilisateurTable(): void
    {
        DB::table('role_utilisateur')->truncate();
        
        $users = User::all();
        foreach ($users as $user) {
            $roles = $user->roles()->get();
            foreach ($roles as $role) {
                DB::table('role_utilisateur')->insert([
                    'role_id' => $role->id,
                    'model_type' => 'App\\Models\\User',
                    'model_id' => $user->id,
                ]);
            }
        }
    }
}