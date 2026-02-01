@extends('layouts.admin')

@section('title', 'Gestion des Affectations')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Liste des Affectations</h2>
            <p class="text-muted mb-0">Gérez les affectations d'équipements</p>
        </div>
        <a href="{{ route('admin.affectations.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Nouvelle Affectation
        </a>
    </div>
    
    <!-- Affectations Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Équipement</th>
                            <th>Utilisateur</th>
                            <th>Date Affectation</th>
                            <th>Date Retour</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($affectations as $affectation)
                        <tr>
                            <td>#{{ $affectation->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-desktop text-primary me-2"></i>
                                    <div>
                                        <strong>{{ $affectation->equipement->nom ?? 'N/A' }}</strong>
                                        <div class="text-muted small">{{ $affectation->equipement->type ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2">
                                        {{ strtoupper(substr($affectation->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <strong>{{ $affectation->user->name ?? 'N/A' }}</strong>
                                        <div class="text-muted small">{{ $affectation->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($affectation->date_affectation)->format('d/m/Y') }}</td>
                            <td>
                                @if($affectation->date_retour)
                                    {{ \Carbon\Carbon::parse($affectation->date_retour)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($affectation->statut === 'retourné')
                                    <span class="badge bg-secondary">Retourné</span>
                                @elseif(\Carbon\Carbon::parse($affectation->date_affectation)->diffInDays(now()) > 30)
                                    <span class="badge bg-warning">Ancienne</span>
                                @else
                                    <span class="badge bg-success">Actif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.affectations.show', $affectation) }}" class="btn btn-sm btn-outline-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.affectations.edit', $affectation) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.affectations.destroy', $affectation) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette affectation ?')" 
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-inbox fa-2x mb-3"></i>
                                <p>Aucune affectation trouvée</p>
                                <a href="{{ route('admin.affectations.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i>Créer une affectation
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($affectations->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $affectations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
        font-weight: 600;
    }
</style>
@endsection