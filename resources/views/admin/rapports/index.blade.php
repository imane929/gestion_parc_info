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
                    <form action="{{ route('admin.rapports.generate') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">Type de rapport</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Sélectionner un type</option>
                                <option value="equipements">Équipements</option>
                                <option value="utilisateurs">Utilisateurs</option>
                                <option value="tickets">Tickets de maintenance</option>
                                <option value="affectations">Affectations</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-control" id="format" name="format" required>
                                <option value="pdf">PDF</option>
                                <option value="excel">Excel</option>
                                <option value="csv">CSV</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="periode" class="form-label">Période</label>
                            <select class="form-control" id="periode" name="periode" required>
                                <option value="today">Aujourd'hui</option>
                                <option value="week">Cette semaine</option>
                                <option value="month" selected>Ce mois</option>
                                <option value="year">Cette année</option>
                                <option value="all">Tout</option>
                            </select>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
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
                    <p class="text-muted">Aucun rapport généré pour le moment.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection