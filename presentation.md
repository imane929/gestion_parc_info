# PRÉSENTATION DU PROJET - IT ASSET MANAGEMENT SYSTEM (AssetFlow)

---

## INSTRUCTIONS POUR CHATGPT

Veuillez créer une présentation PowerPoint professionnelle et esthétique pour ce projet en utilisant toutes les informations détaillées ci-dessous. La présentation doit être visuellement attrayante, professionnelle et adaptée à un exposé en classe.

---

## 1. PAGE DE TITRE (PREMIÈRE PAGE)

**Titre principal :** IT Asset Management System (AssetFlow)

**Sous-titre :** Système de Gestion du Parc Informatique

**Présenté par :** [JOURCHI Imane]

**Encadré par :** [Mr. FIRACHINE Zakariya]

**Logo :** AssetFlow (si disponible)

---

## 2. PLAN DE LA PRÉSENTATION

Voici le plan recommandé pour la présentation :

1. Introduction et Contexte du Projet
2. Objectifs du Projet
3. Technologies Utilisées
4. Acteurs et Fonctionnalités
5. Fonctionnalités Principales
6. Démonstration de l'Interface
7. Modèle Économique (Business Model Canvas)
8. Conclusion et Perspectives

---

## 3. INTRODUCTION

### 3.1 Contexte du Projet

De nos jours, les entreprises de toutes tailles utilisent encore des méthodes manuelles pour gérer leur parc informatique. Elles utilisent principalement des tableurs Excel, des fichiers dispersés sur différents ordinateurs, ou même du papier. Cette approche Cause plusieurs problèmes significatifs :

- **Manque de visibilité** : Il est difficile de savoir quels équipements sont disponibles, lesquels sont assignés à qui, et où ils se trouvent physiquement.
- **Risque d'erreurs et perte de données** : Les tablesurs sont sujets aux erreurs de saisie, et les fichiers peuvent être perdus ou corrompus.
- **Pas de suivi des licences logicielles** : Les dates d'expiration des licences sont souvent oubliées, entraînant des coûts supplémentaires ou des problèmes de conformité juridique.
- **Absence d'historique** : Impossible de retracer l'historique complet d'un équipement (qui l'a eu, quelles réparations ont été faites, etc.).
- **Processus de maintenance inefficient** : Pas de traçabilité claire des interventions de maintenance, des tickets de problème, ou du temps passé.
- **Doublons d'équipements** : Achat d'équipements alors que des équipements similaires sont disponibles mais non détectés.
- **Délais de résolution** : Les demandes de support Trainent sans suivi clair, ce qui ralentit la résolution des problèmes.

### 3.2 Présentation du Projet

**Nom du projet :** AssetFlow - IT Asset Management System

**Type d'application :** Application web (accessible via un navigateur internet)

**Description sommaire :**
AssetFlow est une application web moderne développée avec le framework Laravel qui permet de gérer, centraliser, automatiser et suivre tous les actifs informatiques d'une organisation. Elle remplace les tableurs Excel et les fichiers dispersés par une plateforme centralisée, performante et sécurisée.

Cette application permet de :
- Garder un inventaire complet de tous les équipements informatiques
- Suivre les licences logicielles et leurs dates d'expiration
- Gérer les demandes de maintenance via des tickets
- Assigner les équipements aux utilisateurs
- Planifier la maintenance préventive
- Suivre les contrats avec les prestataires
- avoir un historique complet de toutes les modifications

---

## 4. OBJECTIFS DU PROJET

### 4.1 Objectif Principal

L'objectif principal de ce projet est de **digitaliser et centraliser la gestion du parc informatique** d'une organisation.

### 4.2 Objectifs Spécifiques

Voici les sechs objectifs spécifiques que le projet vise à atteindre :

1. **Centraliser** toutes les informations des actifs informatiques en un seul endroit
   - Toutes les données sont stockées dans une base de données centralisée
   - Plus de fichiers dispersés ou de tableurs multiples

2. **Automatiser** le suivi des licences et de leurs dates d'expiration
   - Le système génère des alertes automatiques avant l'expiration
   - Évite les coûts supplémentaires liés aux renouvellements d'urgence

3. **Optimiser** le processus de maintenance (curative et préventive)
   - Les utilisateurs peuvent soumettre des tickets facilement
   - Les techniciens peuvent suivre et résoudre les problèmes efficacement
   - La maintenance préventive est planifiée à l'avance

4. **Améliorer** la visibilité sur l'inventaire disponible
   - Vue d'ensemble sur tous les équipements
   - Filtres et recherche rapide
   - Statistiques et rapports détaillés

5. **Assurer** la traçabilité complète des actifs
   - Historique de chaque équipement
   - Journal de toutes les modifications
   - Suivi des affectations

6. **Réduire** les coûts en évitant les doublons d'équipements
   - Meilleure planification des achats
   - Utilisation optimale des ressources existantes

---

## 5. TECHNOLOGIES UTILISÉES

### 5.1 Technologies Principales

| Catégorie | Technologie | Description |
|-----------|------------|-------------|
| **Framework Backend** | Laravel 12 | Framework PHP moderne et puissant |
| **Langage de programmation** | PHP 8.2+ | Langage côté serveur |
| **Base de données** | MySQL | Système de gestion de base de données relationnelle |
| **Frontend** | Blade Templates | Moteur de templates Laravel |
| **Framework CSS** | Tailwind CSS | Framework CSS utility-first pour le design |
| **Icons** | Material Symbols | Bibliothèque d'icons de Google |
| **Authentification** | Laravel Breeze | Système d'authentification intégré |
| **Gestion des rôles** | Spatie Laravel-Permission | Package pour la gestion des permissions |

### 5.2 Pourquoi ces Technologies ?

- **Laravel** : Le framework PHP le plus populaire, avec une communauté massive, une documentation excellente, et une courbe d'apprentissage raisonnable. Il offre des fonctionnalités de sécurité intégrées.
- **MySQL** : Base de données relationnelle robuste, largement utilisée dans les entreprises, avec d'excellentes performances.
- **Tailwind CSS** : Permet de créer des designs modernes et responsives rapidement sans écrire de CSS personnalisé.
- **Laravel Breeze** : Système d'authentification complet avec gestion des mots de passe, confirmation d'email, etc.
- **Spatie Laravel-Permission** : Package référence pour gérer les rôles et permissions des utilisateurs.

### 5.3 Architecture de l'Application

L'application utilise l'architecture MVC (Model-View-Controller) de Laravel :
- **Models** : Représentent les données (Utilisateurs, Actifs, Tickets, Licences, etc.)
- **Views** : Les interfaces utilisateur (pages web)
- **Controllers** : La logique métier qui traite les requêtes

---

## 6. ACTEURS ET LEURS FONCTIONNALITÉS

### 6.1 Les 5 Rôles d'Utilisateurs

Le système comporte cinq rôles différents, chacun avec des droits d'accès spécifiques :

#### Rôle 1 : Administrateur (Admin)

**Description :** Utilisateur avec tous les droits, responsable de la configuration du système.

**Accès complets :**
- Gestion des utilisateurs (créer, modifier, supprimer)
- Gestion des rôles et permissions
- Configuration des paramètres système
- Approbation ou rejet des demandes d'accès
- Accès à toutes les fonctionnalités
- Gestion des paramètres globaux

#### Rôle 2 : Responsable IT

**Description :** Responsable du département informatique, gère l'équipe technique.

**Accès :**
- Tableau de bord (dashboard)
- Gestion des actifs (CRUD complet)
- Gestion des tickets (créer, modifier, assigner, résoudre)
- Gestion des logiciels et licences
- Gestion des localisations
- Gestion des contrats
- Gestion des prestataires
- Gestion des maintenances préventives
- Génération de rapports

#### Rôle 3 : Technicien

**Description :** Personnel de support technique qui résout les problèmes.

**Accès :**
- Tableau de bord (dashboard)
- Gestion des actifs (vue et création)
- Gestion des tickets (créer, modifier, résoudre)
- Gestion des logiciels (vue et création)
- Gestion des localisations (vue et création)
- Gestion des maintenances préventives

#### Rôle 4 : Manager

**Description :** Chef de département, utilise le système pour le suivi.

**Accès :**
- Tableau de bord (dashboard)
- Gestion des actifs (vue uniquement)
- Gestion des tickets (vue uniquement)
- Gestion des contrats
- Gestion des prestataires
- Génération de rapports

#### Rôle 5 : Utilisateur (Employé)

**Description :** Employé standard qui utilise les équipements.

**Accès :**
- Tableau de bord personnel
- Mes actifs (équipements qui lui sont assignés)
- Mes tickets (tickets qu'il a créés)
- Son profil (informations personnelles)

---

## 7. FONCTIONNALITÉS PRINCIPALES

### 7.1 Gestion des Actifs Informatiques

Cette fonctionnalité permet de gérer l'inventaire complet des équipements informatiques.

**Fonctionnalités détaillées :**
- Ajouter de nouveaux équipements avec toutes leurs informations
- Modifier les informations d'un équipement existant
- Supprimer un équipement (avec historique)
- Assigner un équipement à un utilisateur
- Désaffecter un équipement (retour au stock)
- Suivre la localisation exacte de chaque équipement
- Voir l'historique complet des modifications
- Ajouter des commentaires sur un équipement
- Joindre des documents ou photos
- Exporter la liste en Excel

**Informations enregistrées pour chaque actif :**
- Code inventaire (unique)
- Type (ordinateur portable, ordinateur fixe, imprimante, serveur, téléphone, etc.)
- Marque (Dell, HP, Lenovo, Apple, etc.)
- Modèle
- Numéro de série
- État (neuf, bon état, usage, hors service)
- Date d'achat
- Date de fin de garantie
- Localisation (bureau, salle, etc.)
- Description

### 7.2 Gestion des Tickets de Maintenance

Cette fonctionnalité permet de gérer les demandes de support et les problèmes signalés par les utilisateurs.

**Fonctionnalités détaillées :**
- Créer un nouveau ticket de problème
- Visualiser tous les tickets
- Filtrer par statut, priorité, assignation
- Assigner un ticket à un technicien
- Mettre à jour le statut (ouvert, en cours, résolu, fermé)
- Ajouter des interventions (temps passé, description)
- Ajouter des commentaires
- Joindre des pièces jointes
- Voir l'historique du ticket

**Priorités disponibles :**
- Basse (peu urgent)
- Moyenne (normal)
- Haute (urgent)
- Critique (Très urgent)

**Statuts disponibles :**
- Ouvert (nouveau ticket)
- En cours (traitement en cours)
- Résolu (problème résolu)
- Fermé (ticket cloturé)

### 7.3 Gestion des Licences-logicielles

Cette fonctionnalité permet de gérer les logiciels et leurs licences.

**Fonctionnalités détaillées :**
- Référencer de nouveaux logiciels
- Ajouter des licences à un logiciel
- Suivre le nombre de postes autorisés
- Voir quelles installations sont faites
- Alertes automatiques avant expiration
- Suivre les licences expirées

**Informations enregistrées :**
- Nom du logiciel
- Éditeur
- Version
- Clé de licence
- Date d'achat
- Date d'expiration
- Nombre de postes autorisés
- Nombre de postes utilisés

### 7.4 Gestion de la Maintenance Préventive

Cette fonctionnalité permet de planifier l'entretien régulier des équipements.

**Fonctionnalités détaillées :**
- Planifier des maintenances régulières
- Assigner les maintenances aux techniciens
- Suivre le statut (planifiée, en cours, terminée, annulée)
- Voir le tableau de planning
- Historique des interventions

### 7.5 Gestion des Contrats

Cette fonctionnalités permet de suivre les contrats avec les prestataires de maintenance.

**Fonctionnalités détaillées :**
- Enregistrer les contrats prestataires
- Suivre les dates de début et fin
- Alertes avant expiration
- Possibilité de renouvellement
- Exportation des données

### 7.6 Système de Demandes d'Accès

Cette fonctionnalité permet aux nouveaux utilisateurs de demander l'accès au système.

**Fonctionnalités détaillées :**
- Formulaire de demande en ligne (accessible sans connexion)
- Envoi de la demande à l'administrateur
- Approbation ou rejet de la demande
- Création automatique du compte si approuvé
- Notification par email

### 7.7 Notifications

Le système envoie des notifications pour garder les utilisateurs informés.

**Types de notifications :**
- Expiration proche des licences
- Expiration proche des contrats
- Nouveau ticket assigné
- Ticket mis à jour
- Nouveau commentaire sur un ticket
- Demande d'accès approuvée ou rejetée

### 7.8 Rapports et Tableaux de Bord

Cette fonctionnalité permet d'avoir une vue d'ensemble et de générer des rapports.

**Tableaux de bord :**
- Nombre total d'actifs
- Actifs par état
- Tickets ouverts/en cours/résolus
- Licences expirant bientôt
- Contrats expirant bientôt

**Rapports disponibles :**
- Rapport sur les actifs
- Rapport sur les tickets
- Rapport sur les maintenances
- Rapport sur les licences
- Rapport sur les contrats

**Exportation :**
- Exportationpossible en format Excel

---

## 8. DÉMONSTRATION DE L'INTERFACE

### 8.1 Type d'Application

L'application AssetFlow est une **application web** accessible via un navigateur internet (Chrome, Firefox, Edge, Safari, etc.). Elle peut également être utilisée sur mobile grâce à son design responsive.

### 8.2 Pages Principales à Présenter

Voici les pages que vous pouvez montrer lors de la démonstration :

#### Page 1 : Page d'Accueil

**URL :** http://127.0.0.1:8000/

**Description :** Cette page présente le système aux visiteurs. Elle contient :
- Le nom et le logo AssetFlow
- Une présentation des fonctionnalités principales
- Des statistiques clés (nombre d'actifs gérés, etc.)
- Un bouton pour demander l'accès
- Un bouton pour se connecter

#### Page 2 : Demande d'Accès

**URL :** http://127.0.0.1:8000/request-access

**Description :** Formulaire pour les nouveaux utilisateurs qui souhaitent obtenir un compte.
Champs : Nom, Prénom, Email, Département, Fonction

#### Page 3 : Tableau de Bord (Dashboard)

**URL :** http://127.0.0.1:8000/dashboard

**Description :** Page principale après connexion. Elle affiche :
- Cartes de statistiques (total actifs, tickets ouverts, licences expirantes, etc.)
- Graphiques sur les actifs par état
- Liste des tickets récents
- Notifications non lues

#### Page 4 : Gestion des Actifs

**URL :** http://127.0.0.1:8000/admin/actifs

**Description :** Liste de tous les équipements avec filtres et recherche.
Boutons : Ajouter, Exporter, Rechercher
Table : Code, Type, Marque, Modèle, État, Localisation, Affecté à

#### Page 5 : Détail d'un Actif

**URL :** http://127.0.0.1:8000/admin/actifs/{id}

**Description :** Page de détail d'un équipement spécifique.
Sections : Informations générales, Historique des affectations, Tickets liés, Commentaires

#### Page 6 : Gestion des Tickets

**URL :** http://127.0.0.1:8000/admin/tickets

**Description :** Liste des tickets de maintenance avec filtres.
Statuts : Ouvert, En cours, Résolu, Fermé

#### Page 7 : Gestion des Logiciels

**URL :** http://127.0.0.1:8000/admin/logiciels

**Description :** Liste des logiciels et de leurs licences.
Informations : Nom, Éditeur, Nombre de licences, Expiration

#### Page 8 : Gestion des Maintenances

**URL :** http://127.0.0.1:8000/admin/maintenances

**Description :** Planification des maintenances préventives.
Tableau de planning avec les dates

#### Page 9 : Rapports

**URL :** http://127.0.0.1:8000/admin/reports

**Description :** Différents rapports et options d'exportation.
Boutons d'exportation Excel

#### Page 10 : Profil Utilisateur

**URL :** http://127.0.0.1:8000/profile

**Description :** Page pour gérer son profil.
Sections : Informations personnelles, Mot de passe, Préférences

### 8.3 Thème Visuel

L'application utilise un design moderne avec :
- Couleurs professionnelles (bleu, blanc, gris)
- Icons Material Symbols
- Design responsive (adapté aux mobiles)
- Mode sombre opcional
- Cartes et tableaux incontournies

---

## 9. MODÈLE ÉCONOMIQUE (BUSINESS MODEL CANVAS)

### 9.1 Segments de Clients

- Petites et Moyennes Entreprises (PME)
- Entreprises de Taille Intermédiaire (ETI)
- Grandes entreprises
- Établissements publics (administrations)
- Établissements scolaires (écoles, universités)

### 9.2 Proposition de Valeur

- Centralisation des informations
- Automatisation du suivi des licences
- Traçabilité complète
- Réduction des coûts
- Visibilité sur l'inventaire

### 9.3 Canaux

- Application web
- Email / Notifications
- Documentation en ligne
- Support technique

### 9.4 Sources de Revenus

- Licence annuelle (abonnement)
- Services de configuration
- Formation
- Personnalisation

---

## 10. CONCLUSION

### 10.1 Résumé du Projet

AssetFlow est une application web complète pour la gestion centralisée du parc informatique. Elle permet de remplacer les tableurs Excel et les méthodes manuelles par une plateforme moderne, sécurisée et automatisée.

### 10.2 Bénéfices Retirés

- **Réduction des coûts** de maintenance et d'exploitation
- **Meilleure visibilité** sur l'inventaire disponible
- **Conformité licence** juridique assurée
- **Amélioration de la productivité** des équipes IT
- **Décisions basées sur les données** grâce aux rapports

### 10.3 Perspectives d'Évolution

L'application peut évoluer avec :
- Une application mobile dédiée (iOS/Android)
- Une API REST pour les intégrations tierces
- Un module financier pour le suivi des coûts
- Un dashboard analytics avancé
- Une intégration avec d'autres outils (GLPI)

### 10.4 Remerciements

Merci pour votre attention.

Des questions ?

---

## INFORMATIONS COMPLÉMENTAIRES POUR CHATGPT

Voici ci-dessus toutes les informations détaillées sur le projet IT Asset Management System (AssetFlow). Veuillez créer une présentation PowerPoint professionnelle avec :

1. Une page de titre attractive
2. Un sommaire ou plan
3. Des slides clairs et aérés pour chaque section
4. Des icônes et visuels là où c'est pertinent
5. Les tableaux présentés de manière attractive
6. Les listes à puces là où c'est approprié
7. Une design moderne et professionnel
8. Une conclusion avec des perspectives d'avenir

Le projet est une application web développée avec Laravel (PHP) et Tailwind CSS. C'est un système de gestion du parc informatique pour les entreprises.

Merci de votre aide !