@extends('layouts.admin-new')

@section('title', 'Location Details')
@section('page-title', 'Location Details')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Location Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>{{ $localisation->nom_complet }}</h4>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-building me-2 text-primary"></i> Site</span>
                        <span class="fw-semibold">{{ $localisation->site }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-building me-2 text-primary"></i> Building</span>
                        <span>{{ $localisation->batiment ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-layer-group me-2 text-primary"></i> Floor</span>
                        <span>{{ $localisation->etage ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-door-open me-2 text-primary"></i> Office</span>
                        <span>{{ $localisation->bureau ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-desktop me-2 text-primary"></i> Total Assets</span>
                        <span class="badge bg-primary">{{ $localisation->actifs->count() }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit localisations')
                    <a href="{{ route('admin.localisations.edit', $localisation) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    @endcan
                    @can('delete localisations')
                    <form method="POST" action="{{ route('admin.localisations.destroy', $localisation) }}" class="d-inline w-50">
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
                <h6 class="mb-0">Assets in this Location</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Brand/Model</th>
                                <th>State</th>
                                <th>Assigned To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($localisation->actifs as $actif)
                            <tr>
                                <td>
                                    <span class="fw-semibold">{{ $actif->code_inventaire }}</span>
                                </td>
                                <td>
                                    @php
                                        $typeIcon = [
                                            'pc' => 'fa-desktop',
                                            'serveur' => 'fa-server',
                                            'imprimante' => 'fa-print',
                                            'reseau' => 'fa-network-wired',
                                        ][$actif->type] ?? 'fa-desktop';
                                    @endphp
                                    <i class="fas {{ $typeIcon }} me-2 text-primary"></i>
                                    {{ ucfirst($actif->type) }}
                                </td>
                                <td>
                                    <strong>{{ $actif->marque }}</strong>
                                    <small class="text-muted d-block">{{ $actif->modele }}</small>
                                </td>
                                <td>
                                    @php
                                        $etatClass = [
                                            'neuf' => 'badge-status success',
                                            'bon' => 'badge-status active',
                                            'moyen' => 'badge-status warning',
                                            'mauvais' => 'badge-status danger',
                                        ][$actif->etat] ?? 'badge-status';
                                    @endphp
                                    <span class="{{ $etatClass }}">{{ ucfirst($actif->etat) }}</span>
                                </td>
                                <td>
                                    @if($actif->utilisateurAffecte)
                                        {{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.actifs.show', $actif) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-desktop fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">No assets in this location</p>
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


