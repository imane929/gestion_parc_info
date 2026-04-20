@extends('layouts.admin-new')

@section('title', 'Edit Maintenance')
@section('page-title', 'Edit Maintenance')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Maintenance</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.maintenances.update', $maintenance) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Asset -->
                        <div class="col-md-12">
                            <label class="form-label">Asset <span class="text-danger">*</span></label>
                            <select name="actif_informatique_id" class="form-select select2 @error('actif_informatique_id') is-invalid @enderror" required>
                                <option value="">Select asset...</option>
                                @foreach($actifs as $actif)
                                    <option value="{{ $actif->id }}" {{ old('actif_informatique_id', $maintenance->actif_informatique_id) == $actif->id ? 'selected' : '' }}>
                                        {{ $actif->code_inventaire }} - {{ $actif->marque }} {{ $actif->modele }}
                                    </option>
                                @endforeach
                            </select>
                            @error('actif_informatique_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Scheduled Date -->
                        <div class="col-md-6">
                            <label class="form-label">Scheduled Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_prevue" class="form-control @error('date_prevue') is-invalid @enderror" 
                                   value="{{ old('date_prevue', \Carbon\Carbon::parse($maintenance->date_prevue)->format('Y-m-d')) }}" required>
                            @error('date_prevue')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Type -->
                        <div class="col-md-6">
                            <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select...</option>
                                <option value="nettoyage" {{ old('type', $maintenance->type) == 'nettoyage' ? 'selected' : '' }}>Cleaning</option>
                                <option value="verification" {{ old('type', $maintenance->type) == 'verification' ? 'selected' : '' }}>Verification</option>
                                <option value="mise_a_jour" {{ old('type', $maintenance->type) == 'mise_a_jour' ? 'selected' : '' }}>Update</option>
                                <option value="remplacement" {{ old('type', $maintenance->type) == 'remplacement' ? 'selected' : '' }}>Replacement</option>
                                <option value="autre" {{ old('type', $maintenance->type) == 'autre' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="statut" class="form-select @error('statut') is-invalid @enderror" required>
                                <option value="planifie" {{ old('statut', $maintenance->statut) == 'planifie' ? 'selected' : '' }}>Scheduled</option>
                                <option value="en_cours" {{ old('statut', $maintenance->statut) == 'en_cours' ? 'selected' : '' }}>In Progress</option>
                                <option value="termine" {{ old('statut', $maintenance->statut) == 'termine' ? 'selected' : '' }}>Completed</option>
                                <option value="annule" {{ old('statut', $maintenance->statut) == 'annule' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $maintenance->description ?? '') }}</textarea>
                        </div>
                        
                        <!-- Notes -->
                        <div class="col-12">
                            <label class="form-label">Additional Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $maintenance->notes ?? '') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Maintenance
                            </button>
                            <a href="{{ route('admin.maintenances.show', $maintenance) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


