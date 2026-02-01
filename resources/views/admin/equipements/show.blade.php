@extends('admin.layouts.admin')

@section('title', 'Détails Équipement')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Détails de l'équipement</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.equipements.edit', $equipement) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </a>
                            <a href="{{ route('admin.equipements.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="avatar bg-info text-white d-flex align-items-center justify-content-center mx-auto rounded mb-3" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                <i class="fas fa-desktop"></i>
                            </div>
                            <h4 class="mb-1">{{ $equipement->nom }}</h4>
                            <span class="badge bg-{{ $equipement->etat == 'neuf' || $equipement->etat == 'bon' ? 'success' : ($equipement->etat == 'moyen' ? 'warning' : 'danger') }}">
                                {{ ucfirst($equipement->etat) }}
                            </span>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Type</label>
                                    <p class="form-control-plaintext">{{ $equipement->type }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Localisation</label>
                                    <p class="form-control-plaintext">{{ $equipement->localisation }}</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Marque/Modèle</label>
                                    <p class="form-control-plaintext">{{ $equipement->marque }} {{ $equipement->modele }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Numéro de série</label>
                                    <p class="form-control-plaintext">{{ $equipement->numero_serie ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted">Date d'acquisition</label>
                                    <p class="form-control-plaintext">{{ $equipement->date_acquisition ? date('d/m/Y', strtotime($equipement->date_acquisition)) : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted">ID</label>
                                    <p class="form-control-plaintext">#{{ $equipement->id }}</p>
                                </div>
                            </div>
                            
                            @if($equipement->notes)
                            <div class="mb-3">
                                <label class="form-label text-muted">Notes</label>
                                <div class="border rounded p-3 bg-light">
                                    {{ $equipement->notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- Equipment History -->
                    <h5 class="mb-3">Historique</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Événement</th>
                                    <th>Description</th>
                                    <th>Utilisateur</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $equipement->created_at->format('d/m/Y H:i') }}</td>
                                    <td><span class="badge bg-success">Création</span></td>
                                    <td>Équipement ajouté au parc</td>
                                    <td>Système</td>
                                </tr>
                                <!-- Add more history rows as needed -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection