<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EnsureAdminRoleSeeder extends Seeder
{
    public function run()
    {
        // Find or create admin role
        $adminRole = Role::firstOrCreate(
            ['code' => 'admin'],
            [
                'name' => 'admin',
                'libelle' => 'Administrateur',
                'guard_name' => 'web',
                'description' => 'Administrateur système avec tous les droits'
            ]
        );

        // Ensure the name field is set correctly
        if ($adminRole->name !== 'admin') {
            $adminRole->name = 'admin';
            $adminRole->save();
        }

        // Find or create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@parc-informatique.test'],
            [
                'nom' => 'Admin',
                'prenom' => 'System',
                'password' => Hash::make('password'),
                'etat_compte' => 'actif',
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role
        if (!$admin->hasRoleByCode('admin')) {
            $admin->assignRole($adminRole);
        }

        $this->command->info('Admin user ensured with email: admin@parc-informatique.test');
    }
}