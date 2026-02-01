@extends('layouts.user')

@section('title', 'Tableau de Bord Utilisateur')

@section('content')
    <!-- Welcome Message -->
    <div class="text-center mb-5">
        <h2 class="h1 mb-3">Bonjour, {{ Auth::user()->name }}!</h2>
        <p class="text-muted">Bienvenue sur votre tableau de bord utilisateur</p>
    </div>
    
    <!-- Stats Cards -->
    <div class="user-stats-grid">
        <div class="user-stat-card">
            <div class="user-stat-icon">
                <i class="fas fa-desktop"></i>
            </div>
            <div class="user-stat-number">{{ $equipementsCount ?? 0 }}</div>
            <div class="user-stat-label">Équipements Assignés</div>
        </div>
        
        <div class="user-stat-card">
            <div class="user-stat-icon">
                <i class="fas fa-ticket-alt"></i>
            </div>
            <div class="user-stat-number">{{ $ticketsCount ?? 0 }}</div>
            <div class="user-stat-label">Mes Tickets</div>
        </div>
        
        <div class="user-stat-card">
            <div class="user-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="user-stat-number">{{ $resolvedTickets ?? 0 }}</div>
            <div class="user-stat-label">Tickets Résolus</div>
        </div>
        
        <div class="user-stat-card">
            <div class="user-stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="user-stat-number">{{ $pendingTickets ?? 0 }}</div>
            <div class="user-stat-label">En Attente</div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Mes Équipements</h3>
                </div>
                <div class="card-body">
                    @if($equipements && $equipements->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($equipements as $equipement)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">{{ $equipement->nom }}</h6>
                                <small class="text-muted">{{ $equipement->type }} • {{ $equipement->localisation }}</small>
                            </div>
                            <span class="badge bg-{{ $equipement->etat == 'actif' ? 'success' : 'warning' }}">
                                {{ ucfirst($equipement->etat) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Aucun équipement assigné pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Mes Tickets Récents</h3>
                </div>
                <div class="card-body">
                    @if($tickets && $tickets->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($tickets as $ticket)
                        <div class="list-group-item">
                            <h6 class="mb-1">{{ $ticket->titre }}</h6>
                            <small class="text-muted d-block mb-1">{{ $ticket->equipement->nom ?? 'N/A' }}</small>
                            <div class="d-flex justify-content-between">
                                <span class="badge bg-{{ $ticket->statut == 'ouvert' ? 'danger' : ($ticket->statut == 'en_cours' ? 'warning' : 'success') }}">
                                    {{ ucfirst($ticket->statut) }}
                                </span>
                                <small class="text-muted">{{ $ticket->created_at->format('d/m/Y') }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-muted text-center py-3">Aucun ticket créé pour le moment.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Links -->
    <div class="text-center">
        <div class="btn-group" role="group">
            <a href="{{ route('user.tickets.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Créer un Ticket
            </a>
            <a href="{{ route('user.tickets') }}" class="btn btn-outline-primary">
                <i class="fas fa-ticket-alt me-2"></i>Voir mes Tickets
            </a>
            <a href="{{ route('user.equipements') }}" class="btn btn-outline-primary">
                <i class="fas fa-desktop me-2"></i>Mes Équipements
            </a>
        </div>
    </div>
@endsection