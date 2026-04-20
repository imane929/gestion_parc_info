# ParcInfo - IT Asset Management System
## Documentation Complète pour ChatGPT

---

## 1. INTRODUCTION

**AssetFlow** est un système de gestion des actifs informatiques conçu pour les entreprises. Il permet de :
- Tracker les équipements hardware (ordinateurs, serveurs, équipements réseau)
- Gérer les tickets de maintenance
- Suivre les licences logicielles
- Gérer les contrats de maintenance
- Organiser les localisations (bâtiments, étages, salles)
- Gérer les fournisseurs/prestataires
- Générer des rapports

---

## 2. RÔLES ET PERMISSIONS

### Rôles disponibles :
| Rôle | Description |
|------|-------------|
| `admin` | Accès complet à toutes les fonctionnalités |
| `responsable_it` | Gestion IT, peut gérer tous les actifs et tickets |
| `technicien` | Peut créer et résoudre des tickets, interventions |
| `manager` | Voir les rapports, statistiques |
| `utilisateur` | Utilisateur simple - ne voit que ses propres actifs et tickets |

### Navigation par rôle :

**Tous les rôles voient :**
- Dashboard
- Mes Actifs
- Tickets (créer et voir les siens)
- Notifications

**Admin, Responsable IT, Technicien, Manager voient en plus :**
- Actifs (liste complète)
- Logiciels
- Licences
- Localisations
- Contrats
- Prestataires
- Maintenances

**Admin, Responsable IT, Technicien voient en plus :**
- Interventions

**Admin, Responsable IT, Manager voient en plus :**
- Rapports

**Admin uniquement :**
- Demandes d'accès
- Messages de contact
- Utilisateurs
- Rôles
- Paramètres

---

## 3. PAGES ET LEUR LOGIQUE

### 3.1 Page d'Accueil (Welcome)
**URL:** `/`
- Landing page publique avec design moderne
- Sections : Hero, Features, Stats, CTA
- Boutons : "Request Access" et "Log In" pour les non-connectés
- Si connecté : bouton "Go to Dashboard"

### 3.2 Page de Connexion (Login)
**URL:** `/login`
- Champs : Email, Mot de passe
- Option "Se souvenir de moi"
- Lien "Mot de passe oublié"
- Lien vers "Demander l'accès" pour nouveaux utilisateurs

### 3.3 Page de Demande d'Accès
**URL:** `/request-access`
- Formulaire pour demander un compte
- Champs : Nom complet, Email, Département, Raison de la demande
- Soumission vers la base de données (table `demande_acces`)
- Admin reçoit une notification et peut approuver/rejeter

### 3.4 Dashboard (Tableau de bord)
**URL:** `/dashboard`
**Accessible par :** Tous les utilisateurs connectés

**Contenu :**
- Statistiques générales (total actifs, tickets ouverts, licences expirant, contrats expirant)
- Graphiques de distribution des actifs par type/état
- Tickets récents
- Alertes importantes

### 3.5 Actifs (Assets)
**URL:** `/actifs`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Liste complète de tous les équipements
- Filtres par type, état, localisation
- Création d'actif : code inventaire, type, marque, modèle, numéro série, état, localisation, utilisateur affecté
- États possibles : `en_service`, `en_maintenance`, `hors_service`, `en_attente`
- Types : `ordinateur`, `serveur`, `equipement_reseau`, `peripherique`, `mobile`, `autre`
- Actions : Modifier, Supprimer, Affecter à un utilisateur, Désaffecter
- Export CSV/Excel

### 3.6 Mes Actifs
**URL:** `/my-assets`
**Accessible par :** Tous les utilisateurs

**Contenu :**
- Liste des actifs assignés à l'utilisateur connecté
- Détails : code inventaire, marque, modèle, état, localisation

### 3.7 Tickets de Maintenance
**URL:** `/tickets`
**Accessible par :** Tous les utilisateurs (pour créer), Admin/Responsable IT/Technicien (pour gérer)

**Fonctionnalités :**
- Créer un ticket : titre, description, actif concerné, priorité, type
- Priorités : `basse`, `moyenne`, `haute`, `critique`
- Types : `incident`, `demande_information`, `maintenance_preventive`
- Statuts : `ouvert`, `en_cours`, `resolu`, `ferme`
- Assigner un ticket à un technicien
- Ajouter des commentaires
- Ajouter des interventions
- Résoudre/Fermer un ticket
- Notifications à l'utilisateur quand son ticket est traité

### 3.8 Logiciels
**URL:** `/logiciels`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Liste des logiciels installés/gérés
- Ajouter logiciel : nom, éditeur, version, catégorie
- Ajouter licences pour chaque logiciel
- Suivre les installations sur les actifs
- Dates d'expiration des licences

### 3.9 Licences
**URL:** `/licences`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Liste des licences logicielles
- Clé de licence, date d'achat, date d'expiration, coût
- Alertes pour licences expirant bientôt
- Nombre de places/seats

### 3.10 Localisations
**URL:** `/localisations`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Hiérarchie : Site > Bâtiment > Étage > Salle
- Gérer les emplacements physiques
- Déplacer des actifs entre localisations

