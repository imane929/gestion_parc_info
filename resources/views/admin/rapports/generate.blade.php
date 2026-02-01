@extends('admin.layouts.admin')

@section('title', 'Génération de Rapports')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Génération de Rapports</h2>
            <p class="text-muted mb-0">Générez et téléchargez des rapports détaillés</p>
        </div>
        <a href="{{ route('admin.rapports.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Paramètres du Rapport</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.rapports.generate') }}" method="POST" id="reportForm">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="report_type" class="form-label">Type de Rapport *</label>
                            <select class="form-select" id="report_type" name="report_type" required>
                                <option value="">Sélectionner un type de rapport</option>
                                <option value="inventory">Inventaire des Équipements</option>
                                <option value="maintenance">Maintenance et Tickets</option>
                                <option value="users">Rapport des Utilisateurs</option>
                                <option value="assignments">Affectations d'Équipements</option>
                                <option value="financial">Rapport Financier</option>
                                <option value="performance">Performance des Équipements</option>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Format de Sortie *</label>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="format_pdf" value="pdf" checked>
                                        <label class="form-check-label" for="format_pdf">
                                            <i class="fas fa-file-pdf text-danger me-2"></i>PDF
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="format_excel" value="excel">
                                        <label class="form-check-label" for="format_excel">
                                            <i class="fas fa-file-excel text-success me-2"></i>Excel
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="format_csv" value="csv">
                                        <label class="form-check-label" for="format_csv">
                                            <i class="fas fa-file-csv text-primary me-2"></i>CSV
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="format" id="format_word" value="word">
                                        <label class="form-check-label" for="format_word">
                                            <i class="fas fa-file-word text-info me-2"></i>Word
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="period" class="form-label">Période *</label>
                                <select class="form-select" id="period" name="period" required>
                                    <option value="today">Aujourd'hui</option>
                                    <option value="yesterday">Hier</option>
                                    <option value="this_week" selected>Cette semaine</option>
                                    <option value="last_week">La semaine dernière</option>
                                    <option value="this_month">Ce mois</option>
                                    <option value="last_month">Le mois dernier</option>
                                    <option value="this_quarter">Ce trimestre</option>
                                    <option value="this_year">Cette année</option>
                                    <option value="custom">Période personnalisée</option>
                                    <option value="all">Toutes les données</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="detail_level" class="form-label">Niveau de Détail</label>
                                <select class="form-select" id="detail_level" name="detail_level">
                                    <option value="summary">Résumé</option>
                                    <option value="detailed" selected>Détaillé</option>
                                    <option value="comprehensive">Complet</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Custom Date Range (hidden by default) -->
                        <div class="row mb-4" id="customDateRange" style="display: none;">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Date de début</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d', strtotime('-1 month')) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Date de fin</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                        
                        <!-- Report Specific Options -->
                        <div class="mb-4" id="inventoryOptions">
                            <h6 class="mb-3">Options d'Inventaire</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Type d'Équipement</label>
                                    <select class="form-select" name="equipment_type" multiple>
                                        <option value="all" selected>Tous les types</option>
                                        <option value="PC Portable">PC Portable</option>
                                        <option value="PC Bureau">PC Bureau</option>
                                        <option value="Serveur">Serveur</option>
                                        <option value="Imprimante">Imprimante</option>
                                        <option value="Switch">Switch Réseau</option>
                                        <option value="Tablette">Tablette</option>
                                        <option value="Téléphone">Téléphone</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">État</label>
                                    <select class="form-select" name="equipment_status" multiple>
                                        <option value="all" selected>Tous les états</option>
                                        <option value="neuf">Neuf</option>
                                        <option value="bon">Bon</option>
                                        <option value="moyen">Moyen</option>
                                        <option value="mauvais">Mauvais</option>
                                        <option value="hors_service">Hors service</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4" id="maintenanceOptions" style="display: none;">
                            <h6 class="mb-3">Options de Maintenance</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Statut des Tickets</label>
                                    <select class="form-select" name="ticket_status" multiple>
                                        <option value="all" selected>Tous les statuts</option>
                                        <option value="ouvert">Ouvert</option>
                                        <option value="en_cours">En cours</option>
                                        <option value="termine">Terminé</option>
                                        <option value="annule">Annulé</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Priorité</label>
                                    <select class="form-select" name="ticket_priority" multiple>
                                        <option value="all" selected>Toutes les priorités</option>
                                        <option value="faible">Faible</option>
                                        <option value="moyenne">Moyenne</option>
                                        <option value="haute">Haute</option>
                                        <option value="urgente">Urgente</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4" id="userOptions" style="display: none;">
                            <h6 class="mb-3">Options Utilisateurs</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Rôle</label>
                                    <select class="form-select" name="user_role" multiple>
                                        <option value="all" selected>Tous les rôles</option>
                                        <option value="admin">Administrateur</option>
                                        <option value="technicien">Technicien</option>
                                        <option value="utilisateur">Utilisateur</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Statut</label>
                                    <select class="form-select" name="user_status">
                                        <option value="all" selected>Tous les statuts</option>
                                        <option value="active">Actif</option>
                                        <option value="inactive">Inactif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Inclure les graphiques</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="include_charts" name="include_charts" checked>
                                <label class="form-check-label" for="include_charts">
                                    Ajouter des graphiques au rapport
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="report_name" class="form-label">Nom du Rapport</label>
                            <input type="text" class="form-control" id="report_name" name="report_name" 
                                   value="Rapport_{{ date('Y_m_d') }}" placeholder="Entrez un nom pour le rapport">
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">Notes (optionnel)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Ajoutez des notes ou commentaires pour ce rapport..."></textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" onclick="previewReport()">
                                <i class="fas fa-eye me-2"></i>Aperçu
                            </button>
                            <button type="submit" class="btn btn-primary" id="generateBtn">
                                <i class="fas fa-file-export me-2"></i>Générer le Rapport
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Report Preview -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Aperçu du Rapport</h5>
                </div>
                <div class="card-body">
                    <div id="reportPreview" class="text-center py-4">
                        <i class="fas fa-chart-bar text-muted fa-3x mb-3"></i>
                        <p class="text-muted">Configurez les paramètres pour voir un aperçu</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Stats -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Statistiques Rapides</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="fs-4 fw-bold">{{ $stats['equipments'] ?? 0 }}</div>
                                <small class="text-muted">Équipements</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="fs-4 fw-bold">{{ $stats['users'] ?? 0 }}</div>
                                <small class="text-muted">Utilisateurs</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="fs-4 fw-bold">{{ $stats['open_tickets'] ?? 0 }}</div>
                                <small class="text-muted">Tickets ouverts</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="fs-4 fw-bold">{{ $stats['assignments'] ?? 0 }}</div>
                                <small class="text-muted">Affectations</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Reports -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Rapports Récents</h5>
                </div>
                <div class="card-body">
                    @if(count($recentReports) > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentReports as $report)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $report->name }}</h6>
                                    <small class="text-muted">{{ $report->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-3">Aucun rapport récent</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Aperçu du Rapport</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="previewContent" class="p-4">
                    <!-- Preview content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary" onclick="generateReport()">
                    <i class="fas fa-file-export me-2"></i>Générer le Rapport
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-5">
                <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <h5 class="mb-3">Génération du rapport en cours</h5>
                <p class="text-muted">Veuillez patienter pendant la préparation de votre rapport...</p>
                <div class="progress mt-3">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="progressBar" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .preview-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .preview-header {
        border-bottom: 2px solid #3b82f6;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        background: #f0f9ff;
        border-radius: 0.5rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .chart-placeholder {
        height: 200px;
        background: linear-gradient(45deg, #f8fafc 25%, transparent 25%, transparent 50%, #f8fafc 50%, #f8fafc 75%, transparent 75%, transparent);
        background-size: 20px 20px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6b7280;
        margin: 1rem 0;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide custom date range
        const periodSelect = document.getElementById('period');
        const customDateRange = document.getElementById('customDateRange');
        
        periodSelect.addEventListener('change', function() {
            if (this.value === 'custom') {
                customDateRange.style.display = 'flex';
            } else {
                customDateRange.style.display = 'none';
            }
        });
        
        // Show/hide report specific options
        const reportTypeSelect = document.getElementById('report_type');
        const inventoryOptions = document.getElementById('inventoryOptions');
        const maintenanceOptions = document.getElementById('maintenanceOptions');
        const userOptions = document.getElementById('userOptions');
        
        reportTypeSelect.addEventListener('change', function() {
            // Hide all options first
            inventoryOptions.style.display = 'none';
            maintenanceOptions.style.display = 'none';
            userOptions.style.display = 'none';
            
            // Show relevant options
            switch(this.value) {
                case 'inventory':
                case 'performance':
                    inventoryOptions.style.display = 'block';
                    break;
                case 'maintenance':
                    maintenanceOptions.style.display = 'block';
                    break;
                case 'users':
                    userOptions.style.display = 'block';
                    break;
            }
        });
        
        // Initialize multiple select
        const multipleSelects = document.querySelectorAll('select[multiple]');
        multipleSelects.forEach(select => {
            // Simple multiple select styling
            select.style.height = '150px';
        });
        
        // Form submission
        const reportForm = document.getElementById('reportForm');
        const generateBtn = document.getElementById('generateBtn');
        
        reportForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading modal
            const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
            loadingModal.show();
            
            // Simulate progress
            let progress = 0;
            const progressBar = document.getElementById('progressBar');
            const interval = setInterval(() => {
                progress += 10;
                progressBar.style.width = progress + '%';
                
                if (progress >= 100) {
                    clearInterval(interval);
                    // Submit the form after progress completes
                    setTimeout(() => {
                        reportForm.submit();
                    }, 500);
                }
            }, 200);
        });
        
        // Update report name based on selections
        function updateReportName() {
            const reportType = document.getElementById('report_type').value;
            const period = document.getElementById('period').value;
            const format = document.querySelector('input[name="format"]:checked').value;
            
            if (reportType && period) {
                const typeNames = {
                    'inventory': 'Inventaire',
                    'maintenance': 'Maintenance',
                    'users': 'Utilisateurs',
                    'assignments': 'Affectations',
                    'financial': 'Financier',
                    'performance': 'Performance'
                };
                
                const periodNames = {
                    'today': 'Aujourdhui',
                    'yesterday': 'Hier',
                    'this_week': 'Semaine',
                    'last_week': 'SemaineDerniere',
                    'this_month': 'Mois',
                    'last_month': 'MoisDernier',
                    'this_quarter': 'Trimestre',
                    'this_year': 'Annee',
                    'custom': 'Personnalise',
                    'all': 'Complet'
                };
                
                const formatNames = {
                    'pdf': 'PDF',
                    'excel': 'Excel',
                    'csv': 'CSV',
                    'word': 'Word'
                };
                
                const name = `${typeNames[reportType] || 'Rapport'}_${periodNames[period] || 'Complet'}_${formatNames[format] || 'PDF'}_${new Date().toISOString().slice(0,10).replace(/-/g, '')}`;
                document.getElementById('report_name').value = name;
            }
        }
        
        // Add change listeners for auto-naming
        document.getElementById('report_type').addEventListener('change', updateReportName);
        document.getElementById('period').addEventListener('change', updateReportName);
        document.querySelectorAll('input[name="format"]').forEach(radio => {
            radio.addEventListener('change', updateReportName);
        });
        
        // Initialize report name
        updateReportName();
    });
    
    function previewReport() {
        const reportType = document.getElementById('report_type').value;
        const period = document.getElementById('period').value;
        const format = document.querySelector('input[name="format"]:checked').value;
        const detailLevel = document.getElementById('detail_level').value;
        
        if (!reportType) {
            alert('Veuillez sélectionner un type de rapport.');
            return;
        }
        
        // Generate preview content
        const previewContent = document.getElementById('previewContent');
        let previewHTML = '';
        
        // Report header
        previewHTML += `
            <div class="preview-header">
                <h3>${getReportTypeName(reportType)} - ${getPeriodName(period)}</h3>
                <p class="text-muted">Format: ${getFormatName(format)} | Niveau de détail: ${getDetailLevelName(detailLevel)}</p>
            </div>
        `;
        
        // Report sections based on type
        switch(reportType) {
            case 'inventory':
                previewHTML += getInventoryPreview();
                break;
            case 'maintenance':
                previewHTML += getMaintenancePreview();
                break;
            case 'users':
                previewHTML += getUsersPreview();
                break;
            case 'assignments':
                previewHTML += getAssignmentsPreview();
                break;
            case 'financial':
                previewHTML += getFinancialPreview();
                break;
            case 'performance':
                previewHTML += getPerformancePreview();
                break;
            default:
                previewHTML += '<p class="text-muted">Aperçu non disponible pour ce type de rapport.</p>';
        }
        
        // Charts if enabled
        if (document.getElementById('include_charts').checked) {
            previewHTML += `
                <div class="preview-section">
                    <h4 class="mb-3">Graphiques et Statistiques</h4>
                    <div class="chart-placeholder">
                        <i class="fas fa-chart-pie fa-2x me-2"></i>
                        Graphiques inclus dans le rapport
                    </div>
                </div>
            `;
        }
        
        // Report footer
        previewHTML += `
            <div class="preview-section">
                <h4 class="mb-3">Informations du Rapport</h4>
                <p><strong>Généré le:</strong> ${new Date().toLocaleDateString('fr-FR')}</p>
                <p><strong>Généré par:</strong> {{ auth()->user()->name }}</p>
                <p><strong>Nom du fichier:</strong> ${document.getElementById('report_name').value}.${format}</p>
            </div>
        `;
        
        previewContent.innerHTML = previewHTML;
        
        // Show preview modal
        const previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
        previewModal.show();
    }
    
    function getReportTypeName(type) {
        const names = {
            'inventory': 'Rapport d\'Inventaire',
            'maintenance': 'Rapport de Maintenance',
            'users': 'Rapport des Utilisateurs',
            'assignments': 'Rapport des Affectations',
            'financial': 'Rapport Financier',
            'performance': 'Rapport de Performance'
        };
        return names[type] || 'Rapport';
    }
    
    function getPeriodName(period) {
        const names = {
            'today': 'Aujourd\'hui',
            'yesterday': 'Hier',
            'this_week': 'Cette Semaine',
            'last_week': 'La Semaine Dernière',
            'this_month': 'Ce Mois',
            'last_month': 'Le Mois Dernier',
            'this_quarter': 'Ce Trimestre',
            'this_year': 'Cette Année',
            'custom': 'Période Personnalisée',
            'all': 'Toutes les Données'
        };
        return names[period] || 'Période';
    }
    
    function getFormatName(format) {
        const names = {
            'pdf': 'PDF',
            'excel': 'Excel',
            'csv': 'CSV',
            'word': 'Word'
        };
        return names[format] || format.toUpperCase();
    }
    
    function getDetailLevelName(level) {
        const names = {
            'summary': 'Résumé',
            'detailed': 'Détaillé',
            'comprehensive': 'Complet'
        };
        return names[level] || level;
    }
    
    function getInventoryPreview() {
        return `
            <div class="preview-section">
                <h4 class="mb-3">Résumé de l'Inventaire</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Statistiques Globales</h6>
                        <div class="stat-badge">Total Équipements: 125</div>
                        <div class="stat-badge">En Service: 115</div>
                        <div class="stat-badge">En Maintenance: 8</div>
                        <div class="stat-badge">Hors Service: 2</div>
                    </div>
                    <div class="col-md-6">
                        <h6>Distribution par Type</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-laptop me-2"></i>PC Portables: 45</li>
                            <li><i class="fas fa-desktop me-2"></i>PC Bureau: 35</li>
                            <li><i class="fas fa-server me-2"></i>Serveurs: 5</li>
                            <li><i class="fas fa-print me-2"></i>Imprimantes: 15</li>
                            <li><i class="fas fa-network-wired me-2"></i>Réseau: 25</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="preview-section">
                <h4 class="mb-3">Détail des Équipements</h4>
                <p>Le rapport inclura la liste complète des équipements avec les informations suivantes:</p>
                <ul>
                    <li>ID et Nom de l'équipement</li>
                    <li>Type et Modèle</li>
                    <li>État actuel</li>
                    <li>Localisation</li>
                    <li>Date d'acquisition</li>
                    <li>Valeur estimée</li>
                </ul>
            </div>
        `;
    }
    
    function getMaintenancePreview() {
        return `
            <div class="preview-section">
                <h4 class="mb-3">Résumé des Maintenances</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Statistiques des Tickets</h6>
                        <div class="stat-badge">Tickets Ouverts: 15</div>
                        <div class="stat-badge">Tickets en Cours: 8</div>
                        <div class="stat-badge">Tickets Résolus: 42</div>
                        <div class="stat-badge">Taux de Résolution: 85%</div>
                    </div>
                    <div class="col-md-6">
                        <h6>Temps de Réponse Moyen</h6>
                        <div class="stat-badge">Haute Priorité: 2h</div>
                        <div class="stat-badge">Moyenne Priorité: 8h</div>
                        <div class="stat-badge">Faible Priorité: 24h</div>
                        <div class="stat-badge">Général: 6.5h</div>
                    </div>
                </div>
            </div>
            <div class="preview-section">
                <h4 class="mb-3">Analyse des Maintenances</h4>
                <p>Le rapport inclura:</p>
                <ul>
                    <li>Liste détaillée des tickets</li>
                    <li>Analyse par priorité et statut</li>
                    <li>Performance des techniciens</li>
                    <li>Tendances temporelles</li>
                    <li>Équipements les plus problématiques</li>
                    <li>Coûts de maintenance estimés</li>
                </ul>
            </div>
        `;
    }
    
    function getUsersPreview() {
        return `
            <div class="preview-section">
                <h4 class="mb-3">Résumé des Utilisateurs</h4>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Distribution par Rôle</h6>
                        <div class="stat-badge">Administrateurs: 3</div>
                        <div class="stat-badge">Techniciens: 8</div>
                        <div class="stat-badge">Utilisateurs: 45</div>
                        <div class="stat-badge">Total: 56</div>
                    </div>
                    <div class="col-md-6">
                        <h6>Activité Récente</h6>
                        <div class="stat-badge">Actifs (7j): 48</div>
                        <div class="stat-badge">Inactifs (30j): 8</div>
                        <div class="stat-badge">Nouveaux (mois): 5</div>
                        <div class="stat-badge">Connexions moyennes/jour: 32</div>
                    </div>
                </div>
            </div>
            <div class="preview-section">
                <h4 class="mb-3">Profil des Utilisateurs</h4>
                <p>Le rapport inclura:</p>
                <ul>
                    <li>Liste complète des utilisateurs</li>
                    <li>Informations de profil et de contact</li>
                    <li>Historique des connexions</li>
                    <li>Activités récentes</li>
                    <li>Équipements assignés</li>
                    <li>Tickets créés/résolus</li>
                </ul>
            </div>
        `;
    }
    
    function generateReport() {
        // Close preview modal
        const previewModal = bootstrap.Modal.getInstance(document.getElementById('previewModal'));
        previewModal.hide();
        
        // Trigger form submission
        document.getElementById('reportForm').submit();
    }
</script>
@endsection