@extends('admin.layouts.admin')

@section('title', 'Nouvelle Affectation')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Nouvelle Affectation d'Équipement</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.affectations.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="equipement_id" class="form-label">Équipement *</label>
                                <select class="form-control @error('equipement_id') is-invalid @enderror" 
                                        id="equipement_id" name="equipement_id" required>
                                    <option value="">Sélectionner un équipement</option>
                                    @foreach($equipements as $equipement)
                                    <option value="{{ $equipement->id }}" {{ old('equipement_id') == $equipement->id ? 'selected' : '' }}>
                                        {{ $equipement->nom }} ({{ $equipement->type }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('equipement_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="user_id" class="form-label">Utilisateur *</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" 
                                        id="user_id" name="user_id" required>
                                    <option value="">Sélectionner un utilisateur</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_affectation" class="form-label">Date d'affectation *</label>
                                <input type="date" class="form-control @error('date_affectation') is-invalid @enderror" 
                                       id="date_affectation" name="date_affectation" 
                                       value="{{ old('date_affectation', date('Y-m-d')) }}" required>
                                @error('date_affectation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="date_retour" class="form-label">Date de retour prévue (optionnel)</label>
                                <input type="date" class="form-control @error('date_retour') is-invalid @enderror" 
                                       id="date_retour" name="date_retour" value="{{ old('date_retour') }}">
                                @error('date_retour')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="raison" class="form-label">Raison de l'affectation</label>
                            <textarea class="form-control @error('raison') is-invalid @enderror" 
                                      id="raison" name="raison" rows="3">{{ old('raison') }}</textarea>
                            @error('raison')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.affectations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer l'affectation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection