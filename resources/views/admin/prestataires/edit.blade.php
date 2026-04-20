@extends('layouts.admin-new')

@section('title', 'Edit Provider')
@section('page-title', 'Edit Provider')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Provider: {{ $prestataire->nom }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.prestataires.update', $prestataire) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-12">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                                   value="{{ old('nom', $prestataire->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="telephone" class="form-control @error('telephone') is-invalid @enderror" 
                                   value="{{ old('telephone', $prestataire->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ old('email', $prestataire->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <hr>
                            <h6>Address Information</h6>
                        </div>
                        
                        @if($prestataire->adresse)
                            <!-- Country -->
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <input type="text" name="pays" class="form-control @error('pays') is-invalid @enderror" 
                                       value="{{ old('pays', $prestataire->adresse->pays) }}">
                                @error('pays')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" 
                                       value="{{ old('ville', $prestataire->adresse->ville) }}">
                                @error('ville')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Postal Code -->
                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="code_postal" class="form-control @error('code_postal') is-invalid @enderror" 
                                       value="{{ old('code_postal', $prestataire->adresse->code_postal) }}">
                                @error('code_postal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Street -->
                            <div class="col-md-6">
                                <label class="form-label">Street</label>
                                <input type="text" name="rue" class="form-control @error('rue') is-invalid @enderror" 
                                       value="{{ old('rue', $prestataire->adresse->rue) }}">
                                @error('rue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Neighborhood -->
                            <div class="col-md-6">
                                <label class="form-label">Neighborhood</label>
                                <input type="text" name="quartier" class="form-control @error('quartier') is-invalid @enderror" 
                                       value="{{ old('quartier', $prestataire->adresse->quartier) }}">
                                @error('quartier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            <div class="col-12">
                                <p class="text-muted">No address on file. Add address information below:</p>
                            </div>
                            
                            <!-- Country -->
                            <div class="col-md-4">
                                <label class="form-label">Country</label>
                                <input type="text" name="pays" class="form-control @error('pays') is-invalid @enderror" 
                                       value="{{ old('pays', 'France') }}">
                                @error('pays')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- City -->
                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" 
                                       value="{{ old('ville') }}">
                                @error('ville')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Postal Code -->
                            <div class="col-md-4">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="code_postal" class="form-control @error('code_postal') is-invalid @enderror" 
                                       value="{{ old('code_postal') }}">
                                @error('code_postal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Street -->
                            <div class="col-md-6">
                                <label class="form-label">Street</label>
                                <input type="text" name="rue" class="form-control @error('rue') is-invalid @enderror" 
                                       value="{{ old('rue') }}">
                                @error('rue')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Neighborhood -->
                            <div class="col-md-6">
                                <label class="form-label">Neighborhood</label>
                                <input type="text" name="quartier" class="form-control @error('quartier') is-invalid @enderror" 
                                       value="{{ old('quartier') }}">
                                @error('quartier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Provider
                            </button>
                            <a href="{{ route('admin.prestataires.show', $prestataire) }}" class="btn btn-outline-secondary">
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


