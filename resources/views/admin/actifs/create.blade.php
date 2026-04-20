@extends('layouts.admin-new')

@section('title', 'Nouvel actif')

@section('page-title', 'Créer un actif')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informations de l'actif</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.actifs.store') }}">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Code inventaire -->
                        <div class="col-md-4">
                            <label class="form-label">Code inventaire</label>
                            <input type="text" name="code_inventaire" class="form-control @error('code_inventaire') is-invalid @enderror" 
                                   value="{{ old('code_inventaire') }}" required>
                            @error('code_inventaire')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: INV-XXXXX</small>
                        </div>
                        
                        <!-- Type -->
                        <div class="col-md-4">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Choisir...</option>
                                <option value="pc" {{ old('type') == 'pc' ? 'selected' : '' }}>PC</option>
                                <option value="serveur" {{ old('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                                <option value="imprimante" {{ old('type') == 'imprimante' ? 'selected' : '' }}>Imprimante</option>
                                <option value="reseau" {{ old('type') == 'reseau' ? 'selected' : '' }}>Équipement réseau</option>
                                <option value="peripherique" {{ old('type') == 'peripherique' ? 'selected' : '' }}>Périphérique</option>
                                <option value="mobile" {{ old('type') == 'mobile' ? 'selected' : '' }}>Appareil mobile</option>
                                <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- État -->
                        <div class="col-md-4">
                            <label class="form-label">État</label>
                            <select name="etat" class="form-select @error('etat') is-invalid @enderror" required>
                                <option value="">Choisir...</option>
                                <option value="neuf" {{ old('etat') == 'neuf' ? 'selected' : '' }}>Neuf</option>
                                <option value="bon" {{ old('etat') == 'bon' ? 'selected' : '' }}>Bon</option>
                                <option value="moyen" {{ old('etat') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                <option value="mauvais" {{ old('etat') == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                                <option value="hors_service" {{ old('etat') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                            </select>
                            @error('etat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Marque -->
                        <div class="col-md-4">
                            <label class="form-label">Marque</label>
                            <input type="text" name="marque" class="form-control @error('marque') is-invalid @enderror" 
                                   value="{{ old('marque') }}" required>
                            @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Modèle -->
                        <div class="col-md-4">
                            <label class="form-label">Modèle</label>
                            <input type="text" name="modele" class="form-control @error('modele') is-invalid @enderror" 
                                   value="{{ old('modele') }}" required>
                            @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Numéro de série -->
                        <div class="col-md-4">
                            <label class="form-label">Numéro de série</label>
                            <input type="text" name="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" 
                                   value="{{ old('numero_serie') }}" required>
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Date d'achat -->
                        <div class="col-md-4">
                            <label class="form-label">Date d'achat</label>
                            <input type="date" name="date_achat" class="form-control datepicker @error('date_achat') is-invalid @enderror" 
                                   value="{{ old('date_achat') }}">
                            @error('date_achat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Fin de garantie -->
                        <div class="col-md-4">
                            <label class="form-label">Fin de garantie</label>
                            <input type="date" name="garantie_fin" class="form-control datepicker @error('garantie_fin') is-invalid @enderror" 
                                   value="{{ old('garantie_fin') }}">
                            @error('garantie_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Localisation -->
                        <div class="col-md-4">
                            <label class="form-label">Localisation</label>
                            <select name="localisation_id" class="form-select select2 @error('localisation_id') is-invalid @enderror">
                                <option value="">Choisir...</option>
                                @foreach($localisations as $localisation)
                                    <option value="{{ $localisation->id }}" {{ old('localisation_id') == $localisation->id ? 'selected' : '' }}>
                                        {{ $localisation->nom_complet }}
                                    </option>
                                @endforeach
                            </select>
                            @error('localisation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Affectation initiale (optionnelle) -->
                        <div class="col-12">
                            <hr>
                            <h6>Affectation initiale (optionnelle)</h6>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Affecter à</label>
                            <select name="utilisateur_affecte_id" class="form-select select2">
                                <option value="">Non affecté</option>
                                @foreach($utilisateurs as $user)
                                    <option value="{{ $user->id }}" {{ old('utilisateur_affecte_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->prenom }} {{ $user->nom }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Date d'affectation</label>
                            <input type="date" name="date_affectation" class="form-control datepicker" value="{{ now()->format('Y-m-d') }}">
                        </div>
                        
                        <!-- Description / Notes -->
                        <div class="col-12">
                            <label class="form-label">Notes / Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Créer l'actif
                            </button>
                            <a href="{{ route('admin.actifs.index') }}" class="btn btn-outline-secondary">
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