### 3.11 Contrats de Maintenance
**URL:** `/contrats`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Liste des contrats avec fournisseurs
- Types : `support`, `maintenance`, `garantie`, `service`
- Date début, date fin, coût
- Alertes pour contrats expirant
- Renouvellement de contrats

### 3.12 Prestataires
**URL:** `/prestataires`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Liste des fournisseurs/prestataires IT
- Coordonnées, personne de contact
- Services fournis
- Contrats associés

### 3.13 Maintenances Planifiées
**URL:** `/maintenances`
**Accessible par :** Admin, Responsable IT, Technicien, Manager

**Fonctionnalités :**
- Planifier des maintenances préventives
- Associer à un actif et un prestataire
- Statuts : `planifiee`, `en_cours`, `terminee`, `annulee`
- Coût, date prévue, durée estimée
- Maintenances en retard

### 3.14 Interventions
**URL:** `/interventions`
**Accessible par :** Admin, Responsable IT, Technicien

**Fonctionnalités :**
- Enregistrer les interventions techniques
- Associer à un ticket ou une maintenance
- Technicien responsable
- Description, durée, coût pièces
- Pièces utilisées

### 3.15 Rapports
**URL:** `/reports`
**Accessible par :** Admin, Responsable IT, Manager

**Rapports disponibles :**
- Rapport Inventaire (tous les actifs)
- Rapport Tickets (statistiques des tickets)
- Rapport Maintenance (historique des maintenances)
- Rapport Licences (état des licences)
- Rapport Contrats (contrats et coûts)
- Rapport personnalisé (filtres自定义)

### 3.16 Notifications
**URL:** `/notifications`
**Accessible par :** Tous les utilisateurs

**Contenu :**
- Liste des notifications de l'utilisateur
- Marquer comme lue
- Supprimer
- Préférences de notification

### 3.17 Demandes d'Accès (Admin only)
**URL:** `/demandes-acces`
**Accessible par :** Admin uniquement

**Fonctionnalités :**
- Voir les demandes d'accès en attente
- Approuver (crée l'utilisateur) ou Rejeter
- Envoyé email de confirmation

### 3.18 Messages de Contact (Admin only)
**URL:** `/contact-messages`
**Accessible par :** Admin uniquement

**Fonctionnalités :**
- Voir les messages du formulaire de contact
- Marquer comme lu
- Supprimer

### 3.19 Utilisateurs (Admin only)
**URL:** `/utilisateurs`
**Accessible par :** Admin uniquement

**Fonctionnalités :**
- Liste des utilisateurs
- Créer/Modifier/Supprimer utilisateur
- Assigner un rôle
- Activer/Désactiver compte
- Voir le profil détaillé d'un utilisateur

### 3.20 Rôles et Permissions (Admin only)
**URL:** `/roles`
**Accessible par :** Admin uniquement

**Fonctionnalités :**
- Gérer les rôles
- Assigner des permissions spécifiques aux rôles
- Permissions par utilisateur

### 3.21 Paramètres (Admin only)
**URL:** `/settings`
**Accessible par :** Admin uniquement

**Fonctionnalités :**
- Paramètres généraux du système
- Configuration email
- Groupes de paramètres
- Import/Export de paramètres

### 3.22 Profil Utilisateur
**URL:** `/profile`
**Accessible par :** Tous les utilisateurs

**Contenu :**
- Informations personnelles
- Modifier mot de passe
- Photo de profil
- Notifications preferences
- Tokens API



## 7. FONCTIONNALITÉS CLÉS

### Notifications automatisées :
- Quand un ticket est créé → notification à l'admin
- Quand un ticket est assigné → notification au technicien
- Quand un ticket est résolu → notification au créateur
- Licences expirant dans 30 jours → notification
- Contrats expirant dans 30 jours → notification
- Maintenances planifiées → rappel

### Workflow Ticket :
1. Utilisateur crée ticket
2. Admin/Responsable assigne à technicien
3. Technicien travaille sur le ticket
4. Technicien ajoute interventions/comments
5. Technicien résout → notification utilisateur
6. Ticket fermé

### Affectation d'actifs :
1. Admin choisit actif
2. Sélectionne utilisateur
3. Affecte avec date
4. Historique des affectations conservé

### Export de données :
- CSV/Excel pour : Actifs, Tickets, Maintenances, Contrats, Licences
- Filtres appliqués avant export

---

## 8. API ENDPOINTS

```
GET  /api/search?q=        -> Recherche globale
GET  /api/notifications/unread-count -> Nombre notifications non lues
```

## 10. SÉCURITÉ

- Middleware `auth` pour pages protégées
- Middleware `verified` pour email vérifié
- Middleware `role:admin|...` pour permissions
- CSRF protection sur tous les formulaires
- Validation des inputs serveur-side
- Permissions basé sur Spatie Laravel Permission

---

## 11. STACK TECHNIQUE

- **Backend :** Laravel 11 (PHP 8+)
- **Frontend :** Blade templates + Tailwind CSS
- **Base de données :** MySQL/MariaDB
- **Icons :** Material Symbols Outlined
- **Fonts :** Inter (Google Fonts)
- **Auth :** Laravel Breeze/Fortify
- **Permissions :** Spatie Laravel Permission

