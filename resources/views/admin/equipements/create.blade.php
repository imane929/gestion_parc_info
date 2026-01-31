@extends('admin.layouts.admin')

@section('title', 'Ajouter un Équipement')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ajouter un nouvel équipement</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.equipements.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nom" class="form-label">Nom de l'équipement *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="">Sélectionner un type</option>
                                    <option value="PC Portable" {{ old('type') == 'PC Portable' ? 'selected' : '' }}>PC Portable</option>
                                    <option value="PC Bureau" {{ old('type') == 'PC Bureau' ? 'selected' : '' }}>PC Bureau</option>
                                    <option value="Serveur" {{ old('type') == 'Serveur' ? 'selected' : '' }}>Serveur</option>
                                    <option value="Imprimante" {{ old('type') == 'Imprimante' ? 'selected' : '' }}>Imprimante</option>
                                    <option value="Switch" {{ old('type') == 'Switch' ? 'selected' : '' }}>Switch Réseau</option>
                                    <option value="Tablette" {{ old('type') == 'Tablette' ? 'selected' : '' }}>Tablette</option>
                                    <option value="Téléphone" {{ old('type') == 'Téléphone' ? 'selected' : '' }}>Téléphone</option>
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
                                       id="marque" name="marque" value="{{ old('marque') }}">
                                @error('marque')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="modele" class="form-label">Modèle</label>
                                <input type="text" class="form-control @error('modele') is-invalid @enderror" 
                                       id="modele" name="modele" value="{{ old('modele') }}">
                                @error('modele')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="numero_serie" class="form-label">Numéro de série</label>
                                <input type="text" class="form-control @error('numero_serie') is-invalid @enderror" 
                                       id="numero_serie" name="numero_serie" value="{{ old('numero_serie') }}">
                                @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="date_acquisition" class="form-label">Date d'acquisition *</label>
                                <input type="date" class="form-control @error('date_acquisition') is-invalid @enderror" 
                                       id="date_acquisition" name="date_acquisition" value="{{ old('date_acquisition') }}" required>
                                @error('date_acquisition')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="etat" class="form-label">État *</label>
                                <select class="form-control @error('etat') is-invalid @enderror" 
                                        id="etat" name="etat" required>
                                    <option value="neuf" {{ old('etat') == 'neuf' ? 'selected' : '' }}>Neuf</option>
                                    <option value="bon" {{ old('etat') == 'bon' ? 'selected' : '' }} selected>Bon</option>
                                    <option value="moyen" {{ old('etat') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                                    <option value="mauvais" {{ old('etat') == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                                    <option value="hors_service" {{ old('etat') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                                </select>
                                @error('etat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="localisation" class="form-label">Localisation *</label>
                                <input type="text" class="form-control @error('localisation') is-invalid @enderror" 
                                       id="localisation" name="localisation" value="{{ old('localisation') }}" required>
                                @error('localisation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.equipements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Ajouter l'équipement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection