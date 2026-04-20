@extends('layouts.admin-new')

@section('title', 'Provider Details')
@section('page-title', $prestataire->nom)

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Provider Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-building"></i>
                    </div>
                    <h4>{{ $prestataire->nom }}</h4>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-phone me-2 text-primary"></i> Phone</span>
                        <span>{{ $prestataire->telephone ?? 'Not provided' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-envelope me-2 text-primary"></i> Email</span>
                        <span>{{ $prestataire->email ?? 'Not provided' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-file-contract me-2 text-primary"></i> Total Contracts</span>
                        <span class="badge bg-primary">{{ $prestataire->contrats->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-check-circle me-2 text-primary"></i> Active Contracts</span>
                        <span class="badge bg-success">{{ $prestataire->contrats_actifs_count }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit prestataires')
                    <a href="{{ route('admin.prestataires.edit', $prestataire) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    @endcan
                    @can('delete prestataires')
                    <form method="POST" action="{{ route('admin.prestataires.destroy', $prestataire) }}" class="d-inline w-50">
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
        
        <!-- Address Card -->
        @if($prestataire->adresse)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Address</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>{{ $prestataire->adresse->rue }}</strong></p>
                @if($prestataire->adresse->quartier)
                <p class="mb-1">{{ $prestataire->adresse->quartier }}</p>
                @endif
                <p class="mb-1">{{ $prestataire->adresse->code_postal }} {{ $prestataire->adresse->ville }}</p>
                <p class="mb-0">{{ $prestataire->adresse->pays }}</p>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-lg-8 mb-4">
        <!-- Contracts Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Contracts</h6>
                @can('create contrats')
                <a href="{{ route('admin.contrats.create', ['prestataire_id' => $prestataire->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>
                    New Contract
                </a>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Contract #</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Days Left</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prestataire->contrats as $contrat)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $contrat->numero }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'actif' => 'badge-status success',
                                            'expire' => 'badge-status danger',
                                            'futur' => 'badge-status active',
                                        ][$contrat->statut] ?? 'badge-status';
                                    @endphp
                                    <span class="{{ $statusClass }}">{{ ucfirst($contrat->statut) }}</span>
                                </td>
                                <td>
                                    @if($contrat->statut == 'actif')
                                        <span class="badge bg-info">{{ $contrat->jours_restants }} days</span>
                                    @elseif($contrat->statut == 'futur')
                                        <span class="badge bg-warning">Starts in {{ $contrat->jours_restants }} days</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.contrats.show', $contrat) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-file-contract fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">No contracts with this provider</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


