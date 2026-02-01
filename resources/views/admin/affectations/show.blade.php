@extends('admin.layouts.admin')

@section('title', 'Détails Affectation')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails de l'affectation #{{ $affectation->id }}</h5>
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
                                            <p class="text-muted small mb-0">
                                                <i class="fas fa-map-marker-alt"></i> {{ $affectation->equipement->localisation ?? '' }}
                                            </p>
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
                                            <p class="text-muted small mb-0">
                                                <span class="badge bg-secondary">{{ ucfirst($affectation->user->role ?? 'utilisateur') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted">Date d'affectation</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    <input type="text" class="form-control bg-white" 
                                           value="{{ \Carbon\Carbon::parse($affectation->date_affectation)->format('d/m/Y') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted">Date de retour</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                    <input type="text" class="form-control bg-white" 
                                           value="{{ $affectation->date_retour ? $affectation->date_retour->format('d/m/Y') : 'Non spécifiée' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted">Statut</label>
                                <div>
                                    @if($affectation->statut === 'retourné')
                                        <span class="badge bg-secondary fs-6 py-2 px-3">
                                            <i class="fas fa-check-circle me-1"></i> Retourné
                                        </span>
                                    @else
                                        <span class="badge bg-success fs-6 py-2 px-3">
                                            <i class="fas fa-sync-alt me-1"></i> Actif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted">Durée</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                    <input type="text" class="form-control bg-white" 
                                           value="@if($affectation->date_retour)
                                                    {{ \Carbon\Carbon::parse($affectation->date_affectation)->diffInDays($affectation->date_retour) }} jours
                                                  @else
                                                    {{ \Carbon\Carbon::parse($affectation->date_affectation)->diffInDays(now()) }} jours (en cours)
                                                  @endif" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($affectation->raison)
                    <div class="mb-4">
                        <label class="form-label text-muted">Raison de l'affectation</label>
                        <div class="border rounded p-3 bg-light">
                            <i class="fas fa-comment text-primary me-2"></i>
                            {{ $affectation->raison }}
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted">Date de création</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-plus"></i></span>
                                    <input type="text" class="form-control bg-white" 
                                           value="{{ $affectation->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label text-muted">Dernière mise à jour</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-history"></i></span>
                                    <input type="text" class="form-control bg-white" 
                                           value="{{ $affectation->updated_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection