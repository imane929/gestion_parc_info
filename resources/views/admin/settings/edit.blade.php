@extends('layouts.admin-new')

@section('title', 'Edit Parameter')
@section('page-title', 'Edit Parameter')

@section('content')
<div class="row">
    <div class="col-lg-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit: {{ $parametre->cle }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.update', $parametre) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Key</label>
                        <input type="text" class="form-control" value="{{ $parametre->cle }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Group</label>
                        <input type="text" class="form-control" value="{{ $parametre->groupe }}" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Value <span class="text-danger">*</span></label>
                        @if($parametre->type == 'boolean')
                            <select name="valeur" class="form-select @error('valeur') is-invalid @enderror" required>
                                <option value="true" {{ $parametre->valeur == 'true' ? 'selected' : '' }}>Yes</option>
                                <option value="false" {{ $parametre->valeur == 'false' ? 'selected' : '' }}>No</option>
                            </select>
                        @elseif($parametre->type == 'text' || $parametre->type == 'json')
                            <textarea name="valeur" class="form-control @error('valeur') is-invalid @enderror" 
                                      rows="5" required>{{ old('valeur', $parametre->valeur) }}</textarea>
                        @else
                            <input type="{{ $parametre->type == 'integer' ? 'number' : ($parametre->type == 'email' ? 'email' : 'text') }}" 
                                   name="valeur" 
                                   class="form-control @error('valeur') is-invalid @enderror" 
                                   value="{{ old('valeur', $parametre->valeur) }}" 
                                   step="{{ $parametre->type == 'decimal' ? '0.01' : '' }}"
                                   required>
                        @endif
                        @error('valeur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3">{{ old('description', $parametre->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.settings.groupe', $parametre->groupe) }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Parameter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


