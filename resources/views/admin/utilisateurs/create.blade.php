@extends('layouts.admin-new')

@section('title', 'Créer un utilisateur')
@section('page-title', 'Créer un nouvel utilisateur')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informations de l'utilisateur</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.utilisateurs.store') }}">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Civilité -->
                        <div class="col-md-2">
                            <label class="form-label">Civilité</label>
                            <select name="civilite" class="form-select @error('civilite') is-invalid @enderror">
                                <option value="">--</option>
                                <option value="M" {{ old('civilite') == 'M' ? 'selected' : '' }}>M.</option>
                                <option value="Mme" {{ old('civilite') == 'Mme' ? 'selected' : '' }}>Mme</option>
                                <option value="Mlle" {{ old('civilite') == 'Mlle' ? 'selected' : '' }}>Mlle</option>
                            </select>
                            @error('civilite')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Prénom -->
                        <div class="col-md-5">
                            <label class="form-label">Prénom <span class="text-danger">*</span></label>
                            <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror" 
                                   value="{{ old('prenom') }}" required>
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Nom -->
                        <div class="col-md-6">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                                   value="{{ old('nom') }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Téléphone -->
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone') }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Mot de passe -->
                        <div class="col-md-6">
                            <label class="form-label">Mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="mot_de_passe" class="form-control @error('mot_de_passe') is-invalid @enderror" 
                                   required>
                            @error('mot_de_passe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Confirmer le mot de passe -->
                        <div class="col-md-6">
                            <label class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <input type="password" name="mot_de_passe_confirmation" class="form-control" required>
                        </div>
                        
                        <!-- Statut du compte -->
                        <div class="col-md-6">
                            <label class="form-label">Statut du compte <span class="text-danger">*</span></label>
                            <select name="etat_compte" class="form-select @error('etat_compte') is-invalid @enderror" required>
                                <option value="actif" {{ old('etat_compte') == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ old('etat_compte') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                <option value="suspendu" {{ old('etat_compte') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            </select>
                            @error('etat_compte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Rôles -->
                        <div class="col-md-6">
                            <label class="form-label">Rôles <span class="text-danger">*</span></label>
                            <select name="roles[]" class="form-select select2 @error('roles') is-invalid @enderror" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                                        {{ $role->libelle }}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <hr>
                            <p class="text-muted small">
                                <i class="fas fa-info-circle me-1"></i>
                                Un email sera envoyé à l'utilisateur avec ses identifiants de connexion.
                            </p>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Créer l'utilisateur
                            </button>
                            <a href="{{ route('admin.utilisateurs.index') }}" class="btn btn-outline-secondary">
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


