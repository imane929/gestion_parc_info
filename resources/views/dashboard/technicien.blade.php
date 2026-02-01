@extends('layouts.technicien')

@section('title', 'Tableau de Bord Technicien')

@section('content')
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #dbeafe; color: var(--primary);">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="stat-number" id="ticketsAssigned">{{ $stats['tickets_assigned'] ?? 8 }}</div>
            <div class="stat-label">Tickets Assignés</div>
            <div class="mt-2">
                <span class="badge badge-danger">3 Urgents</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: var(--warning);">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-number" id="activeInterventions">{{ $stats['active_interventions'] ?? 5 }}</div>
            <div class="stat-label">Interventions Actives</div>
            <div class="mt-2">
                <span class="badge badge-warning">En cours</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: var(--secondary);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-number" id="ticketsResolved">{{ $stats['tickets_resolved'] ?? 24 }}</div>
            <div class="stat-label">Tickets Résolus</div>
            <div class="mt-2">
                <span class="badge badge-success">Ce mois</span>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background: #f3f4f6; color: var(--gray);">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-number" id="responseTime">2.4h</div>
            <div class="stat-label">Temps de Réponse Moyen</div>
            <div class="mt-2">
                <span class="badge badge-info">Amélioré de 15%</span>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('technicien.tickets.create') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-plus-circle"></i>
            </div>
            <div class="action-text">Nouveau Ticket</div>
        </a>
        
        <a href="{{ route('technicien.interventions') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
            <div class="action-text">Mes Interventions</div>
        </a>
        
        <a href="{{ route('technicien.historique') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-history"></i>
            </div>
            <div class="action-text">Historique</div>
        </a>
        
        <a href="{{ route('technicien.rapports') }}" class="action-card">
            <div class="action-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="action-text">Rapports</div>
        </a>
    </div>
    
    <!-- Main Content Grid -->
    <div class="row">
        <!-- Left Column: Tickets -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Tickets de Maintenance</h3>
                    <a href="{{ route('technicien.tickets.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nouveau
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID Ticket</th>
                                    <th>Équipement</th>
                                    <th>Priorité</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets ?? [] as $ticket)
                                <tr>
                                    <td><strong>#{{ $ticket->id }}</strong></td>
                                    <td>{{ $ticket->equipement->nom ?? 'N/A' }}</td>
                                    <td>
                                        @if($ticket->priorite == 'haute')
                                        <span class="badge badge-danger">Haute</span>
                                        @elseif($ticket->priorite == 'moyenne')
                                        <span class="badge badge-warning">Moyenne</span>
                                        @else
                                        <span class="badge badge-success">Basse</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($ticket->statut == 'ouvert')
                                        <span class="badge badge-danger">Ouvert</span>
                                        @elseif($ticket->statut == 'en_cours')
                                        <span class="badge badge-warning">En cours</span>
                                        @else
                                        <span class="badge badge-success">Terminé</span>
                                        @endif
                                    </td>
                                    <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('technicien.tickets.show', $ticket) }}" class="btn btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($ticket->statut == 'ouvert')
                                            <a href="{{ route('technicien.tickets.start', $ticket) }}" class="btn btn-outline-warning">
                                                <i class="fas fa-play"></i>
                                            </a>
                                            @elseif($ticket->statut == 'en_cours')
                                            <a href="{{ route('technicien.tickets.complete', $ticket) }}" class="btn btn-outline-success">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">
                                        Aucun ticket assigné
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end mt-3">
                        <a href="{{ route('technicien.tickets') }}" class="btn btn-outline-primary btn-sm">
                            Voir tous les tickets <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Tasks & Equipment -->
        <div class="col-lg-4">
            <!-- Daily Tasks -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Tâches du Jour</h3>
                    <span class="badge bg-info">{{ $completedTasks ?? 3 }}/{{ $totalTasks ?? 5 }}</span>
                </div>
                <div class="card-body">
                    <ul class="tasks-list">
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Vérifier backup serveur</h4>
                                <p>10:00 AM - Salle serveurs</p>
                            </div>
                            <div class="task-checkbox checked">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Maintenance imprimante 203</h4>
                                <p>11:30 AM - Bureau 203</p>
                            </div>
                            <div class="task-checkbox checked">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Installation nouveau PC</h4>
                                <p>14:00 PM - Direction</p>
                            </div>
                            <div class="task-checkbox checked">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Diagnostic réseau étage 2</h4>
                                <p>15:30 PM - Étage 2</p>
                            </div>
                            <div class="task-checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Mise à jour inventaire</h4>
                                <p>16:00 PM - Bureau</p>
                            </div>
                            <div class="task-checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Equipment Status -->
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">État des Équipements</h3>
                </div>
                <div class="card-body">
                    <div class="equipment-status">
                        <div class="equipment-info">
                            <h4>PC Bureau 205</h4>
                            <p>Dernière maintenance: 10/01/2024</p>
                        </div>
                        <span class="badge badge-success">OK</span>
                    </div>
                    <div class="equipment-status">
                        <div class="equipment-info">
                            <h4>Serveur Principal</h4>
                            <p>Prochaine maintenance: 25/01/2024</p>
                        </div>
                        <span class="badge badge-warning">À vérifier</span>
                    </div>
                    <div class="equipment-status">
                        <div class="equipment-info">
                            <h4>Imprimante Réunion</h4>
                            <p>Cartouche à 15%</p>
                        </div>
                        <span class="badge badge-warning">Attention</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection