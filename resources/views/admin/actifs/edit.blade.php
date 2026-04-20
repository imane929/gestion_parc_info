@extends('layouts.admin-new')

@section('title', 'Modifier l\'actif')
@section('page-title', 'Modifier l\'actif')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Modifier l'actif: {{ $actif->code_inventaire }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.actifs.update', $actif) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Code inventaire -->
                        <div class="col-md-4">
                            <label class="form-label">Code inventaire <span class="text-danger">*</span></label>
                            <input type="text" name="code_inventaire" class="form-control @error('code_inventaire') is-invalid @enderror" 
                                   value="{{ old('code_inventaire', $actif->code_inventaire) }}" required>
                            @error('code_inventaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Type -->
                        <div class="col-md-4">
                            <label class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Sélectionner...</option>
                                <option value="pc" {{ old('type', $actif->type) == 'pc' ? 'selected' : '' }}>PC</option>
                                <option value="serveur" {{ old('type', $actif->type) == 'serveur' ? 'selected' : '' }}>Serveur</option>
                                <option value="imprimante" {{ old('type', $actif->type) == 'imprimante' ? 'selected' : '' }}>Imprimante</option>
                                <option value="reseau" {{ old('type', $actif->type) == 'reseau' ? 'selected' : '' }}>Équipement réseau</option>
                                <option value="peripherique" {{ old('type', $actif->type) == 'peripherique' ? 'selected' : '' }}>Périphérique</option>
                                <option value="mobile" {{ old('type', $actif->type) == 'mobile' ? 'selected' : '' }}>Appareil mobile</option>
                                <option value="autre" {{ old('type', $actif->type) == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- État -->
                        <div class="col-md-4">
                            <label class="form-label">État <span class="text-danger">*</span></label>
                            <select name="etat" class="form-select @error('etat') is-invalid @enderror" required>
                                <option value="">Sélectionner...</option>
                                <option value="neuf" {{ old('etat', $actif->etat) == 'neuf' ? 'selected' : '' }}>Neuf</option>
                                <option value="bon" {{ old('etat', $actif->etat) == 'bon' ? 'selected' : '' }}>Bon</option>
                                <option value="moyen" {{ old('etat', $actif->etat) == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                <option value="mauvais" {{ old('etat', $actif->etat) == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                                <option value="hors_service" {{ old('etat', $actif->etat) == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                            </select>
                            @error('etat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Marque -->
                        <div class="col-md-4">
                            <label class="form-label">Marque <span class="text-danger">*</span></label>
                            <input type="text" name="marque" class="form-control @error('marque') is-invalid @enderror" 
                                   value="{{ old('marque', $actif->marque) }}" required>
                            @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Modèle -->
                        <div class="col-md-4">
                            <label class="form-label">Modèle <span class="text-danger">*</span></label>
                            <input type="text" name="modele" class="form-control @error('modele') is-invalid @enderror" 
                                   value="{{ old('modele', $actif->modele) }}" required>
                            @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Numéro de série -->
                        <div class="col-md-4">
                            <label class="form-label">Numéro de série <span class="text-danger">*</span></label>
                            <input type="text" name="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" 
                                   value="{{ old('numero_serie', $actif->numero_serie) }}" required>
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Date d'achat -->
                        <div class="col-md-4">
                            <label class="form-label">Date d'achat</label>
                            <input type="date" name="date_achat" class="form-control @error('date_achat') is-invalid @enderror" 
                                   value="{{ old('date_achat', $actif->date_achat ? $actif->date_achat->format('Y-m-d') : '') }}">
                            @error('date_achat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Fin de garantie -->
                        <div class="col-md-4">
                            <label class="form-label">Date de fin de garantie</label>
                            <input type="date" name="garantie_fin" class="form-control @error('garantie_fin') is-invalid @enderror" 
                                   value="{{ old('garantie_fin', $actif->garantie_fin ? $actif->garantie_fin->format('Y-m-d') : '') }}">
                            @error('garantie_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Localisation -->
                        <div class="col-md-4">
                            <label class="form-label">Localisation</label>
                            <select name="localisation_id" class="form-select select2 @error('localisation_id') is-invalid @enderror">
                                <option value="">Sélectionner...</option>
                                @foreach($localisations as $localisation)
                                    <option value="{{ $localisation->id }}" {{ old('localisation_id', $actif->localisation_id) == $localisation->id ? 'selected' : '' }}>
                                        {{ $localisation->nom_complet }}
                                    </option>
                                @endforeach
                            </select>
                            @error('localisation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Affectation actuelle -->
                        <div class="col-12">
                            <hr>
                            <h6>Affectation actuelle</h6>
                            @if($actif->utilisateurAffecte)
                                <div class="alert alert-info">
                                    Actuellement affecté à: <strong>{{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}</strong>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Changer l'affectation</label>
                            <select name="utilisateur_affecte_id" class="form-select select2">
                                <option value="">Non affecté</option>
                                @foreach($utilisateurs as $user)
                                    <option value="{{ $user->id }}" {{ old('utilisateur_affecte_id', $actif->utilisateur_affecte_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->full_name ?? $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Description / Notes -->
                        <div class="col-12">
                            <label class="form-label">Notes / Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $actif->description ?? '') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Mettre à jour l'actif
                            </button>
                            <a href="{{ route('admin.actifs.show', $actif) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Annuler
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


