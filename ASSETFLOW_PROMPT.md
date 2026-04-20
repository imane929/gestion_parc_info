# Prompt Détaillé pour AssetFlow - Système de Gestion des Actifs IT

---

## 📋 Description Générale

**Nom de l'application** : AssetFlow  
**Type** : Application Web de Gestion des Actifs Informatiques  
**Framework** : Laravel (PHP) + Blade Templates + Tailwind CSS  
**Base de données** : MySQL  
**Authentification** : Laravel Breeze avec rôles personnalisés  

---

## 🎯 Objectifs du Système

AssetFlow est une plateforme complète permettant de :

1. **Gérer les actifs informatiques** (ordinateurs, serveurs, équipements réseau, périphériques)
2. **Gérer les tickets de support** (signalement, suivi, résolution des problèmes)
3. **Planifier la maintenance** (maintenance préventive et corrective)
4. **Gérer les licences logicielles** (suivi, expiration, conformité)
5. **Gérer les contrats** (fournisseurs, renouvellements)
6. **Générer des rapports** (tableaux de bord, exports Excel)

---

## ✅ Résumé des Points Clés

1. **Multilangue** : Tout le site doit être en français
2. **Nom** : AssetFlow (avec logo dans `/public/images/logo.png`)
3. **Rôles stricts** : Chaque rôle a accès aux modules définis
4. **Sécurité** : Politiques Laravel pour l'autorisation
5. **UX** : Sidebar adaptée au rôle, navigation mobile fonctionnelle
6. **Responsive** : Fonctionne sur desktop et mobile




_____________________________________________________________________________________________________________
_____________________________________________________________________________________________________________




# IT Asset Management System

## 1. Idée du Projet

------gestion d'une application de parc informatique------

**IT Asset Management System** est une application web développé avec Laravel qui permet la gestion centralisée et automatisée de tous les actifs informatiques d'une organisation (ordinateurs, équipements réseau, logiciels, licences, etc.).

---

## 2. Description du Projet

Ce projet est une plateforme web complète qui permet de:

- **Gérer l'inventaire informatique** - Suivre tous les équipements (ordinateurs, imprimantes, serveurs, etc.)
- **Gérer les licences logicielles** - Tracker les licences, leur expiration et le nombre de postes
- **Gérer les demandes de maintenance** - Créer et suivre les tickets de maintenance
- **Gérer les affectations** - Assigner les équipements aux utilisateurs
- **Planifier la maintenance préventive** - Programmation des interventions préventives
- **Gérer les contrats de maintenance** - Suivre les contrats avec les prestataires
- **Historique complet** - Journaliser toutes les modifications apportées aux actifs

---

## 3. Objectifs du Projet

1. **Centraliser** toutes les informations des actifs informatiques en un seul endroit
2. **Automatiser** le suivi des licences et leurs dates d'expiration
3. **Optimiser** le processus de maintenance curative et préventive
4. **Améliorer** la visibilité sur l'inventaire et l'allocation des ressources
5. **Assurer** la traçabilité complète des actifs (historique, affectations, modifications)
6. **Réduire** les coûts en évitant les doublons et en optimisant l'utilisation des ressources

---

## 4. Problématique

Les organisationsfont face à plusieurs défis:

- **Manque de visibilité**: Difficulté à savoir quels équipements sont disponibles ouassignés
- **Gestion manuelle fragile**: Tableurs souvent utilisés, risque d'erreurs et de данных perte
- **Non-suivi deslicences**: Expiration non détectée导致 des coûts supplémentaires ou des非conformité
- **Processus maintenance inefficient**: Pas de traçabilité des interventions
- **Absence d'historique**: Impossible de retracer l'historique complet d'un équipement
- **Délais de résolution**: Pas de suivi claires des tickets de maintenance

---

## 5. BUSINESS MODEL CANVAS

