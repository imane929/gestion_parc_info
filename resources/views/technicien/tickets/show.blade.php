@extends('layouts.technicien')

@section('title', 'Détails du Ticket #' . $ticket->id)

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Ticket #{{ $ticket->id }}</h1>
            <p class="text-muted mb-0">{{ $ticket->titre }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('technicien.tickets.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Retour
            </a>
            @if($ticket->statut == 'ouvert')
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#startInterventionModal">
                    <i class="fas fa-play me-2"></i> Démarrer
                </button>
            @endif
            @if($ticket->statut == 'en_cours')
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeModal">
                    <i class="fas fa-check me-2"></i> Terminer
                </button>
            @endif
        </div>
    </div>

    <div class="row">
        <!-- Left Column: Ticket Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Détails du Ticket</h3>
                    <span class="badge bg-{{ $ticket->statut == 'ouvert' ? 'danger' : ($ticket->statut == 'en_cours' ? 'warning' : 'success') }}">
                        {{ ucfirst($ticket->statut) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Équipement</h6>
                            <p class="mb-0">
                                <i class="fas fa-desktop me-2 text-primary"></i>
                                {{ $ticket->equipement->nom ?? 'Non spécifié' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Priorité</h6>
                            <p class="mb-0">
                                @if($ticket->priorite == 'urgente')
                                    <span class="badge bg-danger">Urgente</span>
                                @elseif($ticket->priorite == 'haute')
                                    <span class="badge bg-warning">Haute</span>
                                @elseif($ticket->priorite == 'moyenne')
                                    <span class="badge bg-info">Moyenne</span>
                                @else
                                    <span class="badge bg-success">Faible</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Type</h6>
                            <p class="mb-0">
                                <i class="fas fa-tag me-2 text-primary"></i>
                                {{ ucfirst($ticket->type ?? 'Non spécifié') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Date de création</h6>
                            <p class="mb-0">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                    
                    <h6 class="text-muted mb-2">Description</h6>
                    <div class="bg-light p-3 rounded mb-4">
                        <p class="mb-0">{{ $ticket->description }}</p>
                    </div>
                    
                    @if($ticket->notes)
                    <h6 class="text-muted mb-2">Notes additionnelles</h6>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0">{{ $ticket->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Intervention History -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Historique des Interventions</h3>
                </div>
                <div class="card-body">
                    @if($ticket->interventions && $ticket->interventions->count() > 0)
                        <div class="timeline">
                            @foreach($ticket->interventions as $intervention)
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-{{ $intervention->statut == 'termine' ? 'success' : 'warning' }}"></div>
                                <div class="timeline-content">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-1">{{ $intervention->titre }}</h6>
                                            <p class="text-muted small mb-2">
                                                {{ $intervention->description }}
                                            </p>
                                            <div class="small text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $intervention->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <span class="badge bg-{{ $intervention->statut == 'termine' ? 'success' : 'warning' }}">
                                            {{ ucfirst($intervention->statut) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Aucune intervention enregistrée</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Right Column: Actions & Info -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title mb-0">Actions Rapides</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($ticket->statut == 'ouvert')
                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#startInterventionModal">
                                <i class="fas fa-play me-2"></i> Démarrer l'intervention
                            </button>
                        @endif
                        
                        @if($ticket->statut == 'en_cours')
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#completeModal">
                                <i class="fas fa-check me-2"></i> Marquer comme terminé
                            </button>
                            
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                                <i class="fas fa-plus me-2"></i> Ajouter une note
                            </button>
                        @endif
                        
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#assignModal">
                            <i class="fas fa-user-plus me-2"></i> Assigner à un technicien
                        </button>
                        
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-print me-2"></i> Imprimer
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Ticket Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Informations</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Créé par</h6>
                        <div class="d-flex align-items-center">
                            <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                {{ strtoupper(substr($ticket->createur->name ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $ticket->createur->name ?? 'Utilisateur' }}</strong>
                                <div class="text-muted small">{{ $ticket->createur->email ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted mb-2">Technicien assigné</h6>
                        @if($ticket->technicien)
                            <div class="d-flex align-items-center">
                                <div class="avatar bg-warning text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                    {{ strtoupper(substr($ticket->technicien->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $ticket->technicien->name }}</strong>
                                    <div class="text-muted small">{{ $ticket->technicien->email }}</div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0">Aucun technicien assigné</p>
                        @endif
                    </div>
                    
                    <div>
                        <h6 class="text-muted mb-2">Dernière mise à jour</h6>
                        <p class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            {{ $ticket->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Start Intervention Modal -->
<div class="modal fade" id="startInterventionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Démarrer l'intervention</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir démarrer l'intervention sur ce ticket ?</p>
                <form action="{{ route('technicien.interventions.start', $ticket) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="intervention_description" class="form-label">Description de l'intervention</label>
                        <textarea class="form-control" id="intervention_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estimated_time" class="form-label">Temps estimé (heures)</label>
                        <input type="number" class="form-control" id="estimated_time" name="estimated_time" min="0.5" max="24" step="0.5" value="1">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-warning" onclick="document.querySelector('#startInterventionModal form').submit()">
                    <i class="fas fa-play me-2"></i> Démarrer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terminer l'intervention</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Marquer cette intervention comme terminée ?</p>
                <form action="{{ route('technicien.interventions.complete', $ticket) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="solution" class="form-label">Solution apportée</label>
                        <textarea class="form-control" id="solution" name="solution" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="time_spent" class="form-label">Temps passé (heures)</label>
                        <input type="number" class="form-control" id="time_spent" name="time_spent" min="0.1" max="24" step="0.1" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" onclick="document.querySelector('#completeModal form').submit()">
                    <i class="fas fa-check me-2"></i> Terminer
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
    }
    
    .timeline-content {
        padding-left: 10px;
    }
    
    .avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>
@endsection