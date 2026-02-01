@extends('admin.layouts.admin')

@section('title', 'Détails Affectation')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails de l'affectation</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.affectations.edit', $affectation) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </a>
                            <a href="{{ route('admin.affectations.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Équipement</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-info text-white d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 50px; height: 50px;">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $affectation->equipement->nom ?? 'N/A' }}</h5>
                                            <p class="text-muted mb-0">{{ $affectation->equipement->type ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h6 class="card-title text-muted">Utilisateur</h6>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-3" style="width: 50px; height: 50px;">
                                            {{ strtoupper(substr($affectation->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <h5 class="mb-0">{{ $affectation->user->name ?? 'N/A' }}</h5>
                                            <p class="text-muted mb-0">{{ $affectation->user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Date d'affectation</label>
                            <p class="form-control-plaintext">{{ $affectation->date_affectation->format('d/m/Y') }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label text-muted">Date de retour</label>
                            <p class="form-control-plaintext">
                                @if($affectation->date_retour)
                                    {{ $affectation->date_retour->format('d/m/Y') }}
                                    <span class="badge bg-secondary ms-2">Retourné</span>
                                @else
                                    <span class="text-warning">En cours</span>
                                    <span class="badge bg-success ms-2">Actif</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    @if($affectation->raison)
                    <div class="mb-3">
                        <label class="form-label text-muted">Raison de l'affectation</label>
                        <div class="border rounded p-3 bg-light">
                            {{ $affectation->raison }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Statut</label>
                        <p class="form-control-plaintext">
                            @if($affectation->date_retour)
                                <span class="badge bg-secondary">Terminé</span>
                            @else
                                <span class="badge bg-success">Actif</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">ID</label>
                        <p class="form-control-plaintext">#{{ $affectation->id }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted">Date de création</label>
                        <p class="form-control-plaintext">{{ $affectation->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection