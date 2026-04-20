@extends('layouts.admin-new')

@section('title', 'New License')
@section('page-title', 'Create License')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">License Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.licences.store') }}">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Software -->
                        <div class="col-md-12">
                            <label class="form-label">Software <span class="text-danger">*</span></label>
                            <select name="logiciel_id" class="form-select select2 @error('logiciel_id') is-invalid @enderror" required>
                                <option value="">Select software...</option>
                                @foreach(\App\Models\Logiciel::all() as $logiciel)
                                    <option value="{{ $logiciel->id }}" {{ old('logiciel_id') == $logiciel->id ? 'selected' : '' }}>
                                        {{ $logiciel->nom }} ({{ $logiciel->editeur }})
                                    </option>
                                @endforeach
                            </select>
                            @error('logiciel_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- License Key -->
                        <div class="col-md-12">
                            <label class="form-label">License Key <span class="text-danger">*</span></label>
                            <input type="text" name="cle_licence" class="form-control @error('cle_licence') is-invalid @enderror" 
                                   value="{{ old('cle_licence') }}" required>
                            @error('cle_licence')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Purchase Date -->
                        <div class="col-md-6">
                            <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_achat" class="form-control @error('date_achat') is-invalid @enderror" 
                                   value="{{ old('date_achat', now()->format('Y-m-d')) }}" required>
                            @error('date_achat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Expiration Date -->
                        <div class="col-md-6">
                            <label class="form-label">Expiration Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_expiration" class="form-control @error('date_expiration') is-invalid @enderror" 
                                   value="{{ old('date_expiration') }}" required>
                            @error('date_expiration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Number of Seats -->
                        <div class="col-md-6">
                            <label class="form-label">Number of Seats <span class="text-danger">*</span></label>
                            <input type="number" name="nb_postes" class="form-control @error('nb_postes') is-invalid @enderror" 
                                   value="{{ old('nb_postes', 1) }}" min="1" required>
                            @error('nb_postes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Notes -->
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="4">{{ old('notes') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Create License
                            </button>
                            <a href="{{ route('admin.licences.index') }}" class="btn btn-outline-secondary">
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


