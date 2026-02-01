@extends('layouts.admin')

@section('title', 'Gestion des Équipements')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Liste des Équipements</h2>
            <p class="text-muted mb-0">Gérez le parc informatique</p>
        </div>
        <a href="{{ route('admin.equipements.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Ajouter un Équipement
        </a>
    </div>
    
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-desktop text-primary fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">{{ $equipements->total() }}</h5>
                            <small class="text-muted">Équipements totaux</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Equipment Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Marque/Modèle</th>
                            <th>État</th>
                            <th>Localisation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipements as $equipement)
                        <tr>
                            <td>#{{ $equipement->id }}</td>
                            <td>{{ $equipement->nom }}</td>
                            <td>{{ $equipement->type }}</td>
                            <td>{{ $equipement->marque }} {{ $equipement->modele }}</td>
                            <td>
                                @if($equipement->etat == 'neuf' || $equipement->etat == 'bon')
                                <span class="badge bg-success">{{ $equipement->etat }}</span>
                                @elseif($equipement->etat == 'moyen')
                                <span class="badge bg-warning">{{ $equipement->etat }}</span>
                                @else
                                <span class="badge bg-danger">{{ $equipement->etat }}</span>
                                @endif
                            </td>
                            <td>{{ $equipement->localisation }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.equipements.edit', $equipement) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.equipements.destroy', $equipement) }}" method="POST" class="d-inline">
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
                                Aucun équipement trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($equipements->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $equipements->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection