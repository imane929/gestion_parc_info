@extends('layouts.admin-new')

@section('title', 'Edit Location')
@section('page-title', 'Edit Location')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Location</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.localisations.update', $localisation) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Site <span class="text-danger">*</span></label>
                        <input type="text" name="site" class="form-control @error('site') is-invalid @enderror" 
                               value="{{ old('site', $localisation->site) }}" required>
                        @error('site')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Building</label>
                        <input type="text" name="batiment" class="form-control @error('batiment') is-invalid @enderror" 
                               value="{{ old('batiment', $localisation->batiment) }}">
                        @error('batiment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Floor</label>
                        <input type="text" name="etage" class="form-control @error('etage') is-invalid @enderror" 
                               value="{{ old('etage', $localisation->etage) }}">
                        @error('etage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Office/Room</label>
                        <input type="text" name="bureau" class="form-control @error('bureau') is-invalid @enderror" 
                               value="{{ old('bureau', $localisation->bureau) }}">
                        @error('bureau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.localisations.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


