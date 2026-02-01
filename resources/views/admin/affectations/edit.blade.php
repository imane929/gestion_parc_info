@extends('layouts.admin')

@section('title', 'Modifier Affectation')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Modifier l'affectation</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.affectations.update', $affectation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="equipement_id" class="form-label">Équipement *</label>
                                <select class="form-control @error('equipement_id') is-invalid @enderror" 
                                        id="equipement_id" name="equipement_id" required>
                                    <option value="">Sélectionner un équipement</option>
                                    @foreach($equipements as $equipement)
                                    <option value="{{ $equipement->id }}" {{ old('equipement_id', $affectation->equipement_id) == $equipement->id ? 'selected' : '' }}>
                                        {{ $equipement->nom }} ({{ $equipement->type }}) - {{ $equipement->localisation }}
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
                                    <option value="{{ $user->id }}" {{ old('user_id', $affectation->user_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ ucfirst($user->role) }})
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
                                       value="{{ \Carbon\Carbon::parse($affectation->date_affectation)->format('Y-m-d') }}" required>
                                @error('date_affectation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="statut" class="form-label">Statut *</label>
                                <select class="form-control @error('statut') is-invalid @enderror" 
                                        id="statut" name="statut" required>
                                    <option value="actif" {{ old('statut', $affectation->statut) == 'actif' ? 'selected' : '' }}>Actif</option>
                                    <option value="retourné" {{ old('statut', $affectation->statut) == 'retourné' ? 'selected' : '' }}>Retourné</option>
                                </select>
                                @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_retour" class="form-label">Date de retour (si retourné)</label>
                                <input type="date" class="form-control @error('date_retour') is-invalid @enderror" 
                                       id="date_retour" name="date_retour" 
                                       value="{{ $affectation->date_retour ? \Carbon\Carbon::parse($affectation->date_retour)->format('Y-m-d') : '' }}">
                                @error('date_retour')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="raison" class="form-label">Raison de l'affectation</label>
                            <textarea class="form-control @error('raison') is-invalid @enderror" 
                                      id="raison" name="raison" rows="3">{{ old('raison', $affectation->raison) }}</textarea>
                            @error('raison')
                            <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.affectations.index') }}" class="btn btn-secondary">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statutSelect = document.getElementById('statut');
        const dateRetourInput = document.getElementById('date_retour');
        
        function toggleDateRetour() {
            if (statutSelect.value === 'retourné') {
                dateRetourInput.required = true;
                // Set default date to today if empty
                if (!dateRetourInput.value) {
                    const today = new Date().toISOString().split('T')[0];
                    dateRetourInput.value = today;
                }
            } else {
                dateRetourInput.required = false;
                if (!dateRetourInput.value) {
                    dateRetourInput.value = '';
                }
            }
        }
        
        statutSelect.addEventListener('change', toggleDateRetour);
        
        // Initialize on page load
        toggleDateRetour();
    });
</script>
@endsection