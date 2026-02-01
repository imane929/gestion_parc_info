@extends('admin.layouts.admin')

@section('title', 'Historique des Activités')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Historique des Activités</h2>
            <p class="text-muted mb-0">Consultez l'historique complet des activités du système</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Rechercher..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-6">
                    <select class="form-select" id="filterType">
                        <option value="">Tous les types</option>
                        <option value="user">Utilisateurs</option>
                        <option value="equipement">Équipements</option>
                        <option value="ticket">Tickets</option>
                        <option value="affectation">Affectations</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Activities Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date & Heure</th>
                            <th>Utilisateur</th>
                            <th>Type</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#ACT001</strong></td>
                            <td>31/01/2026 14:30</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                        A
                                    </div>
                                    <div>
                                        <strong>Administrateur</strong>
                                        <div class="text-muted small">admin@parc.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info">Équipement</span></td>
                            <td>Ajout</td>
                            <td>Ordinateur portable Dell XPS 13 ajouté au parc</td>
                            <td>192.168.1.100</td>
                        </tr>
                        <tr>
                            <td><strong>#ACT002</strong></td>
                            <td>31/01/2026 11:15</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-success text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                        T
                                    </div>
                                    <div>
                                        <strong>Technicien</strong>
                                        <div class="text-muted small">tech@parc.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-warning">Ticket</span></td>
                            <td>Résolution</td>
                            <td>Ticket #T12345 marqué comme résolu</td>
                            <td>192.168.1.101</td>
                        </tr>
                        <tr>
                            <td><strong>#ACT003</strong></td>
                            <td>31/01/2026 09:45</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                        A
                                    </div>
                                    <div>
                                        <strong>Administrateur</strong>
                                        <div class="text-muted small">admin@parc.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-success">Utilisateur</span></td>
                            <td>Création</td>
                            <td>Nouvel utilisateur "Utilisateur Test" créé</td>
                            <td>192.168.1.100</td>
                        </tr>
                        <tr>
                            <td><strong>#ACT004</strong></td>
                            <td>30/01/2026 16:20</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                        A
                                    </div>
                                    <div>
                                        <strong>Administrateur</strong>
                                        <div class="text-muted small">admin@parc.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-info">Affectation</span></td>
                            <td>Modification</td>
                            <td>Affectation #A45678 mise à jour</td>
                            <td>192.168.1.100</td>
                        </tr>
                        <tr>
                            <td><strong>#ACT005</strong></td>
                            <td>30/01/2026 10:00</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-warning text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                                        U
                                    </div>
                                    <div>
                                        <strong>Utilisateur</strong>
                                        <div class="text-muted small">user@parc.com</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-warning">Ticket</span></td>
                            <td>Création</td>
                            <td>Nouveau ticket #T12346 créé</td>
                            <td>192.168.1.102</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Affichage de 1 à 5 sur 128 activités
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-primary btn-sm">1</button>
                    <button class="btn btn-outline-secondary btn-sm">2</button>
                    <button class="btn btn-outline-secondary btn-sm">3</button>
                    <button class="btn btn-outline-secondary btn-sm">4</button>
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-history text-primary fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">12</h5>
                            <small class="text-muted">Activités aujourd'hui</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-week text-success fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">84</h5>
                            <small class="text-muted">Activités cette semaine</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt text-info fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">312</h5>
                            <small class="text-muted">Activités ce mois</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const filterType = document.getElementById('filterType');
        const tableRows = document.querySelectorAll('tbody tr');
        
        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const filterValue = filterType.value;
            
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                let showRow = true;
                
                // Apply search filter
                if (searchText && !rowText.includes(searchText)) {
                    showRow = false;
                }
                
                // Apply type filter
                if (filterValue && filterValue !== '') {
                    const typeCell = row.querySelector('td:nth-child(4)');
                    const typeText = typeCell ? typeCell.textContent.toLowerCase() : '';
                    
                    if (!typeText.includes(filterValue) && filterValue !== 'all') {
                        showRow = false;
                    }
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }
        
        searchInput.addEventListener('input', filterTable);
        filterType.addEventListener('change', filterTable);
    });
</script>
@endsection