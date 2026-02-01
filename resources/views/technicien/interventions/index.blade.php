@extends('layouts.technicien')

@section('title', 'Mes Interventions')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Mes Interventions</h1>
            <p class="text-muted mb-0">Suivez et gérez vos interventions en cours</p>
        </div>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newInterventionModal">
            <i class="fas fa-plus me-2"></i> Nouvelle Intervention
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #3b82f6;">
                <i class="fas fa-tools"></i>
            </div>
            <div class="stat-content">
                <h4>En cours</h4>
                <p class="stat-number">5</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #10b981;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h4>Terminées (7 jours)</h4>
                <p class="stat-number">12</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #f59e0b;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h4>Temps moyen</h4>
                <p class="stat-number">2.4h</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon" style="background-color: #8b5cf6;">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="stat-content">
                <h4>À planifier</h4>
                <p class="stat-number">3</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Liste des Interventions</h3>
            <div class="d-flex align-items-center gap-3">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-filter="all">Toutes</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="en_cours">En cours</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="termine">Terminées</button>
                </div>
                <select class="form-select" style="width: 200px;" id="sortSelect">
                    <option value="recent">Plus récentes</option>
                    <option value="oldest">Plus anciennes</option>
                    <option value="priority">Par priorité</option>
                </select>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket</th>
                        <th>Équipement</th>
                        <th>Description</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Date début</th>
                        <th>Temps estimé</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-status="en_cours">
                        <td><strong>#INT-001</strong></td>
                        <td>
                            <a href="{{ route('technicien.tickets.show', 1) }}" class="text-decoration-none">
                                <strong>#TK-2024-001</strong><br>
                                <small class="text-muted">Problème d'impression</small>
                            </a>
                        </td>
                        <td>Imprimante HP LaserJet</td>
                        <td>Cartouche bouchée, remplacement nécessaire</td>
                        <td><span class="badge bg-warning">Haute</span></td>
                        <td><span class="badge bg-warning">En cours</span></td>
                        <td>15/01/2024 10:30</td>
                        <td>2h</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success" title="Terminer">
                                    <i class="fas fa-check"></i>
                                </a>
                                <a href="#" class="btn btn-outline-info" title="Ajouter note">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <tr data-status="termine">
                        <td><strong>#INT-002</strong></td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-002</strong><br>
                                <small class="text-muted">PC lent</small>
                            </a>
                        </td>
                        <td>PC Bureau Dell</td>
                        <td>Nettoyage malware et optimisation</td>
                        <td><span class="badge bg-info">Moyenne</span></td>
                        <td><span class="badge bg-success">Terminée</span></td>
                        <td>14/01/2024 14:00</td>
                        <td>3h</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-outline-secondary" title="Rapport">
                                    <i class="fas fa-file"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <tr data-status="en_cours">
                        <td><strong>#INT-003</strong></td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-003</strong><br>
                                <small class="text-muted">Connexion réseau</small>
                            </a>
                        </td>
                        <td>Switch Cisco 2960</td>
                        <td>Configuration port réseau</td>
                        <td><span class="badge bg-danger">Urgente</span></td>
                        <td><span class="badge bg-warning">En cours</span></td>
                        <td>13/01/2024 09:15</td>
                        <td>1.5h</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-outline-success" title="Terminer">
                                    <i class="fas fa-check"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <tr data-status="planifie">
                        <td><strong>#INT-004</strong></td>
                        <td>
                            <a href="#" class="text-decoration-none">
                                <strong>#TK-2024-004</strong><br>
                                <small class="text-muted">Installation logiciel</small>
                            </a>
                        </td>
                        <td>PC Portable Lenovo</td>
                        <td>Installation suite Office 365</td>
                        <td><span class="badge bg-success">Faible</span></td>
                        <td><span class="badge bg-info">Planifiée</span></td>
                        <td>16/01/2024 11:00</td>
                        <td>1h</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="#" class="btn btn-outline-primary" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <button class="btn btn-outline-warning" title="Démarrer">
                                    <i class="fas fa-play"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted">
                Affichage de 1 à 4 sur 24 interventions
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

<!-- New Intervention Modal -->
<div class="modal fade" id="newInterventionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle Intervention</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ticket concerné</label>
                            <select class="form-select" required>
                                <option value="">Sélectionner un ticket</option>
                                <option value="1">#TK-2024-001 - Problème d'impression</option>
                                <option value="2">#TK-2024-004 - Installation logiciel</option>
                                <option value="3">#TK-2024-005 - Écran noir</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type d'intervention</label>
                            <select class="form-select" required>
                                <option value="maintenance">Maintenance</option>
                                <option value="repair">Réparation</option>
                                <option value="installation">Installation</option>
                                <option value="configuration">Configuration</option>
                                <option value="diagnostic">Diagnostic</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" rows="3" placeholder="Décrivez l'intervention prévue..." required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date prévue</label>
                            <input type="date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Heure prévue</label>
                            <input type="time" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Temps estimé (heures)</label>
                            <input type="number" class="form-control" min="0.5" max="8" step="0.5" value="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priorité</label>
                            <select class="form-select" required>
                                <option value="faible">Faible</option>
                                <option value="moyenne" selected>Moyenne</option>
                                <option value="haute">Haute</option>
                                <option value="urgente">Urgente</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Créer l'intervention</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter interventions by status
        const filterButtons = document.querySelectorAll('[data-filter]');
        const tableRows = document.querySelectorAll('tbody tr');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                
                tableRows.forEach(row => {
                    if (filter === 'all') {
                        row.style.display = '';
                    } else {
                        const rowStatus = row.getAttribute('data-status');
                        row.style.display = rowStatus === filter ? '' : 'none';
                    }
                });
            });
        });
        
        // Sort interventions
        const sortSelect = document.getElementById('sortSelect');
        sortSelect.addEventListener('change', function() {
            // Implement sorting logic here
            console.log('Sort by:', this.value);
        });
    });
</script>
@endsection