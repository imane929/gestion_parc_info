@extends('admin.layouts.admin')

@section('title', 'Génération de Rapports')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Générer un Rapport</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rapports.generate') }}" method="POST" id="reportForm">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">Type de rapport *</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Sélectionner un type</option>
                                <option value="equipements">Équipements</option>
                                <option value="utilisateurs">Utilisateurs</option>
                                <option value="tickets">Tickets de maintenance</option>
                                <option value="affectations">Affectations</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="format" class="form-label">Format *</label>
                            <select class="form-control" id="format" name="format" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="periode" class="form-label">Période *</label>
                            <select class="form-control" id="periode" name="periode" required>
                                <option value="today">Aujourd'hui</option>
                                <option value="week">Cette semaine</option>
                                <option value="month" selected>Ce mois</option>
                                <option value="year">Cette année</option>
                                <option value="custom">Personnalisée</option>
                                <option value="all">Toutes périodes</option>
                            </select>
                        </div>
                        
                        <div id="customDates" class="row mb-4" style="display: none;">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d', strtotime('-1 month')) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary" id="generateBtn">
                                <i class="fas fa-file-export me-2"></i>Générer le rapport
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Report History -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Historique des Rapports</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Format</th>
                                    <th>Période</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">
                                        Aucun rapport généré pour le moment.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const periodeSelect = document.getElementById('periode');
        const customDatesDiv = document.getElementById('customDates');
        
        // Show/hide custom date fields
        periodeSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDatesDiv.style.display = 'block';
                // Set required attributes
                document.getElementById('start_date').required = true;
                document.getElementById('end_date').required = true;
            } else {
                customDatesDiv.style.display = 'none';
                document.getElementById('start_date').required = false;
                document.getElementById('end_date').required = false;
            }
        });
        
        // Form validation
        const form = document.getElementById('reportForm');
        const generateBtn = document.getElementById('generateBtn');
        
        form.addEventListener('submit', function(e) {
            if (periodeSelect.value === 'custom') {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                
                if (!startDate || !endDate) {
                    e.preventDefault();
                    alert('Veuillez sélectionner les dates de début et de fin pour la période personnalisée.');
                    return false;
                }
                
                if (new Date(startDate) > new Date(endDate)) {
                    e.preventDefault();
                    alert('La date de début doit être antérieure à la date de fin.');
                    return false;
                }
            }
            
            // Show loading state
            generateBtn.disabled = true;
            generateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Génération en cours...';
            
            return true;
        });
        
        // Set default dates for custom period
        const today = new Date();
        const lastMonth = new Date();
        lastMonth.setMonth(lastMonth.getMonth() - 1);
        
        document.getElementById('start_date').valueAsDate = lastMonth;
        document.getElementById('end_date').valueAsDate = today;
    });
</script>
@endsection