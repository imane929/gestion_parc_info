@extends('layouts.admin-new')

@section('title', 'Détails de l\'actif')
@section('page-title', 'Détails de l\'actif')

@section('content')
<div class="row">
    <!-- Main Info Card -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Informations de l'actif</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    @php
                        $typeIcon = [
                            'pc' => 'fa-desktop',
                            'serveur' => 'fa-server',
                            'imprimante' => 'fa-print',
                            'reseau' => 'fa-network-wired',
                            'peripherique' => 'fa-mouse',
                            'mobile' => 'fa-mobile-alt',
                            'autre' => 'fa-question-circle'
                        ][$actif->type] ?? 'fa-desktop';
                    @endphp
                    <div class="mx-auto mb-3" style="width: 100px; height: 100px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2.5rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas {{ $typeIcon }}"></i>
                    </div>
                    <h4>{{ $actif->marque }} {{ $actif->modele }}</h4>
                    <p class="text-muted">{{ $actif->code_inventaire }}</p>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-tag me-2 text-primary"></i> Type</span>
                        <span class="badge bg-primary">{{ ucfirst($actif->type) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-barcode me-2 text-primary"></i> Numéro de série</span>
                        <code>{{ $actif->numero_serie }}</code>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-calendar me-2 text-primary"></i> Date d'achat</span>
                        <span>{{ $actif->date_achat ? $actif->date_achat->format('d/m/Y') : 'Non spécifié' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-shield-alt me-2 text-primary"></i> Garantie</span>
                        @if($actif->garantie_fin)
                            <span class="{{ $actif->garantieEstValide() ? 'text-success' : 'text-danger' }}">
                                {{ \Carbon\Carbon::parse($actif->garantie_fin)->format('d/m/Y') }}
                                @if($actif->garantieEstValide())
                                    <br><small>{{ $actif->jours_restants_garantie ?? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($actif->garantie_fin)) }} jours restants</small>
                                @endif
                            </span>
                        @else
                            <span class="text-muted">Non spécifié</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-map-marker-alt me-2 text-primary"></i> Localisation</span>
                        @if($actif->localisation)
                            <span>{{ $actif->localisation->nom_complet }}</span>
                        @else
                            <span class="text-muted">Non défini</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-user me-2 text-primary"></i> Affecté à</span>
                        @if($actif->utilisateurAffecte)
                            <span>{{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}</span>
                        @else
                            <span class="text-muted">Non affecté</span>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-chart-line me-2 text-primary"></i> État</span>
                        @php
                            $etatClass = [
                                'neuf' => 'badge bg-success',
                                'bon' => 'badge bg-info',
                                'moyen' => 'badge bg-warning',
                                'mauvais' => 'badge bg-danger',
                                'hors_service' => 'badge bg-dark'
                            ][$actif->etat] ?? 'badge bg-secondary';
                        @endphp
                        <span class="{{ $etatClass }}">{{ ucfirst($actif->etat) }}</span>
                    </li>
                    @if($actif->description)
                    <li class="list-group-item px-0">
                        <span><i class="fas fa-info-circle me-2 text-primary"></i> Description</span>
                        <p class="mb-0 mt-2 text-muted small">{{ $actif->description }}</p>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit actifs')
                    <a href="{{ route('admin.actifs.edit', $actif) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Modifier
                    </a>
                    @endcan
                    @can('affect actifs')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#affectationModal">
                        <i class="fas fa-user-plus me-2"></i>
                        Affecter
                    </button>
                    @endcan
                    @can('delete actifs')
                    <form method="POST" action="{{ route('admin.actifs.destroy', $actif) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-confirm">
                            <i class="fas fa-trash me-2"></i>
                            Supprimer
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            </div>
        </div>
    </div>
    
    <!-- Tabs -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="assetTabs" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                            <i class="fas fa-history me-2"></i>
                            Historique
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab" data-bs-target="#maintenance" type="button" role="tab">
                            <i class="fas fa-tools me-2"></i>
                            Maintenances
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="software-tab" data-bs-toggle="tab" data-bs-target="#software" type="button" role="tab">
                            <i class="fas fa-cube me-2"></i>
                            Logiciels
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="tickets-tab" data-bs-toggle="tab" data-bs-target="#tickets" type="button" role="tab">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Tickets
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments" type="button" role="tab">
                            <i class="fas fa-comments me-2"></i>
                            Commentaires
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="assetTabsContent">
                    <!-- History Tab -->
                    <div class="tab-pane fade show active" id="history" role="tabpanel">
                        <div class="timeline">
                            @forelse($actif->historiques()->latest()->get() as $historique)
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">{{ $historique->evenement }}</h6>
                                    <p class="text-muted mb-2">{{ $historique->details }}</p>
                                    <small class="text-muted">{{ $historique->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucun historique</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    
                    <!-- Maintenance Tab -->
                    <div class="tab-pane fade" id="maintenance" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Date prévue</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($actif->maintenancesPreventives as $maintenance)
                                    <tr>
                                        <td>{{ ucfirst($maintenance->type) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'planifie' => 'badge bg-primary',
                                                    'en_cours' => 'badge bg-warning',
                                                    'termine' => 'badge bg-success',
                                                    'annule' => 'badge bg-danger'
                                                ][$maintenance->statut] ?? 'badge bg-secondary';
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ ucfirst($maintenance->statut) }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.maintenances.show', $maintenance) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <i class="fas fa-tools fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Aucune maintenance</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Software Tab -->
                    <div class="tab-pane fade" id="software" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Logiciel</th>
                                        <th>Version</th>
                                        <th>Licence</th>
                                        <th>Date d'installation</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($actif->installationsLogiciels as $installation)
                                    <tr>
                                        <td>{{ $installation->licence->logiciel->nom }}</td>
                                        <td>{{ $installation->licence->logiciel->version }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $installation->licence->cle_licence }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($installation->date_installation)->format('d/m/Y') }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.logiciels.desinstaller', $installation) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-cube fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Aucun logiciel installé</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Tickets Tab -->
                    <div class="tab-pane fade" id="tickets" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Sujet</th>
                                        <th>Priorité</th>
                                        <th>Statut</th>
                                        <th>Créé le</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($actif->tickets as $ticket)
                                    <tr>
                                        <td><span class="fw-semibold">{{ $ticket->numero }}</span></td>
                                        <td>{{ Str::limit($ticket->sujet, 40) }}</td>
                                        <td>
                                            @php
                                                $priorityClass = [
                                                    'basse' => 'badge bg-secondary',
                                                    'moyenne' => 'badge bg-info',
                                                    'haute' => 'badge bg-warning',
                                                    'urgente' => 'badge bg-danger'
                                                ][$ticket->priorite] ?? 'badge bg-secondary';
                                            @endphp
                                            <span class="{{ $priorityClass }}">{{ ucfirst($ticket->priorite) }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'ouvert' => 'badge-status active',
                                                    'en_cours' => 'badge-status warning',
                                                    'en_attente' => 'badge-status',
                                                    'resolu' => 'badge-status success',
                                                    'ferme' => 'badge-status'
                                                ][$ticket->statut] ?? 'badge-status';
                                            @endphp
                                            <span class="{{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}</span>
                                        </td>
                                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="fas fa-ticket-alt fa-2x text-muted mb-3"></i>
                                            <p class="text-muted">Aucun ticket</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Comments Tab -->
                    <div class="tab-pane fade" id="comments" role="tabpanel">
                        <div class="mb-4">
                            <form method="POST" action="{{ route('admin.actifs.comment', $actif) }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Ajouter un commentaire</label>
                                    <textarea name="contenu" class="form-control" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Commenter
                                </button>
                            </form>
                        </div>
                        
                        <div class="comments-list">
                            @forelse($actif->commentaires()->latest()->get() as $commentaire)
                            <div class="comment-item">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar-sm blue me-2" style="width: 40px; height: 40px;">
                                        {{ $commentaire->utilisateur->initials ?? 'U' }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0">{{ $commentaire->utilisateur->full_name ?? $commentaire->utilisateur->name }}</h6>
                                        <small class="text-muted">{{ $commentaire->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                                <p class="mb-0 ms-5">{{ $commentaire->contenu }}</p>
                                <hr>
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-2x text-muted mb-3"></i>
                                <p class="text-muted">Aucun commentaire</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assignment Modal -->
<div class="modal fade" id="affectationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.actifs.affecter', $actif) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Affecter l'actif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Utilisateur</label>
                        <select name="utilisateur_id" class="form-select select2" required>
                            <option value="">Sélectionner...</option>
                            @foreach($utilisateurs ?? [] as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->full_name ?? $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date d'affectation</label>
                        <input type="date" name="date_debut" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Affecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 1.5rem;
}
.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}
.timeline-marker {
    position: absolute;
    left: -1.5rem;
    top: 0.25rem;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #3b7cff;
    border: 2px solid white;
    box-shadow: 0 0 0 2px rgba(59, 124, 255, 0.3);
}
.timeline-item::before {
    content: '';
    position: absolute;
    left: -1.05rem;
    top: 0.75rem;
    width: 2px;
    height: calc(100% - 0.75rem);
    background: #e2e8f0;
}
.timeline-item:last-child::before {
    display: none;
}
.timeline-content {
    padding-left: 0.5rem;
}
.comment-item {
    margin-bottom: 1rem;
}
</style>
@endpush
@endsection


