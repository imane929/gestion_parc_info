@extends('layouts.admin-new')

@section('title', 'Edit Contract')
@section('page-title', 'Edit Contract')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Contract: {{ $contrat->numero }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.contrats.update', $contrat) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Provider -->
                        <div class="col-md-6">
                            <label class="form-label">Provider <span class="text-danger">*</span></label>
                            <select name="prestataire_id" class="form-select select2 @error('prestataire_id') is-invalid @enderror" required>
                                <option value="">Select provider...</option>
                                @foreach($prestataires as $prestataire)
                                    <option value="{{ $prestataire->id }}" {{ old('prestataire_id', $contrat->prestataire_id) == $prestataire->id ? 'selected' : '' }}>
                                        {{ $prestataire->nom }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prestataire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Contract Number -->
                        <div class="col-md-6">
                            <label class="form-label">Contract Number <span class="text-danger">*</span></label>
                            <input type="text" name="numero" class="form-control @error('numero') is-invalid @enderror" 
                                   value="{{ old('numero', $contrat->numero) }}" required>
                            @error('numero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Start Date -->
                        <div class="col-md-6">
                            <label class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" 
                                   value="{{ old('date_debut', \Carbon\Carbon::parse($contrat->date_debut)->format('Y-m-d')) }}" required>
                            @error('date_debut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- End Date -->
                        <div class="col-md-6">
                            <label class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" 
                                   value="{{ old('date_fin', \Carbon\Carbon::parse($contrat->date_fin)->format('Y-m-d')) }}" required>
                            @error('date_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Amount -->
                        <div class="col-md-6">
                            <label class="form-label">Contract Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" name="montant" class="form-control @error('montant') is-invalid @enderror" 
                                       value="{{ old('montant', $contrat->montant) }}" step="0.01" min="0">
                            </div>
                            @error('montant')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Auto Renewal -->
                        <div class="col-md-6">
                            <label class="form-label">&nbsp;</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="renouvellement_auto" value="1" {{ old('renouvellement_auto', $contrat->renouvellement_auto) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    Auto-renewal
                                </label>
                            </div>
                        </div>
                        
                        <!-- Alert Days -->
                        <div class="col-md-6">
                            <label class="form-label">Alert Before Expiration (days)</label>
                            <input type="number" name="jours_alerte" class="form-control @error('jours_alerte') is-invalid @enderror" 
                                   value="{{ old('jours_alerte', $contrat->jours_alerte ?? 30) }}" min="1">
                            @error('jours_alerte')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- SLA -->
                        <div class="col-12">
                            <label class="form-label">SLA (Service Level Agreement)</label>
                            <textarea name="sla" class="form-control @error('sla') is-invalid @enderror" 
                                      rows="5">{{ old('sla', $contrat->sla) }}</textarea>
                            @error('sla')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label">Additional Notes</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $contrat->description ?? '') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Contract
                            </button>
                            <a href="{{ route('admin.contrats.show', $contrat) }}" class="btn btn-outline-secondary">
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


