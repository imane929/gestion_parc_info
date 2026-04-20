@extends('layouts.admin-new')

@section('title', 'New Software')
@section('page-title', 'Create Software')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Software Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.logiciels.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                               value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Publisher <span class="text-danger">*</span></label>
                        <input type="text" name="editeur" class="form-control @error('editeur') is-invalid @enderror" 
                               value="{{ old('editeur') }}" required>
                        @error('editeur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Version <span class="text-danger">*</span></label>
                        <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                               value="{{ old('version') }}" required>
                        @error('version')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Select...</option>
                            <option value="os" {{ old('type') == 'os' ? 'selected' : '' }}>Operating System</option>
                            <option value="bureau" {{ old('type') == 'bureau' ? 'selected' : '' }}>Office/Business</option>
                            <option value="serveur" {{ old('type') == 'serveur' ? 'selected' : '' }}>Server</option>
                            <option value="web" {{ old('type') == 'web' ? 'selected' : '' }}>Web</option>
                            <option value="mobile" {{ old('type') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                            <option value="autre" {{ old('type') == 'autre' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.logiciels.index') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Create Software
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


