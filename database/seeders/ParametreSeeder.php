<?php

namespace Database\Seeders;

use App\Models\Parametre;
use Illuminate\Database\Seeder;

class ParametreSeeder extends Seeder
{
    public function run(): void
    {
        $parametres = [
            // Paramètres système
            ['cle' => 'app_name', 'valeur' => 'Gestion Parc Informatique', 'groupe' => 'systeme', 'description' => 'Nom de l\'application'],
            ['cle' => 'app_version', 'valeur' => '1.0.0', 'groupe' => 'systeme', 'description' => 'Version de l\'application'],
            ['cle' => 'maintenance_mode', 'valeur' => 'false', 'groupe' => 'systeme', 'description' => 'Mode maintenance'],
            
            // Paramètres email
            ['cle' => 'email_from_address', 'valeur' => 'noreply@parc-informatique.test', 'groupe' => 'email', 'description' => 'Adresse email expéditeur'],
            ['cle' => 'email_from_name', 'valeur' => 'Gestion Parc Informatique', 'groupe' => 'email', 'description' => 'Nom de l\'expéditeur'],
            ['cle' => 'email_notifications', 'valeur' => 'true', 'groupe' => 'email', 'description' => 'Activer les notifications email'],
            
            // Paramètres tickets
            ['cle' => 'ticket_auto_assign', 'valeur' => 'false', 'groupe' => 'tickets', 'description' => 'Assignation automatique des tickets'],
            ['cle' => 'ticket_priority_default', 'valeur' => 'moyenne', 'groupe' => 'tickets', 'description' => 'Priorité par défaut des tickets'],
            ['cle' => 'ticket_response_time', 'valeur' => '24', 'groupe' => 'tickets', 'description' => 'Temps de réponse maximal (heures)'],
            ['cle' => 'ticket_resolution_time', 'valeur' => '72', 'groupe' => 'tickets', 'description' => 'Temps de résolution maximal (heures)'],
            
            // Paramètres actifs
            ['cle' => 'asset_warranty_alert_days', 'valeur' => '30', 'groupe' => 'actifs', 'description' => 'Jours d\'alerte avant expiration garantie'],
            ['cle' => 'asset_maintenance_interval', 'valeur' => '180', 'groupe' => 'actifs', 'description' => 'Intervalle de maintenance préventive (jours)'],
            ['cle' => 'asset_inventory_prefix', 'valeur' => 'INV', 'groupe' => 'actifs', 'description' => 'Préfixe des codes d\'inventaire'],
            
            // Paramètres licences
            ['cle' => 'license_expiration_alert_days', 'valeur' => '60', 'groupe' => 'licences', 'description' => 'Jours d\'alerte avant expiration licence'],
            ['cle' => 'license_auto_renewal', 'valeur' => 'false', 'groupe' => 'licences', 'description' => 'Renouvellement automatique des licences'],
            
            // Paramètres interface
            ['cle' => 'pagination_items_per_page', 'valeur' => '25', 'groupe' => 'interface', 'description' => 'Nombre d\'éléments par page'],
            ['cle' => 'theme_color', 'valeur' => 'blue', 'groupe' => 'interface', 'description' => 'Couleur du thème'],
            ['cle' => 'sidebar_collapsed', 'valeur' => 'false', 'groupe' => 'interface', 'description' => 'Barre latérale réduite par défaut'],
            
            // Paramètres sécurité
            ['cle' => 'password_min_length', 'valeur' => '8', 'groupe' => 'securite', 'description' => 'Longueur minimale du mot de passe'],
            ['cle' => 'password_require_special', 'valeur' => 'true', 'groupe' => 'securite', 'description' => 'Mot de passe nécessite caractères spéciaux'],
            ['cle' => 'session_timeout', 'valeur' => '120', 'groupe' => 'securite', 'description' => 'Timeout de session (minutes)'],
            ['cle' => 'login_attempts_max', 'valeur' => '5', 'groupe' => 'securite', 'description' => 'Nombre maximal de tentatives de connexion'],
            
            // Paramètres rapports
            ['cle' => 'report_auto_generate', 'valeur' => 'false', 'groupe' => 'rapports', 'description' => 'Génération automatique des rapports'],
            ['cle' => 'report_keep_days', 'valeur' => '365', 'groupe' => 'rapports', 'description' => 'Conservation des rapports (jours)'],
            ['cle' => 'report_default_format', 'valeur' => 'pdf', 'groupe' => 'rapports', 'description' => 'Format par défaut des rapports'],
            
            // Paramètres notifications
            ['cle' => 'notify_ticket_created', 'valeur' => 'true', 'groupe' => 'notifications', 'description' => 'Notifier création de ticket'],
            ['cle' => 'notify_ticket_assigned', 'valeur' => 'true', 'groupe' => 'notifications', 'description' => 'Notifier assignation de ticket'],
            ['cle' => 'notify_ticket_resolved', 'valeur' => 'true', 'groupe' => 'notifications', 'description' => 'Notifier résolution de ticket'],
            ['cle' => 'notify_license_expiring', 'valeur' => 'true', 'groupe' => 'notifications', 'description' => 'Notifier expiration de licence'],
            ['cle' => 'notify_warranty_expiring', 'valeur' => 'true', 'groupe' => 'notifications', 'description' => 'Notifier expiration de garantie'],
            ['cle' => 'notify_maintenance_due', 'valeur' => 'true', 'groupe' => 'notifications', 'description' => 'Notifier maintenance préventive due'],
        ];

        foreach ($parametres as $parametre) {
            Parametre::firstOrCreate(['cle' => $parametre['cle']], $parametre);
        }

        $this->command->info('Paramètres créés avec succès!');
    }
}