@extends('layouts.technicien')

@section('title', 'Historique')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Historique des Interventions</h1>
            <p class="text-muted mb-0">Consultez l'historique complet de vos interventions</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary" onclick="window.print()">
                <i class="fas fa-print me-2"></i> Imprimer
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                <i class="fas fa-file-export me-2"></i> Exporter
            </button>
        </div>
    </div>

    <!-- Date Range Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="startDate" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date de fin</label>
                    <input type="date" class="form-control" id="endDate" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type d'intervention</label>
                    <select class="form-select" id="interventionType">
                        <option value="">Tous les types</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="repair">Réparation</option>
                        <option value="installation">Installation</option>
                        <option value="diagnostic">Diagnostic</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select class="form-select" id="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="termine">Terminées</option>
                        <option value="annule">Annulées</option>
                        <option value="en_cours">En cours</option>
                    </select>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" onclick="applyFilters()">
                        <i class="fas fa-filter me-2"></i> Appliquer les filtres
                    </button>
                    <button class="btn btn-outline-secondary" onclick="resetFilters()">
                        <i class="fas fa-redo me-2"></i> Réinitialiser
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-primary mb-2">24</h3>
                    <p class="text-muted mb-0">Interventions (30 jours)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-success mb-2">48.5h</h3>
                    <p class="text-muted mb-0">Temps total passé</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-warning mb-2">2.0h</h3>
                    <p class="text-muted mb-0">Temps moyen par intervention</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <h3 class="text-info mb-2">92%</h3>
                    <p class="text-muted mb-0">Taux de réussite</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Historique détaillé</h3>
            <div class="position-relative" style="width: 300px;">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" class="form-control ps-5" placeholder="Rechercher..." id="searchHistory">
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Intervention</th>
                        <th>Ticket</th>
                        <th>Équipement</th>
                        <th>Type</th>
                        <th>Statut</th>
                        <th>Temps passé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>15/01/2024</strong><br>
                            <small class="text-muted">10:30 - 12:45</small>
                        </td>
                        <td>
                            <strong>Maintenance imprimante</strong><br>
                            <small class="text-muted">Remplacement cartouche toner</small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-001</strong>
                            </a>
                        </td>
                        <td>Imprimante HP LaserJet</td>
                        <td><span class="badge bg-primary">Maintenance</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>2.25h</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>14/01/2024</strong><br>
                            <small class="text-muted">14:00 - 17:00</small>
                        </td>
                        <td>
                            <strong>Réparation PC lent</strong><br>
                            <small class="text-muted">Nettoyage malware et optimisation</small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-002</strong>
                            </a>
                        </td>
                        <td>PC Bureau Dell</td>
                        <td><span class="badge bg-warning">Réparation</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>3.0h</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>13/01/2024</strong><br>
                            <small class="text-muted">09:15 - 10:45</small>
                        </td>
                        <td>
                            <strong>Configuration réseau</strong><br>
                            <small class="text-muted">Configuration port switch</small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-003</strong>
                            </a>
                        </td>
                        <td>Switch Cisco 2960</td>
                        <td><span class="badge bg-info">Configuration</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>1.5h</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>12/01/2024</strong><br>
                            <small class="text-muted">11:00 - 12:00</small>
                        </td>
                        <td>
                            <strong>Installation logiciel</strong><br>
                            <small class="text-muted">Suite Office 365</small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-004</strong>
                            </a>
                        </td>
                        <td>PC Portable Lenovo</td>
                        <td><span class="badge bg-secondary">Installation</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>1.0h</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>10/01/2024</strong><br>
                            <small class="text-muted">08:30 - 09:30</small>
                        </td>
                        <td>
                            <strong>Diagnostic écran noir</strong><br>
                            <small class="text-muted">Carte graphique défectueuse</small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-005</strong>
                            </a>
                        </td>
                        <td>PC Bureau HP</td>
                        <td><span class="badge bg-danger">Diagnostic</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>1.0h</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <strong>08/01/2024</strong><br>
                            <small class="text-muted">13:15 - 15:45</small>
                        </td>
                        <td>
                            <strong>Maintenance serveur</strong><br>
                            <small class="text-muted">Mise à jour système</small>
                        </td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-006</strong>
                            </a>
                        </td>
                        <td>Serveur Dell R740</td>
                        <td><span class="badge bg-primary">Maintenance</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>2.5h</td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Affichage de 1 à 6 sur 24 interventions
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
    
    <!-- Charts Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Répartition par type</h3>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <!-- Chart would go here -->
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-chart-pie fa-3x mb-3"></i>
                            <p>Graphique de répartition</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Évolution mensuelle</h3>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <!-- Chart would go here -->
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-chart-line fa-3x mb-3"></i>
                            <p>Graphique d'évolution</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Exporter l'historique</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Format d'export</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="exportFormat" id="formatPDF" checked>
                            <label class="form-check-label" for="formatPDF">
                                <i class="fas fa-file-pdf text-danger me-1"></i> PDF
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="exportFormat" id="formatExcel">
                            <label class="form-check-label" for="formatExcel">
                                <i class="fas fa-file-excel text-success me-1"></i> Excel
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportFormat" id="formatCSV">
                            <label class="form-check-label" for="formatCSV">
                                <i class="fas fa-file-csv text-info me-1"></i> CSV
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Période</label>
                        <select class="form-select">
                            <option value="30days">30 derniers jours</option>
                            <option value="month">Ce mois</option>
                            <option value="last_month">Mois dernier</option>
                            <option value="year">Cette année</option>
                            <option value="custom">Période personnalisée</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Inclure les colonnes</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="colDate" checked>
                            <label class="form-check-label" for="colDate">Date</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="colDescription" checked>
                            <label class="form-check-label" for="colDescription">Description</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="colEquipment" checked>
                            <label class="form-check-label" for="colEquipment">Équipement</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="colTime" checked>
                            <label class="form-check-label" for="colTime">Temps passé</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="colStatus" checked>
                            <label class="form-check-label" for="colStatus">Statut</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i> Exporter
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function applyFilters() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;
        const interventionType = document.getElementById('interventionType').value;
        const statusFilter = document.getElementById('statusFilter').value;
        
        // In a real application, this would make an AJAX request
        // For now, we'll just show an alert
        alert(`Filtres appliqués:\nDu: ${startDate}\nAu: ${endDate}\nType: ${interventionType || 'Tous'}\nStatut: ${statusFilter || 'Tous'}`);
        
        // Filter table rows (simplified example)
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            // In real implementation, you would filter based on actual data
            // This is just a placeholder
            row.style.display = '';
        });
    }
    
    function resetFilters() {
        document.getElementById('startDate').value = '{{ date("Y-m-d", strtotime("-30 days")) }}';
        document.getElementById('endDate').value = '{{ date("Y-m-d") }}';
        document.getElementById('interventionType').value = '';
        document.getElementById('statusFilter').value = '';
        
        // Show all rows
        const tableRows = document.querySelectorAll('tbody tr');
        tableRows.forEach(row => {
            row.style.display = '';
        });
    }
    
    // Search functionality
    document.getElementById('searchHistory').addEventListener('input', function() {
        const searchText = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchText) ? '' : 'none';
        });
    });
</script>
@endsection