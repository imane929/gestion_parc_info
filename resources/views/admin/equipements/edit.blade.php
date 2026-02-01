@extends('layouts.admin')

@section('title', 'Modifier Équipement')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Modifier l'équipement : {{ $equipement->nom }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.equipements.update', $equipement) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom de l'équipement *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom', $equipement->nom) }}" required>
                                @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="PC Portable" {{ old('type', $equipement->type) == 'PC Portable' ? 'selected' : '' }}>PC Portable</option>
                                    <option value="PC Bureau" {{ old('type', $equipement->type) == 'PC Bureau' ? 'selected' : '' }}>PC Bureau</option>
                                    <option value="Serveur" {{ old('type', $equipement->type) == 'Serveur' ? 'selected' : '' }}>Serveur</option>
                                    <option value="Imprimante" {{ old('type', $equipement->type) == 'Imprimante' ? 'selected' : '' }}>Imprimante</option>
                                    <option value="Switch" {{ old('type', $equipement->type) == 'Switch' ? 'selected' : '' }}>Switch Réseau</option>
                                    <option value="Tablette" {{ old('type', $equipement->type) == 'Tablette' ? 'selected' : '' }}>Tablette</option>
                                    <option value="Téléphone" {{ old('type', $equipement->type) == 'Téléphone' ? 'selected' : '' }}>Téléphone</option>
                                </select>
                                @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="marque" class="form-label">Marque</label>
                                <input type="text" class="form-control @error('marque') is-invalid @enderror" 
                                       id="marque" name="marque" value="{{ old('marque', $equipement->marque) }}">
                                @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label">Modèle</label>
                                <input type="text" class="form-control @error('modele') is-invalid @enderror" 
                                       id="modele" name="modele" value="{{ old('modele', $equipement->modele) }}">
                                @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="etat" class="form-label">État *</label>
                                <select class="form-control @error('etat') is-invalid @enderror" 
                                        id="etat" name="etat" required>
                                    <option value="neuf" {{ old('etat', $equipement->etat) == 'neuf' ? 'selected' : '' }}>Neuf</option>
                                    <option value="bon" {{ old('etat', $equipement->etat) == 'bon' ? 'selected' : '' }}>Bon</option>
                                    <option value="moyen" {{ old('etat', $equipement->etat) == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                    <option value="mauvais" {{ old('etat', $equipement->etat) == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                                    <option value="hors_service" {{ old('etat', $equipement->etat) == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                                </select>
                                @error('etat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="localisation" class="form-label">Localisation *</label>
                                <input type="text" class="form-control @error('localisation') is-invalid @enderror" 
                                       id="localisation" name="localisation" value="{{ old('localisation', $equipement->localisation) }}" required>
                                @error('localisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes', $equipement->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.equipements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection