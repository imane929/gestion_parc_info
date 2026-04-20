@extends('layouts.admin-new')

@section('title', 'Maintenance Details')
@section('page-title', 'Maintenance Details')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Maintenance Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="mx-auto mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b7cff 0%, #2b4f9e 100%); color: white; font-size: 2rem; display: flex; align-items: center; justify-content: center; border-radius: 20px;">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h4>{{ ucfirst($maintenance->type) }}</h4>
                    @php
                        $statusClass = [
                            'planifie' => 'badge-status active',
                            'en_cours' => 'badge-status warning',
                            'termine' => 'badge-status success',
                            'annule' => 'badge-status danger',
                        ][$maintenance->statut] ?? 'badge-status';
                    @endphp
                    <span class="{{ $statusClass }}">{{ ucfirst($maintenance->statut) }}</span>
                </div>
                
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-desktop me-2 text-primary"></i> Asset</span>
                        <a href="{{ route('admin.actifs.show', $maintenance->actif) }}">
                            {{ $maintenance->actif->code_inventaire }}
                        </a>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-calendar me-2 text-primary"></i> Scheduled Date</span>
                        <span>{{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}</span>
                    </li>
                    @if($maintenance->statut == 'termine')
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span><i class="fas fa-check-circle me-2 text-primary"></i> Completed On</span>
                        <span>{{ $maintenance->updated_at->format('d/m/Y') }}</span>
                    </li>
                    @endif
                </ul>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100">
                    @can('edit maintenances')
                    <a href="{{ route('admin.maintenances.edit', $maintenance) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    @endcan
                    @can('update maintenances')
                    @if($maintenance->statut == 'planifie')
                    <button type="button" class="btn btn-success start-maintenance" data-maintenance-id="{{ $maintenance->id }}">
                        <i class="fas fa-play me-2"></i>
                        Start
                    </button>
                    @endif
                    @if($maintenance->statut == 'en_cours')
                    <button type="button" class="btn btn-success complete-maintenance" data-maintenance-id="{{ $maintenance->id }}">
                        <i class="fas fa-check me-2"></i>
                        Complete
                    </button>
                    @endif
                    @if($maintenance->statut != 'termine' && $maintenance->statut != 'annule')
                    <button type="button" class="btn btn-danger cancel-maintenance" data-maintenance-id="{{ $maintenance->id }}">
                        <i class="fas fa-times me-2"></i>
                        Cancel
                    </button>
                    @endif
                    @endcan
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8 mb-4">
        <!-- Description Card -->
        @if($maintenance->description)
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Description</h6>
            </div>
            <div class="card-body">
                <p>{{ $maintenance->description }}</p>
            </div>
        </div>
        @endif
        
        <!-- Asset Info Card -->
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Asset Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Code:</strong> {{ $maintenance->actif->code_inventaire }}</p>
                        <p><strong>Type:</strong> {{ ucfirst($maintenance->actif->type) }}</p>
                        <p><strong>Brand:</strong> {{ $maintenance->actif->marque }}</p>
                        <p><strong>Model:</strong> {{ $maintenance->actif->modele }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Serial:</strong> {{ $maintenance->actif->numero_serie }}</p>
                        <p><strong>State:</strong> 
                            @php
                                $etatClass = [
                                    'neuf' => 'badge-status success',
                                    'bon' => 'badge-status active',
                                    'moyen' => 'badge-status warning',
                                    'mauvais' => 'badge-status danger',
                                ][$maintenance->actif->etat] ?? 'badge-status';
                            @endphp
                            <span class="{{ $etatClass }}">{{ ucfirst($maintenance->actif->etat) }}</span>
                        </p>
                        <p><strong>Location:</strong> {{ $maintenance->actif->localisation->nom_complet ?? 'Not defined' }}</p>
                        @if($maintenance->actif->utilisateurAffecte)
                        <p><strong>Assigned to:</strong> {{ $maintenance->actif->utilisateurAffecte->full_name }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Notes Card -->
        @if($maintenance->notes)
        <div class="card mt-4">
            <div class="card-header">
                <h6 class="mb-0">Additional Notes</h6>
            </div>
            <div class="card-body">
                <p>{{ $maintenance->notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    const startMaintenanceUrlTemplate = @json(route('admin.maintenances.demarrer', ['maintenance' => '__MAINTENANCE__']));
    const completeMaintenanceUrlTemplate = @json(route('admin.maintenances.terminer', ['maintenance' => '__MAINTENANCE__']));
    const cancelMaintenanceUrlTemplate = @json(route('admin.maintenances.annuler', ['maintenance' => '__MAINTENANCE__']));

    $('.start-maintenance').click(function() {
        const maintenanceId = $(this).data('maintenance-id');
        
        Swal.fire({
            title: 'Start Maintenance?',
            text: "This will mark the maintenance as in progress.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, start it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: startMaintenanceUrlTemplate.replace('__MAINTENANCE__', maintenanceId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred', 'error');
                    }
                });
            }
        });
    });
    
    $('.complete-maintenance').click(function() {
        const maintenanceId = $(this).data('maintenance-id');
        
        Swal.fire({
            title: 'Complete Maintenance?',
            text: "This will mark the maintenance as completed.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, complete it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: completeMaintenanceUrlTemplate.replace('__MAINTENANCE__', maintenanceId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred', 'error');
                    }
                });
            }
        });
    });
    
    $('.cancel-maintenance').click(function() {
        const maintenanceId = $(this).data('maintenance-id');
        
        Swal.fire({
            title: 'Cancel Maintenance?',
            text: "Are you sure you want to cancel this maintenance?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, cancel it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: cancelMaintenanceUrlTemplate.replace('__MAINTENANCE__', maintenanceId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        location.reload();
                    },
                    error: function() {
                        Swal.fire('Error', 'An error occurred', 'error');
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection


