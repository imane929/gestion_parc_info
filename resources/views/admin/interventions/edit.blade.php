@extends('layouts.admin-new')

@section('title', 'Edit Intervention')
@section('page-title', 'Edit Intervention')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Intervention #{{ $intervention->id }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.interventions.update', $intervention) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Ticket -->
                        <div class="col-md-6">
                            <label class="form-label">Ticket <span class="text-danger">*</span></label>
                            <select name="ticket_maintenance_id" class="form-select select2 @error('ticket_maintenance_id') is-invalid @enderror" required>
                                <option value="">Select ticket...</option>
                                @foreach($tickets as $ticket)
                                    <option value="{{ $ticket->id }}" {{ old('ticket_maintenance_id', $intervention->ticket_maintenance_id) == $ticket->id ? 'selected' : '' }}>
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
                                    <option value="{{ $technicien->id }}" {{ old('technicien_id', $intervention->technicien_id) == $technicien->id ? 'selected' : '' }}>
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
                                   value="{{ old('date', \Carbon\Carbon::parse($intervention->date)->format('Y-m-d')) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Time Spent -->
                        <div class="col-md-4">
                            <label class="form-label">Time Spent (minutes) <span class="text-danger">*</span></label>
                            <input type="number" name="temps_passe" class="form-control @error('temps_passe') is-invalid @enderror" 
                                   value="{{ old('temps_passe', $intervention->temps_passe) }}" min="1" required>
                            @error('temps_passe')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Work Performed -->
                        <div class="col-12">
                            <label class="form-label">Work Performed <span class="text-danger">*</span></label>
                            <textarea name="travaux" class="form-control @error('travaux') is-invalid @enderror" 
                                      rows="6" required>{{ old('travaux', $intervention->travaux) }}</textarea>
                            @error('travaux')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Existing Attachments -->
                        @if($intervention->piecesJointes->count() > 0)
                        <div class="col-12">
                            <label class="form-label">Existing Attachments</label>
                            <div class="row">
                                @foreach($intervention->piecesJointes as $piece)
                                <div class="col-md-3 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center p-2">
                                            @if($piece->estImage())
                                                <img src="{{ Storage::url($piece->chemin) }}" alt="{{ $piece->nom_fichier }}" class="img-fluid mb-2" style="max-height: 60px;">
                                            @else
                                                <i class="fas fa-file fa-2x text-muted mb-2"></i>
                                            @endif
                                            <p class="small text-truncate mb-1">{{ $piece->nom_fichier }}</p>
                                            <form method="POST" action="{{ route('pieces-jointes.destroy', $piece) }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <!-- New Attachments -->
                        <div class="col-12">
                            <label class="form-label">Add New Attachments</label>
                            <input type="file" name="pieces_jointes[]" class="form-control" multiple>
                            <small class="text-muted">Max 10MB per file.</small>
                        </div>
                        
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Update Intervention
                            </button>
                            <a href="{{ route('admin.interventions.show', $intervention) }}" class="btn btn-outline-secondary">
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


