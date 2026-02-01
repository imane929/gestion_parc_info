@extends('admin.layouts.admin')

@section('title', 'Approvisionnement')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Approvisionnement</h2>
            <p class="text-muted mb-0">Gérez les commandes et l'approvisionnement des équipements</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newOrderModal">
            <i class="fas fa-plus me-2"></i>Nouvelle Commande
        </button>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-warning fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">7</h5>
                            <small class="text-muted">Commandes en attente</small>
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
                            <i class="fas fa-check-circle text-success fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">23</h5>
                            <small class="text-muted">Commandes livrées</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-euro-sign text-primary fs-3"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-0">15,250 €</h5>
                            <small class="text-muted">Budget restant</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>N° Commande</th>
                            <th>Fournisseur</th>
                            <th>Équipement</th>
                            <th>Quantité</th>
                            <th>Montant</th>
                            <th>Date Commande</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>CMD-2026-001</strong></td>
                            <td>Dell Technologies</td>
                            <td>Ordinateurs portables Latitude 5420</td>
                            <td>10</td>
                            <td>15,000 €</td>
                            <td>25/01/2026</td>
                            <td><span class="badge bg-warning">En attente</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="Marquer comme livré">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="btn btn-outline-danger" title="Annuler">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>CMD-2026-002</strong></td>
                            <td>HP Inc.</td>
                            <td>Imprimantes LaserJet Pro M404dn</td>
                            <td>5</td>
                            <td>2,500 €</td>
                            <td>28/01/2026</td>
                            <td><span class="badge bg-info">En préparation</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success" title="Marquer comme livré">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>CMD-2026-003</strong></td>
                            <td>Lenovo</td>
                            <td>Écrans ThinkVision T24i-20</td>
                            <td>8</td>
                            <td>3,200 €</td>
                            <td>29/01/2026</td>
                            <td><span class="badge bg-success">Livrée</span></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-primary" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary" title="Télécharger facture">
                                        <i class="fas fa-file-invoice"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Suppliers and Requests -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Fournisseurs</h5>
                    <button class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Ajouter
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-building"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Dell Technologies</h6>
                                <small class="text-muted">contact@dell.com | +33 1 23 45 67 89</small>
                            </div>
                            <span class="badge bg-success">Actif</span>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center rounded me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-laptop"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">HP Inc.</h6>
                                <small class="text-muted">fournisseur@hp.com | +33 1 98 76 54 32</small>
                            </div>
                            <span class="badge bg-success">Actif</span>
                        </div>
                        <div class="list-group-item d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center rounded me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Cisco Systems</h6>
                                <small class="text-muted">cisco@example.com | +33 1 11 22 33 44</small>
                            </div>
                            <span class="badge bg-success">Actif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Demandes d'Approvisionnement</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">Ordinateurs supplémentaires</h6>
                                <small class="text-muted">Demandé par: Service Informatique</small>
                            </div>
                            <span class="badge bg-warning">En attente</span>
                        </div>
                        <p class="text-muted small mb-2">Besoin de 5 ordinateurs supplémentaires pour les nouveaux employés.</p>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Date: 30/01/2026</small>
                            <button class="btn btn-sm btn-outline-primary">Traiter →</button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">Remplacement écrans</h6>
                                <small class="text-muted">Demandé par: Service Support</small>
                            </div>
                            <span class="badge bg-info">En cours</span>
                        </div>
                        <p class="text-muted small mb-2">3 écrans 24" à remplacer suite à panne.</p>
                        <div class="d-flex justify-content-between">
                            <small class="text-muted">Date: 29/01/2026</small>
                            <button class="btn btn-sm btn-outline-primary">Voir détails →</button>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <h5 class="mb-3">Nouvelle Demande</h5>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="2" placeholder="Décrivez votre besoin..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priorité</label>
                            <select class="form-select">
                                <option>Normale</option>
                                <option>Élevée</option>
                                <option>Urgente</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-paper-plane me-2"></i>Soumettre la Demande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Order Modal -->
<div class="modal fade" id="newOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle Commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fournisseur</label>
                            <select class="form-select">
                                <option>Sélectionner un fournisseur</option>
                                <option>Dell Technologies</option>
                                <option>HP Inc.</option>
                                <option>Lenovo</option>
                                <option>Cisco Systems</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type d'équipement</label>
                            <select class="form-select">
                                <option>Ordinateur portable</option>
                                <option>Ordinateur bureau</option>
                                <option>Écran</option>
                                <option>Imprimante</option>
                                <option>Réseau</option>
                                <option>Périphérique</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modèle</label>
                            <input type="text" class="form-control" placeholder="Ex: Dell Latitude 5420">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantité</label>
                            <input type="number" class="form-control" min="1" value="1">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prix unitaire (€)</label>
                            <input type="number" class="form-control" step="0.01" placeholder="0.00">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de livraison estimée</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" rows="3" placeholder="Notes supplémentaires..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary">Créer la commande</button>
            </div>
        </div>
    </div>
</div>
@endsection