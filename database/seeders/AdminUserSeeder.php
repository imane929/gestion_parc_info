<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrateur',
            'email' => 'admin@parc.com',
            'password' => Hash::make('admin@123'),
            'role' => 'admin',
        ]);

        // Create technician user
        User::create([
            'name' => 'Technicien',
            'email' => 'tech@parc.com',
            'password' => Hash::make('tech@123'),
            'role' => 'technicien',
        ]);

        // Create regular user
        User::create([
            'name' => 'Utilisateur Test',
            'email' => 'user@parc.com',
            'password' => Hash::make('user@123'),
            'role' => 'utilisateur',
        ]);
    }
}