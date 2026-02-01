@extends('layouts.technicien')

@section('title', 'Rapports')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Rapports</h1>
            <p class="text-muted mb-0">Générez et consultez vos rapports d'activité</p>
        </div>
    </div>

    <!-- Report Generation Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-week fa-2x"></i>
                        </div>
                    </div>
                    <h4 class="card-title">Rapport Hebdomadaire</h4>
                    <p class="card-text text-muted">Résumé de vos activités sur la semaine écoulée</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#weeklyReportModal">
                        <i class="fas fa-file-alt me-2"></i> Générer
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                        </div>
                    </div>
                    <h4 class="card-title">Rapport Mensuel</h4>
                    <p class="card-text text-muted">Analyse détaillée de vos performances mensuelles</p>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#monthlyReportModal">
                        <i class="fas fa-chart-bar me-2"></i> Générer
                    </button>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-cogs fa-2x"></i>
                        </div>
                    </div>
                    <h4 class="card-title">Rapport Personnalisé</h4>
                    <p class="card-text text-muted">Créez un rapport selon vos critères spécifiques</p>
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#customReportModal">
                        <i class="fas fa-sliders-h me-2"></i> Personnaliser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Reports -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">Rapports Récents</h3>
            <div class="d-flex align-items-center gap-3">
                <select class="form-select" style="width: 200px;" id="reportTypeFilter">
                    <option value="">Tous les types</option>
                    <option value="weekly">Hebdomadaire</option>
                    <option value="monthly">Mensuel</option>
                    <option value="custom">Personnalisé</option>
                </select>
                <select class="form-select" style="width: 150px;" id="sortReports">
                    <option value="recent">Plus récent</option>
                    <option value="oldest">Plus ancien</option>
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Période</th>
                        <th>Interventions</th>
                        <th>Temps total</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>15/01/2024</strong><br>
                            <small class="text-muted">10:30</small>
                        </td>
                        <td><span class="badge bg-primary">Hebdomadaire</span></td>
                        <td>08/01 - 14/01/2024</td>
                        <td>8 interventions</td>
                        <td>24.5 heures</td>
                        <td><span class="badge bg-success">Généré</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>31/12/2023</strong><br>
                            <small class="text-muted">16:45</small>
                        </td>
                        <td><span class="badge bg-success">Mensuel</span></td>
                        <td>Décembre 2023</td>
                        <td>42 interventions</td>
                        <td>128 heures</td>
                        <td><span class="badge bg-success">Généré</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>20/12/2023</strong><br>
                            <small class="text-muted">14:20</small>
                        </td>
                        <td><span class="badge bg-info">Personnalisé</span></td>
                        <td>01/12 - 20/12/2023</td>
                        <td>28 interventions</td>
                        <td>85 heures</td>
                        <td><span class="badge bg-success">Généré</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>08/12/2023</strong><br>
                            <small class="text-muted">09:15</small>
                        </td>
                        <td><span class="badge bg-primary">Hebdomadaire</span></td>
                        <td>01/12 - 07/12/2023</td>
                        <td>10 interventions</td>
                        <td>32 heures</td>
                        <td><span class="badge bg-warning">En cours</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-secondary" disabled title="En cours">
                                    <i class="fas fa-clock"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>30/11/2023</strong><br>
                            <small class="text-muted">17:30</small>
                        </td>
                        <td><span class="badge bg-success">Mensuel</span></td>
                        <td>Novembre 2023</td>
                        <td>38 interventions</td>
                        <td>115 heures</td>
                        <td><span class="badge bg-success">Généré</span></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Affichage de 1 à 5 sur 18 rapports
            </div>
            <nav>
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    
    <!-- Statistics Section -->
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Statistiques des Rapports</h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-file-alt fa-lg"></i>
                            </div>
                            <h4 class="mb-1">18</h4>
                            <p class="text-muted mb-0">Rapports générés</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-check-circle fa-lg"></i>
                            </div>
                            <h4 class="mb-1">156</h4>
                            <p class="text-muted mb-0">Interventions totales</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock fa-lg"></i>
                            </div>
                            <h4 class="mb-1">485h</h4>
                            <p class="text-muted mb-0">Temps total</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-chart-line fa-lg"></i>
                            </div>
                            <h4 class="mb-1">3.1h</h4>
                            <p class="text-muted mb-0">Moyenne par intervention</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Actions Rapides</h3>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="fas fa-print me-2"></i> Imprimer la liste
                        </button>
                        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exportAllModal">
                            <i class="fas fa-file-export me-2"></i> Exporter tout
                        </button>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteOldModal">
                            <i class="fas fa-trash-alt me-2"></i> Nettoyer l'ancien
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly Report Modal -->
<div class="modal fade" id="weeklyReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rapport Hebdomadaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Semaine du</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('-7 days')) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Format</label>
                        <select class="form-select">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="word">Word</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sections à inclure</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sectionSummary" checked>
                            <label class="form-check-label" for="sectionSummary">Résumé exécutif</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sectionDetails" checked>
                            <label class="form-check-label" for="sectionDetails">Détails des interventions</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sectionTime" checked>
                            <label class="form-check-label" for="sectionTime">Analyse du temps</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sectionStats">
                            <label class="form-check-label" for="sectionStats">Statistiques avancées</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Commentaires additionnels</label>
                        <textarea class="form-control" rows="3" placeholder="Ajoutez vos commentaires..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-cog me-2"></i> Générer le rapport
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Report Modal -->
<div class="modal fade" id="monthlyReportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rapport Mensuel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Mois</label>
                        <select class="form-select">
                            @for($i = 0; $i < 6; $i++)
                                @php
                                    $date = date('Y-m', strtotime("-$i month"));
                                    $display = date('F Y', strtotime("-$i month"));
                                @endphp
                                <option value="{{ $date }}" {{ $i == 0 ? 'selected' : '' }}>{{ $display }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Format</label>
                        <select class="form-select">
                            <option value="pdf">PDF (Détaillé)</option>
                            <option value="excel">Excel (Données brutes)</option>
                            <option value="presentation">Présentation</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Niveau de détail</label>
                        <select class="form-select">
                            <option value="summary">Résumé</option>
                            <option value="standard" selected>Standard</option>
                            <option value="detailed">Détaillé</option>
                            <option value="full">Complet</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Inclure des graphiques</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chartPie" checked>
                            <label class="form-check-label" for="chartPie">Graphique en secteurs (types)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chartBar" checked>
                            <label class="form-check-label" for="chartBar">Graphique en barres (temps)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="chartLine">
                            <label class="form-check-label" for="chartLine">Courbe d'évolution</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success">
                    <i class="fas fa-chart-bar me-2"></i> Générer le rapport
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Report Modal -->
<div class="modal fade" id="customReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rapport Personnalisé</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de début</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de fin</label>
                            <input type="date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Types d'intervention</label>
                        <select class="form-select" multiple>
                            <option value="maintenance" selected>Maintenance</option>
                            <option value="repair" selected>Réparation</option>
                            <option value="installation" selected>Installation</option>
                            <option value="configuration" selected>Configuration</option>
                            <option value="diagnostic" selected>Diagnostic</option>
                        </select>
                        <small class="text-muted">Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs options</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Équipements</label>
                        <select class="form-select" multiple>
                            <option value="all" selected>Tous les équipements</option>
                            <option value="pc">PCs Bureau</option>
                            <option value="laptop">PCs Portables</option>
                            <option value="server">Serveurs</option>
                            <option value="printer">Imprimantes</option>
                            <option value="network">Équipements réseau</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Format de sortie</label>
                        <select class="form-select">
                            <option value="pdf">PDF (Rapport formatté)</option>
                            <option value="excel">Excel (Données tabulaires)</option>
                            <option value="csv">CSV (Importable)</option>
                            <option value="html">HTML (Web)</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Options avancées</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="groupByType">
                            <label class="form-check-label" for="groupByType">Grouper par type d'intervention</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeCharts">
                            <label class="form-check-label" for="includeCharts">Inclure des graphiques</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="includeComments">
                            <label class="form-check-label" for="includeComments">Inclure les commentaires</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="exportAttachments">
                            <label class="form-check-label" for="exportAttachments">Exporter les pièces jointes</label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nom du rapport</label>
                        <input type="text" class="form-control" placeholder="Ex: Rapport_Q1_2024">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-info">
                    <i class="fas fa-cogs me-2"></i> Générer le rapport
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Filter reports by type
    document.getElementById('reportTypeFilter').addEventListener('change', function() {
        const filterValue = this.value;
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const typeCell = row.querySelector('td:nth-child(2)');
            const typeBadge = typeCell.querySelector('.badge');
            const typeClass = typeBadge.classList.contains('bg-primary') ? 'weekly' : 
                             typeBadge.classList.contains('bg-success') ? 'monthly' : 'custom';
            
            if (!filterValue || typeClass === filterValue) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    
    // Sort reports
    document.getElementById('sortReports').addEventListener('change', function() {
        // In a real application, this would sort the table
        // For now, we'll just show an alert
        alert(`Tri par: ${this.value === 'recent' ? 'Plus récent' : 'Plus ancien'}`);
    });
</script>
@endsection