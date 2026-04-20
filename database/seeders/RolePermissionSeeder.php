<?php

namespace Database\Seeders;

use App\Models\Permission as SpatiePermission;
use App\Models\Role as SpatieRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Nettoyer les tables
        DB::table('permission_role')->delete();
        DB::table('role_utilisateur')->delete();
        DB::table('permissions')->delete();
        DB::table('roles')->delete();

        // Créer les rôles
        $roles = [
            [
                'name' => 'admin',
                'code' => 'admin',
                'libelle' => 'Administrateur système',
                'description' => 'Accès complet à toutes les fonctionnalités',
                'guard_name' => 'web',
            ],
            [
                'name' => 'responsable_it',
                'code' => 'responsable_it',
                'libelle' => 'Responsable informatique',
                'description' => 'Gestion du parc informatique et des tickets',
                'guard_name' => 'web',
            ],
            [
                'name' => 'technicien',
                'code' => 'technicien',
                'libelle' => 'Technicien informatique',
                'description' => 'Intervention sur les équipements et tickets',
                'guard_name' => 'web',
            ],
            [
                'name' => 'utilisateur',
                'code' => 'utilisateur',
                'libelle' => 'Utilisateur standard',
                'description' => 'Accès aux fonctionnalités de base',
                'guard_name' => 'web',
            ],
            [
                'name' => 'manager',
                'code' => 'manager',
                'libelle' => 'Manager',
                'description' => 'Gestion des équipes et rapports',
                'guard_name' => 'web',
            ],
        ];

        foreach ($roles as $roleData) {
            SpatieRole::firstOrCreate(['name' => $roleData['name'], 'guard_name' => $roleData['guard_name']], $roleData);
        }

        // Créer les permissions
        $permissions = [
            // Gestion des utilisateurs - deux formats
            ['name' => 'users.view', 'code' => 'users.view', 'libelle' => 'Voir les utilisateurs'],
            ['name' => 'users.create', 'code' => 'users.create', 'libelle' => 'Créer des utilisateurs'],
            ['name' => 'users.edit', 'code' => 'users.edit', 'libelle' => 'Modifier les utilisateurs'],
            ['name' => 'users.delete', 'code' => 'users.delete', 'libelle' => 'Supprimer des utilisateurs'],
            ['name' => 'users.change-roles', 'code' => 'users.change-roles', 'libelle' => 'Changer les rôles des utilisateurs'],
            // Alias
            ['name' => 'view users', 'code' => 'view users', 'libelle' => 'Voir les utilisateurs'],
            ['name' => 'create users', 'code' => 'create users', 'libelle' => 'Créer des utilisateurs'],
            ['name' => 'edit users', 'code' => 'edit users', 'libelle' => 'Modifier les utilisateurs'],
            ['name' => 'delete users', 'code' => 'delete users', 'libelle' => 'Supprimer des utilisateurs'],
            
            // Gestion des rôles - deux formats
            ['name' => 'roles.view', 'code' => 'roles.view', 'libelle' => 'Voir les rôles'],
            ['name' => 'roles.create', 'code' => 'roles.create', 'libelle' => 'Créer des rôles'],
            ['name' => 'roles.edit', 'code' => 'roles.edit', 'libelle' => 'Modifier les rôles'],
            ['name' => 'roles.delete', 'code' => 'roles.delete', 'libelle' => 'Supprimer des rôles'],
            ['name' => 'roles.assign-permissions', 'code' => 'roles.assign-permissions', 'libelle' => 'Assigner des permissions aux rôles'],
            // Alias
            ['name' => 'view roles', 'code' => 'view roles', 'libelle' => 'Voir les rôles'],
            ['name' => 'create roles', 'code' => 'create roles', 'libelle' => 'Créer des rôles'],
            ['name' => 'edit roles', 'code' => 'edit roles', 'libelle' => 'Modifier les rôles'],
            ['name' => 'delete roles', 'code' => 'delete roles', 'libelle' => 'Supprimer des rôles'],
            
            // Gestion des actifs - deux formats
            ['name' => 'actifs.view', 'code' => 'actifs.view', 'libelle' => 'Voir les actifs'],
            ['name' => 'actifs.create', 'code' => 'actifs.create', 'libelle' => 'Créer des actifs'],
            ['name' => 'actifs.edit', 'code' => 'actifs.edit', 'libelle' => 'Modifier les actifs'],
            ['name' => 'actifs.delete', 'code' => 'actifs.delete', 'libelle' => 'Supprimer des actifs'],
            ['name' => 'actifs.affect', 'code' => 'actifs.affect', 'libelle' => 'Affecter des actifs'],
            ['name' => 'actifs.export', 'code' => 'actifs.export', 'libelle' => 'Exporter les actifs'],
            // Alias
            ['name' => 'view actifs', 'code' => 'view actifs', 'libelle' => 'Voir les actifs'],
            ['name' => 'create actifs', 'code' => 'create actifs', 'libelle' => 'Créer des actifs'],
            ['name' => 'edit actifs', 'code' => 'edit actifs', 'libelle' => 'Modifier les actifs'],
            ['name' => 'delete actifs', 'code' => 'delete actifs', 'libelle' => 'Supprimer des actifs'],
            
            // Gestion des localisations - deux formats
            ['name' => 'localisations.view', 'code' => 'localisations.view', 'libelle' => 'Voir les localisations'],
            ['name' => 'localisations.create', 'code' => 'localisations.create', 'libelle' => 'Créer des localisations'],
            ['name' => 'localisations.edit', 'code' => 'localisations.edit', 'libelle' => 'Modifier des localisations'],
            ['name' => 'localisations.delete', 'code' => 'localisations.delete', 'libelle' => 'Supprimer des localisations'],
            // Alias
            ['name' => 'view localisations', 'code' => 'view localisations', 'libelle' => 'Voir les localisations'],
            ['name' => 'create localisations', 'code' => 'create localisations', 'libelle' => 'Créer des localisations'],
            ['name' => 'edit localisations', 'code' => 'edit localisations', 'libelle' => 'Modifier des localisations'],
            ['name' => 'delete localisations', 'code' => 'delete localisations', 'libelle' => 'Supprimer des localisations'],
            
            // Gestion des tickets - deux formats
            ['name' => 'tickets.view', 'code' => 'tickets.view', 'libelle' => 'Voir les tickets'],
            ['name' => 'tickets.create', 'code' => 'tickets.create', 'libelle' => 'Créer des tickets'],
            ['name' => 'tickets.edit', 'code' => 'tickets.edit', 'libelle' => 'Modifier des tickets'],
            ['name' => 'tickets.delete', 'code' => 'tickets.delete', 'libelle' => 'Supprimer des tickets'],
            ['name' => 'tickets.assign', 'code' => 'tickets.assign', 'libelle' => 'Assigner des tickets'],
            ['name' => 'tickets.resolve', 'code' => 'tickets.resolve', 'libelle' => 'Résoudre des tickets'],
            ['name' => 'tickets.export', 'code' => 'tickets.export', 'libelle' => 'Exporter les tickets'],
            // Alias
            ['name' => 'view tickets', 'code' => 'view tickets', 'libelle' => 'Voir les tickets'],
            ['name' => 'create tickets', 'code' => 'create tickets', 'libelle' => 'Créer des tickets'],
            ['name' => 'edit tickets', 'code' => 'edit tickets', 'libelle' => 'Modifier des tickets'],
            ['name' => 'delete tickets', 'code' => 'delete tickets', 'libelle' => 'Supprimer des tickets'],
            
            // Gestion des logiciels - deux formats
            ['name' => 'logiciels.view', 'code' => 'logiciels.view', 'libelle' => 'Voir les logiciels'],
            ['name' => 'logiciels.create', 'code' => 'logiciels.create', 'libelle' => 'Créer des logiciels'],
            ['name' => 'logiciels.edit', 'code' => 'logiciels.edit', 'libelle' => 'Modifier des logiciels'],
            ['name' => 'logiciels.delete', 'code' => 'logiciels.delete', 'libelle' => 'Supprimer des logiciels'],
            ['name' => 'logiciels.export', 'code' => 'logiciels.export', 'libelle' => 'Exporter les logiciels'],
            // Alias
            ['name' => 'view logiciels', 'code' => 'view logiciels', 'libelle' => 'Voir les logiciels'],
            ['name' => 'create logiciels', 'code' => 'create logiciels', 'libelle' => 'Créer des logiciels'],
            ['name' => 'edit logiciels', 'code' => 'edit logiciels', 'libelle' => 'Modifier des logiciels'],
            ['name' => 'delete logiciels', 'code' => 'delete logiciels', 'libelle' => 'Supprimer des logiciels'],
            
            // Gestion des licences - deux formats
            ['name' => 'licences.view', 'code' => 'licences.view', 'libelle' => 'Voir les licences'],
            ['name' => 'licences.create', 'code' => 'licences.create', 'libelle' => 'Créer des licences'],
            ['name' => 'licences.edit', 'code' => 'licences.edit', 'libelle' => 'Modifier des licences'],
            ['name' => 'licences.delete', 'code' => 'licences.delete', 'libelle' => 'Supprimer des licences'],
            // Alias
            ['name' => 'view licences', 'code' => 'view licences', 'libelle' => 'Voir les licences'],
            ['name' => 'create licences', 'code' => 'create licences', 'libelle' => 'Créer des licences'],
            ['name' => 'edit licences', 'code' => 'edit licences', 'libelle' => 'Modifier des licences'],
            ['name' => 'delete licences', 'code' => 'delete licences', 'libelle' => 'Supprimer des licences'],
            
            // Gestion des contrats - deux formats
            ['name' => 'contrats.view', 'code' => 'contrats.view', 'libelle' => 'Voir les contrats'],
            ['name' => 'contrats.create', 'code' => 'contrats.create', 'libelle' => 'Créer des contrats'],
            ['name' => 'contrats.edit', 'code' => 'contrats.edit', 'libelle' => 'Modifier des contrats'],
            ['name' => 'contrats.delete', 'code' => 'contrats.delete', 'libelle' => 'Supprimer des contrats'],
            ['name' => 'contrats.export', 'code' => 'contrats.export', 'libelle' => 'Exporter les contrats'],
            // Alias
            ['name' => 'view contrats', 'code' => 'view contrats', 'libelle' => 'Voir les contrats'],
            ['name' => 'create contrats', 'code' => 'create contrats', 'libelle' => 'Créer des contrats'],
            ['name' => 'edit contrats', 'code' => 'edit contrats', 'libelle' => 'Modifier des contrats'],
            ['name' => 'delete contrats', 'code' => 'delete contrats', 'libelle' => 'Supprimer des contrats'],
            
            // Gestion des prestataires - deux formats
            ['name' => 'prestataires.view', 'code' => 'prestataires.view', 'libelle' => 'Voir les prestataires'],
            ['name' => 'prestataires.create', 'code' => 'prestataires.create', 'libelle' => 'Créer des prestataires'],
            ['name' => 'prestataires.edit', 'code' => 'prestataires.edit', 'libelle' => 'Modifier des prestataires'],
            ['name' => 'prestataires.delete', 'code' => 'prestataires.delete', 'libelle' => 'Supprimer des prestataires'],
            // Alias
            ['name' => 'view prestataires', 'code' => 'view prestataires', 'libelle' => 'Voir les prestataires'],
            ['name' => 'create prestataires', 'code' => 'create prestataires', 'libelle' => 'Créer des prestataires'],
            ['name' => 'edit prestataires', 'code' => 'edit prestataires', 'libelle' => 'Modifier des prestataires'],
            ['name' => 'delete prestataires', 'code' => 'delete prestataires', 'libelle' => 'Supprimer des prestataires'],
            
            // Gestion des maintenances - deux formats
            ['name' => 'maintenances.view', 'code' => 'maintenances.view', 'libelle' => 'Voir les maintenances'],
            ['name' => 'maintenances.create', 'code' => 'maintenances.create', 'libelle' => 'Créer des maintenances'],
            ['name' => 'maintenances.edit', 'code' => 'maintenances.edit', 'libelle' => 'Modifier des maintenances'],
            ['name' => 'maintenances.delete', 'code' => 'maintenances.delete', 'libelle' => 'Supprimer des maintenances'],
            // Alias
            ['name' => 'view maintenances', 'code' => 'view maintenances', 'libelle' => 'Voir les maintenances'],
            ['name' => 'create maintenances', 'code' => 'create maintenances', 'libelle' => 'Créer des maintenances'],
            ['name' => 'edit maintenances', 'code' => 'edit maintenances', 'libelle' => 'Modifier des maintenances'],
            ['name' => 'delete maintenances', 'code' => 'delete maintenances', 'libelle' => 'Supprimer des maintenances'],
            
            // Gestion des interventions - deux formats
            ['name' => 'interventions.view', 'code' => 'interventions.view', 'libelle' => 'Voir les interventions'],
            ['name' => 'interventions.create', 'code' => 'interventions.create', 'libelle' => 'Créer des interventions'],
            ['name' => 'interventions.edit', 'code' => 'interventions.edit', 'libelle' => 'Modifier des interventions'],
            ['name' => 'interventions.delete', 'code' => 'interventions.delete', 'libelle' => 'Supprimer des interventions'],
            ['name' => 'interventions.export', 'code' => 'interventions.export', 'libelle' => 'Exporter les interventions'],
            // Alias
            ['name' => 'view interventions', 'code' => 'view interventions', 'libelle' => 'Voir les interventions'],
            ['name' => 'create interventions', 'code' => 'create interventions', 'libelle' => 'Créer des interventions'],
            ['name' => 'edit interventions', 'code' => 'edit interventions', 'libelle' => 'Modifier des interventions'],
            ['name' => 'delete interventions', 'code' => 'delete interventions', 'libelle' => 'Supprimer des interventions'],
            ['name' => 'create intervention', 'code' => 'create intervention', 'libelle' => 'Créer des interventions'],
            
            // Gestion des notifications
            ['name' => 'notifications.view', 'code' => 'notifications.view', 'libelle' => 'Voir les notifications'],
            ['name' => 'notifications.manage', 'code' => 'notifications.manage', 'libelle' => 'Gérer les notifications'],
            
            // Rapports - deux formats
            ['name' => 'reports.view', 'code' => 'reports.view', 'libelle' => 'Voir les rapports'],
            ['name' => 'reports.generate', 'code' => 'reports.generate', 'libelle' => 'Générer des rapports'],
            // Alias
            ['name' => 'view reports', 'code' => 'view reports', 'libelle' => 'Voir les rapports'],
            ['name' => 'generate reports', 'code' => 'generate reports', 'libelle' => 'Générer des rapports'],
            
            // Configuration - deux formats
            ['name' => 'settings.view', 'code' => 'settings.view', 'libelle' => 'Voir les paramètres'],
            ['name' => 'settings.edit', 'code' => 'settings.edit', 'libelle' => 'Modifier les paramètres'],
            // Alias
            ['name' => 'view settings', 'code' => 'view settings', 'libelle' => 'Voir les paramètres'],
            ['name' => 'edit settings', 'code' => 'edit settings', 'libelle' => 'Modifier les paramètres'],
        ];

        foreach ($permissions as $permissionData) {
            SpatiePermission::findOrCreate($permissionData['code'], 'web');
        }

        // Clear Spatie permission cache so newly created permissions are found
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Assigner les permissions aux rôles
        $adminRole = SpatieRole::where('name', 'admin')->first();
        $adminRole->givePermissionTo(SpatiePermission::all());

        $responsableRole = SpatieRole::where('name', 'responsable_it')->first();
        $responsableRole->givePermissionTo([
            'actifs.view', 'actifs.create', 'actifs.edit', 'actifs.delete', 'actifs.affect',
            'tickets.view', 'tickets.create', 'tickets.edit', 'tickets.delete', 'tickets.assign', 'tickets.resolve',
            'logiciels.view', 'logiciels.create', 'logiciels.edit',
            'contrats.view', 'contrats.create', 'contrats.edit',
            'reports.view', 'reports.generate',
            'localisations.view', 'localisations.create', 'localisations.edit',
            'prestataires.view', 'prestataires.create', 'prestataires.edit',
            'maintenances.view', 'maintenances.create', 'maintenances.edit',
            'interventions.view', 'interventions.create', 'interventions.edit',
            'licences.view', 'licences.create', 'licences.edit',
        ]);

        $technicienRole = SpatieRole::where('name', 'technicien')->first();
        $technicienRole->givePermissionTo([
            'actifs.view',
            'tickets.view', 'tickets.create', 'tickets.edit', 'tickets.resolve',
        ]);

        $managerRole = SpatieRole::where('name', 'manager')->first();
        $managerRole->givePermissionTo([
            'actifs.view',
            'tickets.view',
            'reports.view',
        ]);

        $utilisateurRole = SpatieRole::where('name', 'utilisateur')->first();
        $utilisateurRole->givePermissionTo([
            'tickets.view', 'tickets.create',
        ]);

        $this->command->info('Rôles et permissions créés avec succès!');
    }
}
