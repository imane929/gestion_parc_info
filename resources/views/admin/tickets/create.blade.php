@extends('admin.layouts.admin')

@section('title', 'Nouveau Ticket')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Nouveau Ticket de Maintenance</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tickets.store') }}" method="POST">
                        @csrf
                        
                        <!-- Add hidden field for createur_id -->
                        <input type="hidden" name="createur_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="statut" value="ouvert">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre *</label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" 
                                       id="titre" name="titre" value="{{ old('titre') }}" required>
                                @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
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
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="priorite" class="form-label">Priorité *</label>
                                <select class="form-control @error('priorite') is-invalid @enderror" 
                                        id="priorite" name="priorite" required>
                                    <option value="">Sélectionner une priorité</option>
                                    <option value="faible" {{ old('priorite') == 'faible' ? 'selected' : '' }}>Faible</option>
                                    <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                                    <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                                    <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('priorite')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="technicien_id" class="form-label">Technicien assigné</label>
                                <select class="form-control @error('technicien_id') is-invalid @enderror" 
                                        id="technicien_id" name="technicien_id">
                                    <option value="">Sélectionner un technicien</option>
                                    @foreach($techniciens as $technicien)
                                    <option value="{{ $technicien->id }}" {{ old('technicien_id') == $technicien->id ? 'selected' : '' }}>
                                        {{ $technicien->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('technicien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description du problème *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="solution" class="form-label">Solution proposée (optionnel)</label>
                            <textarea class="form-control @error('solution') is-invalid @enderror" 
                                      id="solution" name="solution" rows="3">{{ old('solution') }}</textarea>
                            @error('solution')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Créer le ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection