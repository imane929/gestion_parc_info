@extends('layouts.admin-new')

@section('title', 'Edit Software')
@section('page-title', 'Edit Software')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Software: {{ $logiciel->nom }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.logiciels.update', $logiciel) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" 
                               value="{{ old('nom', $logiciel->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Publisher <span class="text-danger">*</span></label>
                        <input type="text" name="editeur" class="form-control @error('editeur') is-invalid @enderror" 
                               value="{{ old('editeur', $logiciel->editeur) }}" required>
                        @error('editeur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Version <span class="text-danger">*</span></label>
                        <input type="text" name="version" class="form-control @error('version') is-invalid @enderror" 
                               value="{{ old('version', $logiciel->version) }}" required>
                        @error('version')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="">Select...</option>
                            <option value="os" {{ old('type', $logiciel->type) == 'os' ? 'selected' : '' }}>Operating System</option>
                            <option value="bureau" {{ old('type', $logiciel->type) == 'bureau' ? 'selected' : '' }}>Office/Business</option>
                            <option value="serveur" {{ old('type', $logiciel->type) == 'serveur' ? 'selected' : '' }}>Server</option>
                            <option value="web" {{ old('type', $logiciel->type) == 'web' ? 'selected' : '' }}>Web</option>
                            <option value="mobile" {{ old('type', $logiciel->type) == 'mobile' ? 'selected' : '' }}>Mobile</option>
                            <option value="autre" {{ old('type', $logiciel->type) == 'autre' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $logiciel->description ?? '') }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.logiciels.show', $logiciel) }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Software
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


