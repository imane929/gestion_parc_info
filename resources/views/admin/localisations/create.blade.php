@extends('layouts.admin-new')

@section('title', 'New Location')
@section('page-title', 'Create Location')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Location Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.localisations.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Site <span class="text-danger">*</span></label>
                        <input type="text" name="site" class="form-control @error('site') is-invalid @enderror" 
                               value="{{ old('site') }}" required>
                        @error('site')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">e.g., Headquarters, Paris Branch</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Building</label>
                        <input type="text" name="batiment" class="form-control @error('batiment') is-invalid @enderror" 
                               value="{{ old('batiment') }}">
                        @error('batiment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">e.g., Building A, Tower 1</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Floor</label>
                        <input type="text" name="etage" class="form-control @error('etage') is-invalid @enderror" 
                               value="{{ old('etage') }}">
                        @error('etage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">e.g., 5th floor, Mezzanine</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Office/Room</label>
                        <input type="text" name="bureau" class="form-control @error('bureau') is-invalid @enderror" 
                               value="{{ old('bureau') }}">
                        @error('bureau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">e.g., Room 101, Office 5B</small>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.localisations.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Create Location
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


