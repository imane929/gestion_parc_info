@extends('layouts.admin-new')

@section('title', 'Intervention Details')
@section('page-title', 'Intervention Details')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Intervention Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4>Intervention #{{ $intervention->id }}</h4>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-ticket-alt me-2 text-primary"></i> Ticket</span>
                        <a href="{{ route('admin.tickets.show', $intervention->ticket) }}">{{ $intervention->ticket->numero }}</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-user-cog me-2 text-primary"></i> Technician</span>
                        <span>{{ $intervention->technicien->full_name ?? $intervention->technicien->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-calendar me-2 text-primary"></i> Date</span>
                        <span>{{ \Carbon\Carbon::parse($intervention->date)->format('d/m/Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-clock me-2 text-primary"></i> Time Spent</span>
                        <span class="badge bg-info">{{ $intervention->temps_formate }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit interventions')
                    <a href="{{ route('admin.interventions.edit', $intervention) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    @endcan
                    @can('delete interventions')
                    <form method="POST" action="{{ route('admin.interventions.destroy', $intervention) }}" class="d-inline w-50">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 delete-confirm">
                            <i class="fas fa-trash me-2"></i>
                            Delete
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Work Performed</h6>
            </div>
            <div class="card-body">
                <p>{{ $intervention->travaux }}</p>
            </div>
        </div>
        
        @if($intervention->notes)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Notes</h6>
            </div>
            <div class="card-body">
                <p>{{ $intervention->notes }}</p>
            </div>
        </div>
        @endif
        
        @if($intervention->rapport)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Report Reference</h6>
            </div>
            <div class="card-body">
                <p><code>{{ $intervention->rapport }}</code></p>
            </div>
        </div>
        @endif
        
        @if($intervention->piecesJointes->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Attachments</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($intervention->piecesJointes as $piece)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                @if($piece->estImage())
                                    <img src="{{ Storage::url($piece->chemin) }}" alt="{{ $piece->nom_fichier }}" class="img-fluid mb-2" style="max-height: 100px;">
                                @else
                                    <i class="fas fa-file fa-3x text-muted mb-2"></i>
                                @endif
                                <p class="mb-1 text-truncate">{{ $piece->nom_fichier }}</p>
                                <small class="text-muted">{{ $piece->taille_formatee }}</small>
                                <div class="mt-2">
                                    <a href="{{ Storage::url($piece->chemin) }}" class="btn btn-sm btn-outline-primary" download>
                                        <i class="fas fa-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection


