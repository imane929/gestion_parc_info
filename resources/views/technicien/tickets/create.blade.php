@extends('layouts.technicien')

@section('title', 'Créer un Ticket')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Créer un Nouveau Ticket</h1>
            <p class="text-muted mb-0">Signalez un problème ou une demande de maintenance</p>
        </div>
        <a href="{{ route('technicien.tickets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Retour
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('technicien.tickets.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="titre" class="form-label">Titre du ticket *</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                               id="titre" name="titre" value="{{ old('titre') }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="equipement_id" class="form-label">Équipement concerné *</label>
                        <select class="form-control @error('equipement_id') is-invalid @enderror" 
                                id="equipement_id" name="equipement_id" required>
                            <option value="">Sélectionner un équipement</option>
                            <option value="1" {{ old('equipement_id') == '1' ? 'selected' : '' }}>PC Bureau - Bureau 101</option>
                            <option value="2" {{ old('equipement_id') == '2' ? 'selected' : '' }}>Imprimante - Salle Réunion</option>
                            <option value="3" {{ old('equipement_id') == '3' ? 'selected' : '' }}>Serveur - Salle Serveurs</option>
                            <option value="4" {{ old('equipement_id') == '4' ? 'selected' : '' }}>Switch Réseau - Étage 2</option>
                        </select>
                        @error('equipement_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Type de problème *</label>
                        <select class="form-control @error('type') is-invalid @enderror" 
                                id="type" name="type" required>
                            <option value="">Sélectionner un type</option>
                            <option value="hardware" {{ old('type') == 'hardware' ? 'selected' : '' }}>Matériel</option>
                            <option value="software" {{ old('type') == 'software' ? 'selected' : '' }}>Logiciel</option>
                            <option value="network" {{ old('type') == 'network' ? 'selected' : '' }}>Réseau</option>
                            <option value="peripheral" {{ old('type') == 'peripheral' ? 'selected' : '' }}>Périphérique</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label for="priorite" class="form-label">Priorité *</label>
                        <select class="form-control @error('priorite') is-invalid @enderror" 
                                id="priorite" name="priorite" required>
                            <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                            <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }} selected>Moyenne</option>
                            <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                            <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                        </select>
                        @error('priorite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description détaillée *</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                    <small class="text-muted">Décrivez le problème en détail, les étapes pour le reproduire, et tout message d'erreur</small>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes additionnelles</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    <small class="text-muted">Informations complémentaires (numéro de série, version logicielle, etc.)</small>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('technicien.tickets.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i> Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i> Créer le Ticket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection