<?php

namespace Database\Seeders;

use App\Models\ActifInformatique;
use App\Models\Intervention;
use App\Models\TicketMaintenance;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketMaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        // Skip if already seeded
        if (TicketMaintenance::where('numero', 'TICK-00001')->exists()) {
            $this->command->info('Tickets de maintenance déjà créés, skipping...');
            return;
        }

        $actifs = ActifInformatique::all();
        $utilisateurs = User::all();
        $techniciens = User::all(); // Utiliser tous les utilisateurs au cas où le filtre par rôle échoue

        if ($actifs->isEmpty() || $utilisateurs->isEmpty()) {
            $this->command->warn('Aucun actif ou utilisateur trouvé. Skipping TicketMaintenanceSeeder.');
            return;
        }

        // Créer des tickets résolus
        for ($i = 1; $i <= 40; $i++) {
            $ticket = TicketMaintenance::create([
                'numero' => 'TICK-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'actif_informatique_id' => $actifs->random()->id,
                'sujet' => $this->getSujetTicket(),
                'description' => $this->getDescriptionTicket(),
                'priorite' => $this->getPriorite(),
                'statut' => 'resolu',
                'assigne_a' => $techniciens->isNotEmpty() ? $techniciens->random()->id : null,
                'created_by' => $utilisateurs->random()->id,
                'created_at' => now()->subDays(rand(1, 90)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ]);

            // Créer des interventions pour les tickets résolus
            $nbInterventions = rand(1, 3);
            for ($j = 1; $j <= $nbInterventions; $j++) {
                Intervention::create([
                    'ticket_maintenance_id' => $ticket->id,
                    'technicien_id' => $ticket->assigne_a,
                    'date' => $ticket->created_at->addDays($j),
                    'travaux' => $this->getTravauxIntervention(),
                    'temps_passe' => rand(30, 240),
                ]);
            }
        }

        // Créer des tickets en cours
        for ($i = 41; $i <= 55; $i++) {
            $ticket = TicketMaintenance::create([
                'numero' => 'TICK-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'actif_informatique_id' => $actifs->random()->id,
                'sujet' => $this->getSujetTicket(),
                'description' => $this->getDescriptionTicket(),
                'priorite' => $this->getPriorite(),
                'statut' => 'en_cours',
                'assigne_a' => $techniciens->isNotEmpty() ? $techniciens->random()->id : null,
                'created_by' => $utilisateurs->random()->id,
                'created_at' => now()->subDays(rand(1, 14)),
                'updated_at' => now(),
            ]);

            // Créer une intervention en cours
            Intervention::create([
                'ticket_maintenance_id' => $ticket->id,
                'technicien_id' => $ticket->assigne_a,
                'date' => $ticket->created_at->addDays(1),
                'travaux' => $this->getTravauxIntervention(),
                'temps_passe' => rand(30, 120),
            ]);
        }

        // Créer des tickets ouverts (non assignés)
        for ($i = 56; $i <= 65; $i++) {
            TicketMaintenance::create([
                'numero' => 'TICK-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'actif_informatique_id' => $actifs->random()->id,
                'sujet' => $this->getSujetTicket(),
                'description' => $this->getDescriptionTicket(),
                'priorite' => $this->getPriorite(),
                'statut' => 'ouvert',
                'assigne_a' => null,
                'created_by' => $utilisateurs->random()->id,
                'created_at' => now()->subDays(rand(1, 7)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Tickets de maintenance créés avec succès!');
    }

    private function getSujetTicket(): string
    {
        $sujets = [
            'Écran noir au démarrage',
            'Imprimante ne répond pas',
            'Lenteur anormale du système',
            'Problème de connexion réseau',
            'Logiciel ne s\'installe pas',
            'Virus détecté',
            'Disque dur plein',
            'Souris/clavier défectueux',
            'Problème de son',
            'Erreur système au démarrage',
            'Impossible d\'imprimer',
            'Connexion WiFi instable',
            'Logiciel plante fréquemment',
            'Écran avec lignes colorées',
            'Ventilateur bruyant',
            'Batterie ne tient pas la charge',
            'Problème d\'affichage',
            'Clavier certaines touches ne fonctionnent pas',
            'Système ne démarre plus',
            'Données perdues',
        ];
        
        return $sujets[array_rand($sujets)];
    }

    private function getDescriptionTicket(): string
    {
        $descriptions = [
            "Le problème survient lorsque j'essaie de démarrer l'ordinateur. L'écran reste noir mais les voyants sont allumés.",
            "L'imprimante affiche une erreur 'papier bloqué' mais il n'y a pas de papier coincé. J'ai déjà essayé de redémarrer.",
            "Depuis hier, l'ordinateur met plus de 5 minutes à démarrer et les applications sont très lentes à s'ouvrir.",
            "Je ne peux plus me connecter au réseau filaire. Le câble semble bien branché mais je n'ai pas d'accès internet.",
            "L'installation du logiciel échoue toujours à 75% avec un message d'erreur 'fichier corrompu'.",
            "L'antivirus a détecté plusieurs menaces mais ne parvient pas à les supprimer. Le système est devenu instable.",
            "Je reçois constamment des messages d'erreur 'espace disque insuffisant'. J'ai déjà supprimé des fichiers temporaires.",
            "La souris fonctionne par intermittence et le clavier ne répond pas sur certaines touches.",
            "Aucun son ne sort des haut-parleurs alors que le volume est au maximum. Testé avec plusieurs applications.",
            "Un écran bleu apparaît au démarrage avec le code d'erreur 0x0000007B. Impossible d'accéder à Windows.",
            "Quand j'envoie un document à l'imprimante, rien ne se passe. L'imprimante est en ligne et a du papier.",
            "La connexion WiFi se coupe toutes les 10 minutes environ. Je dois me reconnecter manuellement.",
            "Le logiciel plante systématiquement quand j'essaie d'ouvrir un fichier de plus de 10 Mo.",
            "Des lignes colorées apparaissent sur l'écran, surtout quand l'ordinateur chauffe.",
            "Le ventilateur fait un bruit anormalement fort, même quand l'ordinateur n'est pas sollicité.",
            "La batterie ne tient que 30 minutes alors qu'elle tenait 4 heures avant.",
            "L'écran clignote de manière intermittente et les couleurs semblent délavées.",
            "Les touches F1 à F4 ainsi que la touche Entrée ne fonctionnent plus.",
            "Après une mise à jour Windows, l'ordinateur ne démarre plus et reste sur l'écran du fabricant.",
            "J'ai perdu l'accès à plusieurs fichiers importants après une coupure de courant.",
        ];
        
        return $descriptions[array_rand($descriptions)];
    }

    private function getPriorite(): string
    {
        $priorites = ['basse', 'moyenne', 'haute', 'urgente'];
        $probas = [20, 50, 25, 5];
        $rand = rand(1, 100);
        $cumul = 0;
        
        foreach ($probas as $index => $prob) {
            $cumul += $prob;
            if ($rand <= $cumul) {
                return $priorites[$index];
            }
        }
        
        return 'moyenne';
    }

    private function getTravauxIntervention(): string
    {
        $travaux = [
            "Diagnostic complet du système\n- Vérification des connexions\n- Test des composants\n- Analyse des logs système",
            "Nettoyage et maintenance\n- Nettoyage physique de l'équipement\n- Mise à jour des pilotes\n- Suppression des fichiers temporaires",
            "Remplacement de composant\n- Identification du composant défectueux\n- Commande de la pièce\n- Installation et test",
            "Réinstallation du système\n- Sauvegarde des données\n- Formatage du disque\n- Installation propre du système d'exploitation",
            "Configuration réseau\n- Diagnostic de la connexion\n- Réinitialisation des paramètres réseau\n- Test de connectivité",
            "Suppression de malware\n- Analyse antivirus approfondie\n- Suppression des menaces détectées\n- Mise à jour de l'antivirus",
            "Optimisation des performances\n- Nettoyage du registre\n- Désinstallation de programmes inutiles\n- Configuration des services",
            "Récupération de données\n- Analyse du disque dur\n- Récupération des fichiers perdus\n- Sauvegarde sur support externe",
        ];
        
        return $travaux[array_rand($travaux)];
    }
}