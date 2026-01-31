@extends('admin.layouts.admin')

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
                            <td>{{ $affectation->equipement->nom ?? 'N/A' }}</td>
                            <td>{{ $affectation->user->name ?? 'N/A' }}</td>
                            <td>{{ $affectation->date_affectation->format('d/m/Y') }}</td>
                            <td>{{ $affectation->date_retour ? $affectation->date_retour->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($affectation->date_retour)
                                <span class="badge bg-secondary">Retourné</span>
                                @else
                                <span class="badge bg-success">Actif</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.affectations.edit', $affectation) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.affectations.destroy', $affectation) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Êtes-vous sûr ?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Aucune affectation trouvée
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
@endsection