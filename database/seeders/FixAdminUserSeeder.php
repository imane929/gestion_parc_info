<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FixAdminUserSeeder extends Seeder
{
    public function run()
    {
        // Clear cache first - CRITICAL for Spatie permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Get or create admin role
        $adminRole = Role::firstOrCreate(
            ['code' => 'admin'],
            [
                'name' => 'admin',
                'libelle' => 'Administrateur',
                'guard_name' => 'web',
                'description' => 'Administrateur système avec tous les droits'
            ]
        );

        // Get all permissions and assign to admin role
        $allPermissions = Permission::all();
        $adminRole->syncPermissions($allPermissions);

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

        // Assign admin role (this also syncs all permissions)
        $admin->assignRole('admin');
        
        // Also insert into role_utilisateur table (for custom hasRoleByCode)
        DB::table('role_utilisateur')->updateOrInsert(
            [
                'role_id' => $adminRole->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $admin->id,
            ],
            [
                'role_id' => $adminRole->id,
                'model_type' => 'App\\Models\\User',
                'model_id' => $admin->id,
            ]
        );
        
        // Explicitly sync all permissions to the admin user as well
        // This ensures the admin has direct permissions in addition to role permissions
        $admin->syncPermissions($allPermissions);

        // Clear cache again after assignments
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Admin user: admin@parc-informatique.test / password');
        $this->command->info('Admin role has ' . $allPermissions->count() . ' permissions');
        $this->command->info('Admin user has been assigned admin role and all permissions');
    }
}
