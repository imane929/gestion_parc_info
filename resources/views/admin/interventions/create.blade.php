@extends('layouts.admin-new')

@section('title', 'New Intervention')
@section('page-title', 'Create Intervention')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Intervention Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.interventions.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Ticket -->
                        <div class="col-md-6">
                            <label class="form-label">Ticket <span class="text-danger">*</span></label>
                            <select name="ticket_maintenance_id" class="form-select select2 @error('ticket_maintenance_id') is-invalid @enderror" required>
                                <option value="">Select ticket...</option>
                                @foreach($tickets as $ticket)
                                    <option value="{{ $ticket->id }}" {{ old('ticket_maintenance_id', $ticket->id ?? '') == $ticket->id ? 'selected' : '' }}>
                                        {{ $ticket->numero }} - {{ $ticket->sujet }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ticket_maintenance_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Technician -->
                        <div class="col-md-6">
                            <label class="form-label">Technician <span class="text-danger">*</span></label>
                            <select name="technicien_id" class="form-select select2 @error('technicien_id') is-invalid @enderror" required>
                                <option value="">Select technician...</option>
                                @foreach($techniciens as $technicien)
                                    <option value="{{ $technicien->id }}" {{ old('technicien_id') == $technicien->id ? 'selected' : '' }}>
                                        {{ $technicien->full_name ?? $technicien->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('technicien_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Date -->
                        <div class="col-md-4">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                   value="{{ old('date', now()->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Time Spent -->
                        <div class="col-md-4">
                            <label class="form-label">Time Spent (minutes) <span class="text-danger">*</span></label>
                            <input type="number" name="temps_passe" class="form-control @error('temps_passe') is-invalid @enderror" 
                                   value="{{ old('temps_passe') }}" min="1" required>
                            @error('temps_passe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Work Performed -->
                        <div class="col-12">
                            <label class="form-label">Work Performed <span class="text-danger">*</span></label>
                            <textarea name="travaux" class="form-control @error('travaux') is-invalid @enderror" 
                                      rows="6" required>{{ old('travaux') }}</textarea>
                            @error('travaux')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Attachments -->
                        <div class="col-12">
                            <label class="form-label">Attachments</label>
                            <input type="file" name="pieces_jointes[]" class="form-control" multiple>
                            <small class="text-muted">Max 10MB per file.</small>
                        </div>
                        
                        <!-- Comment -->
                        <div class="col-12">
                            <label class="form-label">Add to Ticket Comment (optional)</label>
                            <textarea name="commentaire" class="form-control" rows="3">{{ old('commentaire') }}</textarea>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Create Intervention
                            </button>
                            <a href="{{ route('admin.interventions.index') }}" class="btn btn-outline-secondary">
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


