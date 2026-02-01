@extends('layouts.technicien')

@section('title', 'Équipements')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Équipements</h1>
            <p class="text-muted mb-0">Consultez et gérez les équipements informatiques</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter me-2"></i> Filtrer
            </button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scanModal">
                <i class="fas fa-qrcode me-2"></i> Scanner
            </button>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-desktop text-primary fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">42</h5>
                            <small class="text-muted">PCs & Laptops</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-print text-success fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">8</h5>
                            <small class="text-muted">Imprimantes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-server text-warning fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">3</h5>
                            <small class="text-muted">Serveurs</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-network-wired text-info fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">12</h5>
                            <small class="text-muted">Périphériques réseau</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Liste des Équipements</h3>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Rechercher un équipement..." id="searchInput" style="width: 300px;">
                </div>
                <select class="form-select" style="width: 200px;" id="typeFilter">
                    <option value="">Tous les types</option>
                    <option value="pc">PC Bureau</option>
                    <option value="laptop">PC Portable</option>
                    <option value="server">Serveur</option>
                    <option value="printer">Imprimante</option>
                    <option value="network">Réseau</option>
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Marque/Modèle</th>
                        <th>État</th>
                        <th>Localisation</th>
                        <th>Dernière maintenance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>#EQ001</strong></td>
                        <td>
                            <strong>PC Direction</strong><br>
                            <small class="text-muted">SN: DELL-12345</small>
                        </td>
                        <td><span class="badge bg-primary">PC Bureau</span></td>
                        <td>Dell OptiPlex 7090</td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>Bureau 101 - Direction</td>
                        <td>10/01/2024</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-warning" title="Maintenance" data-bs-toggle="modal" data-bs-target="#maintenanceModal">
                                    <i class="fas fa-tools"></i>
                                </button>
                                <button class="btn btn-outline-info" title="Historique">
                                    <i class="fas fa-history"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><strong>#EQ002</strong></td>
                        <td>
                            <strong>Imprimante Réunion</strong><br>
                            <small class="text-muted">SN: HP-67890</small>
                        </td>
                        <td><span class="badge bg-success">Imprimante</span></td>
                        <td>HP LaserJet Pro M404dn</td>
                        <td><span class="badge bg-warning">Maintenance</span></td>
                        <td>Salle Réunion - RDC</td>
                        <td>15/01/2024</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-success" title="Résoudre">
                                    <i class="fas fa-check"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><strong>#EQ003</strong></td>
                        <td>
                            <strong>Serveur Principal</strong><br>
                            <small class="text-muted">SN: DL-34567</small>
                        </td>
                        <td><span class="badge bg-warning">Serveur</span></td>
                        <td>Dell PowerEdge R740</td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>Salle Serveurs - Sous-sol</td>
                        <td>05/01/2024</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-warning" title="Maintenance">
                                    <i class="fas fa-tools"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><strong>#EQ004</strong></td>
                        <td>
                            <strong>Laptop Marketing</strong><br>
                            <small class="text-muted">SN: LEN-78901</small>
                        </td>
                        <td><span class="badge bg-info">PC Portable</span></td>
                        <td>Lenovo ThinkPad X1 Carbon</td>
                        <td><span class="badge bg-danger">Hors service</span></td>
                        <td>Bureau 205 - Marketing</td>
                        <td>12/12/2023</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-danger" title="Remplacer">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td><strong>#EQ005</strong></td>
                        <td>
                            <strong>Switch Étage 2</strong><br>
                            <small class="text-muted">SN: CS-23456</small>
                        </td>
                        <td><span class="badge bg-secondary">Réseau</span></td>
                        <td>Cisco Catalyst 2960</td>
                        <td><span class="badge bg-success">Actif</span></td>
                        <td>Local Technique - Étage 2</td>
                        <td>20/12/2023</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-warning" title="Maintenance">
                                    <i class="fas fa-tools"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Affichage de 1 à 5 sur 65 équipements
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
                    <li class="page-item">
                        <a class="page-link" href="#">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filtrer les équipements</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Type d'équipement</label>
                        <select class="form-select">
                            <option value="">Tous les types</option>
                            <option value="pc">PC Bureau</option>
                            <option value="laptop">PC Portable</option>
                            <option value="server">Serveur</option>
                            <option value="printer">Imprimante</option>
                            <option value="network">Équipement réseau</option>
                            <option value="peripheral">Périphérique</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">État</label>
                        <select class="form-select">
                            <option value="">Tous les états</option>
                            <option value="actif">Actif</option>
                            <option value="maintenance">En maintenance</option>
                            <option value="hors_service">Hors service</option>
                            <option value="reserve">En réserve</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Localisation</label>
                        <select class="form-select">
                            <option value="">Toutes les localisations</option>
                            <option value="direction">Direction</option>
                            <option value="comptabilite">Comptabilité</option>
                            <option value="marketing">Marketing</option>
                            <option value="technique">Local technique</option>
                            <option value="salle_serveurs">Salle serveurs</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Date de dernière maintenance</label>
                        <div class="row g-2">
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Du">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control" placeholder="Au">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Appliquer les filtres</button>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Modal -->
<div class="modal fade" id="maintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle Maintenance</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Équipement</label>
                        <input type="text" class="form-control" value="PC Direction (#EQ001)" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Type de maintenance</label>
                        <select class="form-select" required>
                            <option value="">Sélectionner un type</option>
                            <option value="preventive">Maintenance préventive</option>
                            <option value="corrective">Maintenance corrective</option>
                            <option value="update">Mise à jour</option>
                            <option value="cleaning">Nettoyage</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Décrivez la maintenance à effectuer..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date prévue</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priorité</label>
                            <select class="form-select" required>
                                <option value="faible">Faible</option>
                                <option value="moyenne" selected>Moyenne</option>
                                <option value="haute">Haute</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Planifier la maintenance</button>
            </div>
        </div>
    </div>
</div>

<!-- Scan Modal -->
<div class="modal fade" id="scanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scanner un équipement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-4">
                    <i class="fas fa-qrcode text-primary" style="font-size: 4rem;"></i>
                </div>
                <p class="mb-4">Scannez le QR code de l'équipement pour accéder rapidement à ses informations.</p>
                <div class="border rounded p-4 mb-4" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                    <p class="text-muted mb-0">Zone de scan</p>
                </div>
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Placez le QR code de l'équipement dans le cadre ci-dessus
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Scanner manuellement</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const tableRows = document.querySelectorAll('tbody tr');
        
        function filterTable() {
            const searchText = searchInput.value.toLowerCase();
            const typeValue = typeFilter.value;
            
            tableRows.forEach(row => {
                const rowText = row.textContent.toLowerCase();
                const typeCell = row.querySelector('td:nth-child(3)');
                const typeText = typeCell ? typeCell.textContent.toLowerCase() : '';
                
                let showRow = true;
                
                // Apply search filter
                if (searchText && !rowText.includes(searchText)) {
                    showRow = false;
                }
                
                // Apply type filter
                if (typeValue && typeValue !== '') {
                    if (!typeText.includes(typeValue)) {
                        showRow = false;
                    }
                }
                
                row.style.display = showRow ? '' : 'none';
            });
        }
        
        searchInput.addEventListener('input', filterTable);
        typeFilter.addEventListener('change', filterTable);
    });
</script>
@endsection