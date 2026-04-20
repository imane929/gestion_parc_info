@extends('layouts.admin-new')

@section('title', 'Software Details')
@section('page-title', $logiciel->nom)

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Software Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-cube"></i>
                    </div>
                    <h4>{{ $logiciel->nom }} {{ $logiciel->version }}</h4>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-building me-2 text-primary"></i> Publisher</span>
                        <span>{{ $logiciel->editeur }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-tag me-2 text-primary"></i> Type</span>
                        <span class="badge bg-primary">{{ ucfirst($logiciel->type) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-key me-2 text-primary"></i> Total Licenses</span>
                        <span class="badge bg-info">{{ $logiciel->licences->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-desktop me-2 text-primary"></i> Total Installations</span>
                        <span class="badge bg-success">{{ $logiciel->installations->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-users me-2 text-primary"></i> Available Seats</span>
                        <span class="badge bg-warning">{{ $logiciel->postes_disponibles }}</span>
                    </li>
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit logiciels')
                    <a href="{{ route('admin.logiciels.edit', $logiciel) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    @endcan
                    @can('delete logiciels')
                    <form method="POST" action="{{ route('admin.logiciels.destroy', $logiciel) }}" class="d-inline w-50">
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
        <!-- Licenses Tab -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Licenses</h6>
                @can('manage licenses')
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLicenseModal">
                    <i class="fas fa-plus me-2"></i>
                    Add License
                </button>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>License Key</th>
                                <th>Purchase Date</th>
                                <th>Expiration</th>
                                <th>Seats</th>
                                <th>Used</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logiciel->licences as $licence)
                            <tr>
                                <td><code>{{ $licence->cle_licence }}</code></td>
                                <td>{{ $licence->date_achat->format('d/m/Y') }}</td>
                                <td>{{ $licence->date_expiration->format('d/m/Y') }}</td>
                                <td>{{ $licence->nb_postes }}</td>
                                <td>{{ $licence->installations->count() }}</td>
                                <td>
                                    @if($licence->estValide())
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewLicenseModal{{ $licence->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @can('manage licenses')
                                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editLicenseModal{{ $licence->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.logiciels.delete-licence', $licence) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger delete-confirm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-key fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">No licenses</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Installations Tab -->
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Installations</h6>
                @can('manage installations')
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#installModal">
                    <i class="fas fa-plus me-2"></i>
                    Install on Asset
                </button>
                @endcan
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Asset</th>
                                <th>License</th>
                                <th>Installation Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logiciel->installations as $installation)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.actifs.show', $installation->actif) }}">
                                        {{ $installation->actif->code_inventaire }}
                                    </a>
                                </td>
                                <td><code>{{ $installation->licence->cle_licence }}</code></td>
                                <td>{{ \Carbon\Carbon::parse($installation->date_installation)->format('d/m/Y') }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.logiciels.desinstaller', $installation) }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-confirm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-desktop fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">No installations</p>
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

<!-- Add License Modal -->
<div class="modal fade" id="addLicenseModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.logiciels.add-licence', $logiciel) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add License</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">License Key <span class="text-danger">*</span></label>
                        <input type="text" name="cle_licence" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_achat" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expiration Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_expiration" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Seats <span class="text-danger">*</span></label>
                        <input type="number" name="nb_postes" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add License</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Install Modal -->
<div class="modal fade" id="installModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.logiciels.installer', $logiciel) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Install Software</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">License <span class="text-danger">*</span></label>
                        <select name="licence_id" class="form-select" required>
                            <option value="">Select license...</option>
                            @foreach($licencesDisponibles as $licence)
                                <option value="{{ $licence->id }}">
                                    {{ $licence->cle_licence }} ({{ $licence->postes_disponibles }} seats available)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Asset <span class="text-danger">*</span></label>
                        <select name="actif_id" class="form-select select2" required>
                            <option value="">Select asset...</option>
                            @foreach($actifs as $actif)
                                <option value="{{ $actif->id }}">
                                    {{ $actif->code_inventaire }} - {{ $actif->marque }} {{ $actif->modele }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Installation Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_installation" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Install</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


