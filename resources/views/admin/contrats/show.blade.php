@extends('layouts.admin-new')

@section('title', 'Contract Details')
@section('page-title', 'Contract #{{ $contrat->numero }}')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Contract Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h4>{{ $contrat->numero }}</h4>
                    @php
                        $statusClass = [
                            'actif' => 'badge-status success',
                            'expire' => 'badge-status danger',
                            'futur' => 'badge-status active',
                        ][$contrat->statut] ?? 'badge-status';
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($contrat->statut) }}</span>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-building me-2 text-primary"></i> Provider</span>
                        <a href="{{ route('admin.prestataires.show', $contrat->prestataire) }}">{{ $contrat->prestataire->nom }}</a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-calendar me-2 text-primary"></i> Start Date</span>
                        <span>{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-calendar-times me-2 text-primary"></i> End Date</span>
                        <span>{{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-clock me-2 text-primary"></i> Duration</span>
                        <span>{{ $contrat->duree }} days</span>
                    </li>
                    @if($contrat->montant)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-dollar-sign me-2 text-primary"></i> Amount</span>
                        <span class="fw-bold">${{ number_format($contrat->montant, 2) }}</span>
                    </li>
                    @endif
                    @if($contrat->renouvellement_auto)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-sync-alt me-2 text-primary"></i> Auto-renewal</span>
                        <span class="badge bg-success">Yes</span>
                    </li>
                    @endif
                    @if($contrat->jours_alerte)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-bell me-2 text-primary"></i> Alert Days</span>
                        <span>{{ $contrat->jours_alerte }} days before expiration</span>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit contrats')
                    <a href="{{ route('admin.contrats.edit', $contrat) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    @endcan
                    @can('renew contrats')
                    @if($contrat->statut != 'actif')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#renewModal">
                        <i class="fas fa-sync-alt me-2"></i>
                        Renew
                    </button>
                    @endif
                    @endcan
                    @can('delete contrats')
                    <form method="POST" action="{{ route('admin.contrats.destroy', $contrat) }}" class="d-inline w-50">
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
        <!-- SLA Card -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Service Level Agreement (SLA)</h6>
            </div>
            <div class="card-body">
                @if($contrat->sla)
                    <pre style="white-space: pre-wrap; font-family: inherit;">{{ $contrat->sla }}</pre>
                @else
                    <p class="text-muted text-center py-3">No SLA defined</p>
                @endif
            </div>
        </div>
        
        <!-- Provider Info Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Provider Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $contrat->prestataire->nom }}</p>
                        <p><strong>Phone:</strong> {{ $contrat->prestataire->telephone ?? 'Not provided' }}</p>
                        <p><strong>Email:</strong> {{ $contrat->prestataire->email ?? 'Not provided' }}</p>
                    </div>
                    <div class="col-md-6">
                        @if($contrat->prestataire->adresse)
                            <p><strong>Address:</strong></p>
                            <p>{{ $contrat->prestataire->adresse->adresse_complete }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Notes Card -->
        @if($contrat->description)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Additional Notes</h6>
            </div>
            <div class="card-body">
                <p>{{ $contrat->description }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Renew Modal -->
<div class="modal fade" id="renewModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.contrats.renouveler', $contrat) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Renew Contract</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">New End Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_fin" class="form-control" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Contract Number (optional)</label>
                        <input type="text" name="nouveau_numero" class="form-control" placeholder="Leave blank to auto-generate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adjust Amount (if any)</label>
                        <input type="number" name="ajuster_montant" class="form-control" step="0.01" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Renew Contract</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


