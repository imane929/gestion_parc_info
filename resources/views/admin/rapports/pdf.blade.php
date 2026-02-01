<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport {{ ucfirst($type) }} - {{ date('d/m/Y') }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #4f46e5;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
        }
        
        .info-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        .info-table .label {
            background-color: #f8fafc;
            font-weight: bold;
            width: 30%;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .data-table th {
            background-color: #4f46e5;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .data-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .summary {
            background-color: #f8fafc;
            border-left: 4px solid #4f46e5;
            padding: 15px;
            margin: 20px 0;
        }
        
        .summary h3 {
            color: #4f46e5;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Rapport {{ ucfirst($type) }}</h1>
        <div class="subtitle">
            Gestion Parc Informatique • {{ $date }}
        </div>
        <div class="subtitle">
            Période: {{ $periode === 'today' ? 'Aujourd\'hui' : ($periode === 'week' ? 'Cette semaine' : ($periode === 'month' ? 'Ce mois' : ($periode === 'year' ? 'Cette année' : 'Toutes périodes'))) }}
        </div>
    </div>
    
    <table class="info-table">
        <tr>
            <td class="label">Type de rapport:</td>
            <td>{{ ucfirst($type) }}</td>
        </tr>
        <tr>
            <td class="label">Date de génération:</td>
            <td>{{ $date }}</td>
        </tr>
        <tr>
            <td class="label">Période:</td>
            <td>{{ $periode === 'today' ? 'Aujourd\'hui' : ($periode === 'week' ? 'Cette semaine' : ($periode === 'month' ? 'Ce mois' : ($periode === 'year' ? 'Cette année' : 'Toutes périodes'))) }}</td>
        </tr>
        <tr>
            <td class="label">Nombre d'éléments:</td>
            <td>{{ count($data) }}</td>
        </tr>
    </table>
    
    @if(count($data) > 0)
        <div class="summary">
            <h3>Résumé du rapport</h3>
            <p>Ce rapport contient {{ count($data) }} enregistrement(s) pour la période sélectionnée.</p>
        </div>
        
        @if($type === 'equipements')
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Marque/Modèle</th>
                    <th>État</th>
                    <th>Localisation</th>
                    <th>Date d'acquisition</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $equipement)
                <tr>
                    <td>{{ $equipement->id }}</td>
                    <td>{{ $equipement->nom }}</td>
                    <td>{{ $equipement->type }}</td>
                    <td>{{ $equipement->marque }} {{ $equipement->modele }}</td>
                    <td>
                        @if($equipement->etat == 'neuf' || $equipement->etat == 'bon')
                        <span class="badge badge-success">{{ $equipement->etat }}</span>
                        @elseif($equipement->etat == 'moyen')
                        <span class="badge badge-warning">{{ $equipement->etat }}</span>
                        @else
                        <span class="badge badge-danger">{{ $equipement->etat }}</span>
                        @endif
                    </td>
                    <td>{{ $equipement->localisation }}</td>
                    <td>{{ $equipement->date_acquisition ? date('d/m/Y', strtotime($equipement->date_acquisition)) : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @elseif($type === 'utilisateurs')
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Date d'inscription</th>
                    <th>Dernière connexion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                        <span class="badge badge-danger">Admin</span>
                        @elseif($user->role == 'technicien')
                        <span class="badge badge-warning">Technicien</span>
                        @else
                        <span class="badge badge-info">Utilisateur</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Jamais' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @elseif($type === 'tickets')
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Équipement</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Technicien</th>
                    <th>Date d'ouverture</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->titre }}</td>
                    <td>{{ $ticket->equipement->nom ?? 'N/A' }}</td>
                    <td>
                        @if($ticket->priorite == 'urgente')
                        <span class="badge badge-danger">Urgente</span>
                        @elseif($ticket->priorite == 'haute')
                        <span class="badge badge-warning">Haute</span>
                        @elseif($ticket->priorite == 'moyenne')
                        <span class="badge badge-info">Moyenne</span>
                        @else
                        <span class="badge badge-success">Faible</span>
                        @endif
                    </td>
                    <td>
                        @if($ticket->statut == 'ouvert')
                        <span class="badge badge-danger">Ouvert</span>
                        @elseif($ticket->statut == 'en_cours')
                        <span class="badge badge-warning">En cours</span>
                        @elseif($ticket->statut == 'termine')
                        <span class="badge badge-success">Terminé</span>
                        @else
                        <span class="badge badge-secondary">Annulé</span>
                        @endif
                    </td>
                    <td>{{ $ticket->technicien->name ?? 'Non assigné' }}</td>
                    <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @elseif($type === 'affectations')
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Équipement</th>
                    <th>Utilisateur</th>
                    <th>Date d'affectation</th>
                    <th>Date de retour</th>
                    <th>Statut</th>
                    <th>Raison</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $affectation)
                <tr>
                    <td>{{ $affectation->id }}</td>
                    <td>{{ $affectation->equipement->nom ?? 'N/A' }}</td>
                    <td>{{ $affectation->user->name ?? 'N/A' }}</td>
                    <td>{{ $affectation->date_affectation->format('d/m/Y') }}</td>
                    <td>{{ $affectation->date_retour ? $affectation->date_retour->format('d/m/Y') : 'En cours' }}</td>
                    <td>
                        @if($affectation->date_retour)
                        <span class="badge badge-secondary">Retourné</span>
                        @else
                        <span class="badge badge-success">Actif</span>
                        @endif
                    </td>
                    <td>{{ $affectation->raison ?: 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    @else
        <div style="text-align: center; padding: 40px; color: #6b7280;">
            <h3>Aucune donnée disponible</h3>
            <p>Aucun enregistrement trouvé pour la période sélectionnée.</p>
        </div>
    @endif
    
    <div class="footer">
        <p>Généré automatiquement par le système de gestion de parc informatique</p>
        <p>© {{ date('Y') }} Gestion Parc Informatique • Page </p>
    </div>
</body>
</html>