```
┌─────────────────────────────────────────────────────────────────────────────────────────────────────┐
│                           BUSINESS MODEL CANVAS                              │
├─────────────────────┬─────────────────────┬─────────────────────────────────────┤
│  CUSTOMER SEGMENTS  │  VALUE PROPOSITIONS │  CHANNELS                          │
│                    │                     │                                   │
│ - PME              │ - Centralisation    │ - Application web                  │
│ - ETI             │ - Automatisation    │ - Interface mobile                 │
│ - Grandes entr.    │ - Traçabilité      │ - Notifications email              │
│ - Établissements  │ - Réduction coûts  │ - Documentation en ligne            │
│   publics         │ - Visibilité        │ - Support technique                 │
│ - Établissements  │ - Historique       │                                   │
│   scolaires       │ - Alertes auto      │                                   │
├─────────────────────┼─────────────────────┼─────────────────────────────────────┤
│  CUSTOMER          │  KEY ACTIVITIES      │  KEY RESSOURCES                     │
│  RELATIONSHIPS     │                    │                                   │
│                    │ - Développement Web │ - Équipe développement               │
│ - Support teknik  │ - Maintenance app  │ - Serveurs                         │
│ - Formation       │ - Gestion BDD      │ - Base de données MySQL              │
│ - Mises à jour   │ - Support utilisateurs│ - Documentation                   │
│ - Documentation  │ - Sécurité données  │ - Infrastructure cloud               │
│ - Assistance    │ - Nouvelles fonc. │                               │
└─────────────────────┴─────────────────────┴─────────────────────────────────────┘
┌─────────────────────┬─────────────────────────────────────────────────────────────────────┐
│  KEY PARTNERS     │  REVENUE STREAMS                                               │
│                 │                                                             │
│ - Fournisseurs  │ - Licence annuelle (abonnement)                            │
│   hardware     │ - Services de configuration                                  │
│ - Éditeurs     │ - Formation utilisateurs                                    │
│   logiciels    │ - Personnalisation                                          │
│ - Prestataires │ - Maintenance évolutive                                     │
│   maintenance │ - Conseil et audit IT                                       │
│ - Hébergeurs   │                                                             │
│   cloud        ├─────────────────────────────────────────────────────────────┤
│                │  COST STRUCTURE                                            │
│                │                                                             │
│                │ - Développement initial                                     │
│                │ - Maintenance récurrente                                    │
│                │ - Hébergement serveur                                       │
│                │ - Support technique                                        │
│                │ - Sécurité et mises à jour                                  │
│                │ - Équipe technique                                         │
└────────────────┴─────────────────────────────────────────────────────────────┘
```

### Détail du Business Model Canvas

| Bloc | Description |
|------|------------|
| **Customer Segments** | PME, ETI, Grandes entreprises, Établissements publics, Établissements scolaires |
| **Value Propositions** | Centralisation, Automatisation, Traçabilité, Réduction coûts, Visibilité, Historique, Alertes |
| **Channels** | Application web, Mobile, Email, Documentation |
| **Customer Relationships** | Support, Formation, Mises à jour, Documentation |
| **Key Activities** | Développement, Maintenance, Gestion BDD, Support, Sécurité |
| **Key Resources** | Équipe, Serveurs, Base de données, Documentation |
| **Key Partners** | Fournisseurs hardware, Éditeurs logiciels, Prestataires, Hébergeurs |
| **Revenue Streams** | Abonnement, Services config, Formation, Personnalisation |
| **Cost Structure** | Développement, Maintenance, Hébergement, Support, Équipe |

---

## 6. Fonctionnalités Principales

### Gestion des Actifs
- Code inventaireunique
-.Type, marque, modèle
- Numéro de série
- État (neuf, bon,usage, HS)
- Date d'achat, garantie
- Localisation

### Gestion des Licences
- Logiciels référencés
- Clés de licence
- Nombre de postes
- Date d'expiration
- Suivi des installations

### Gestion de la Maintenance
- Tickets de maintenance
- Priorités (basse, moyenne, haute, critique)
- Statuts (ouvert, en cours, résolu, fermé)
- Assignation aux techniciens
- Interventions journalisées

### Gestion des Utilisateurs
- Rôles et permissions
- Affectation des actifs
- Historique des affectations
- Notifications

### Rapports & Tableaux de bord
- Actifs par état
- Licences expirantes
- Tickets en cours
- Statistiques d'utilisation

---

## 7. Technologies Utilisées

- **Backend**: Laravel (PHP)
- **Frontend**: Blade Templates + Tailwind CSS
- **Base de données**: MySQL/SQLite
- **Authentification**: Laravel Breeze/Jetstream
- **Gestion des rôles**: Spatie Laravel-Permission

---

## 8. Perspectives d'Évolution

- Application mobile (iOS/Android)
- API REST pour intégrations tierces
- Module de、采购 (achat d'équipements)
- Module财务管理 (coûts des actifs)
- Intégration GLPI ou autres outils
- Dashboard analytics avancé