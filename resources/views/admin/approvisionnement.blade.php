@extends('layouts.admin')

@section('title', 'Approvisionnement')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Approvisionnement</h1>
            <p class="text-muted mb-0">Gérez les commandes et l'approvisionnement des équipements</p>
        </div>
        <button class="btn btn-primary" onclick="showNewOrderModal()">
            <i class="fas fa-plus me-2"></i>Nouvelle Commande
        </button>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning text-white d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fas fa-clock fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Commandes en attente</h4>
                            <p class="stat-number mb-0" style="font-size: 2rem; font-weight: bold;" id="pendingOrders">7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-success text-white d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Commandes livrées</h4>
                            <p class="stat-number mb-0" style="font-size: 2rem; font-weight: bold;" id="deliveredOrders">23</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fas fa-euro-sign fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Budget restant</h4>
                            <p class="stat-number mb-0" style="font-size: 2rem; font-weight: bold;" id="remainingBudget">15,250 €</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Commandes en Cours</h3>
        </div>
        
        <div class="table-responsive">
            <table class="table" id="ordersTable">
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
                <tbody id="ordersBody">
                    <!-- Orders will be loaded here dynamically -->
                </tbody>
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Fournisseurs</h4>
                    <button class="btn btn-sm btn-primary" onclick="showAddSupplierModal()">
                        <i class="fas fa-plus me-1"></i>Ajouter
                    </button>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush" id="suppliersList">
                        <!-- Suppliers will be loaded here dynamically -->
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <h4 class="mb-0">Demandes d'Approvisionnement</h4>
                </div>
                <div class="card-body">
                    <div id="demandsList">
                        <!-- Demands will be loaded here -->
                    </div>
                    
                    <hr>
                    
                    <h5 class="mb-3">Nouvelle Demande</h5>
                    <form id="newDemandForm" onsubmit="submitDemand(event)">
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="demandDescription" rows="2" placeholder="Décrivez votre besoin..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Priorité</label>
                            <select class="form-select" id="demandPriority" required>
                                <option value="normal">Normale</option>
                                <option value="high">Élevée</option>
                                <option value="urgent">Urgente</option>
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
<div class="modal fade" id="newOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouvelle Commande</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newOrderForm" onsubmit="createOrder(event)">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Fournisseur</label>
                            <select class="form-select" id="orderSupplier" required>
                                <option value="">Sélectionner un fournisseur</option>
                                <!-- Suppliers will be loaded here -->
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type d'équipement</label>
                            <select class="form-select" id="orderEquipmentType" required>
                                <option value="">Sélectionner un type</option>
                                <option value="laptop">Ordinateur portable</option>
                                <option value="desktop">Ordinateur bureau</option>
                                <option value="screen">Écran</option>
                                <option value="printer">Imprimante</option>
                                <option value="network">Réseau</option>
                                <option value="peripheral">Périphérique</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modèle</label>
                            <input type="text" class="form-control" id="orderModel" placeholder="Ex: Dell Latitude 5420" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Quantité</label>
                            <input type="number" class="form-control" id="orderQuantity" min="1" value="1" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prix unitaire (€)</label>
                            <input type="number" class="form-control" id="orderUnitPrice" step="0.01" min="0" placeholder="0.00" required 
                                   oninput="calculateTotal()">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Montant total (€)</label>
                            <input type="number" class="form-control" id="orderTotalAmount" readonly value="0.00">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date de livraison estimée</label>
                            <input type="date" class="form-control" id="orderDeliveryDate" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Numéro de commande</label>
                            <input type="text" class="form-control" id="orderNumber" value="CMD-{{ date('Y') }}-{{ rand(1000, 9999) }}" readonly>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea class="form-control" id="orderNotes" rows="3" placeholder="Notes supplémentaires..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="createOrder()">Créer la commande</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ajouter un Fournisseur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addSupplierForm">
                    <div class="mb-3">
                        <label class="form-label">Nom du fournisseur</label>
                        <input type="text" class="form-control" id="supplierName" placeholder="Ex: Dell Technologies" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="supplierEmail" placeholder="contact@dell.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="supplierPhone" placeholder="+33 1 23 45 67 89">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Adresse</label>
                        <textarea class="form-control" id="supplierAddress" rows="2" placeholder="Adresse complète"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="addSupplier()">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Sample data
    let orders = [
        {
            id: 1,
            number: 'CMD-2026-001',
            supplier: 'Dell Technologies',
            equipment: 'Ordinateurs portables Latitude 5420',
            quantity: 10,
            amount: 15000,
            date: '25/01/2026',
            status: 'pending'
        },
        {
            id: 2,
            number: 'CMD-2026-002',
            supplier: 'HP Inc.',
            equipment: 'Imprimantes LaserJet Pro M404dn',
            quantity: 5,
            amount: 2500,
            date: '28/01/2026',
            status: 'preparing'
        },
        {
            id: 3,
            number: 'CMD-2026-003',
            supplier: 'Lenovo',
            equipment: 'Écrans ThinkVision T24i-20',
            quantity: 8,
            amount: 3200,
            date: '29/01/2026',
            status: 'delivered'
        }
    ];

    let suppliers = [
        {
            id: 1,
            name: 'Dell Technologies',
            email: 'contact@dell.com',
            phone: '+33 1 23 45 67 89',
            status: 'active'
        },
        {
            id: 2,
            name: 'HP Inc.',
            email: 'fournisseur@hp.com',
            phone: '+33 1 98 76 54 32',
            status: 'active'
        },
        {
            id: 3,
            name: 'Cisco Systems',
            email: 'cisco@example.com',
            phone: '+33 1 11 22 33 44',
            status: 'active'
        }
    ];

    let demands = [
        {
            id: 1,
            title: 'Ordinateurs supplémentaires',
            requester: 'Service Informatique',
            description: 'Besoin de 5 ordinateurs supplémentaires pour les nouveaux employés.',
            date: '30/01/2026',
            status: 'pending'
        },
        {
            id: 2,
            title: 'Remplacement écrans',
            requester: 'Service Support',
            description: '3 écrans 24" à remplacer suite à panne.',
            date: '29/01/2026',
            status: 'in_progress'
        }
    ];

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadOrders();
        loadSuppliers();
        loadDemands();
        updateStats();
        setDeliveryDate();
        loadSupplierOptions();
    });

    function loadOrders() {
        const ordersBody = document.getElementById('ordersBody');
        ordersBody.innerHTML = '';
        
        orders.forEach(order => {
            const row = document.createElement('tr');
            
            let statusBadge = '';
            let actions = '';
            
            switch(order.status) {
                case 'pending':
                    statusBadge = '<span class="badge bg-warning">En attente</span>';
                    actions = `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="viewOrder(${order.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success" onclick="markAsDelivered(${order.id})">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="cancelOrder(${order.id})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;
                    break;
                case 'preparing':
                    statusBadge = '<span class="badge bg-info">En préparation</span>';
                    actions = `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="viewOrder(${order.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-success" onclick="markAsDelivered(${order.id})">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    `;
                    break;
                case 'delivered':
                    statusBadge = '<span class="badge bg-success">Livrée</span>';
                    actions = `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="viewOrder(${order.id})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-secondary" onclick="downloadInvoice(${order.id})">
                                <i class="fas fa-file-invoice"></i>
                            </button>
                        </div>
                    `;
                    break;
            }
            
            row.innerHTML = `
                <td><strong>${order.number}</strong></td>
                <td>${order.supplier}</td>
                <td>${order.equipment}</td>
                <td>${order.quantity}</td>
                <td>${order.amount.toLocaleString('fr-FR')} €</td>
                <td>${order.date}</td>
                <td>${statusBadge}</td>
                <td>${actions}</td>
            `;
            
            ordersBody.appendChild(row);
        });
    }

    function loadSuppliers() {
        const suppliersList = document.getElementById('suppliersList');
        suppliersList.innerHTML = '';
        
        suppliers.forEach(supplier => {
            const item = document.createElement('div');
            item.className = 'list-group-item d-flex align-items-center';
            item.innerHTML = `
                <div class="bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center rounded me-3" style="width: 40px; height: 40px;">
                    <i class="fas fa-building"></i>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">${supplier.name}</h6>
                    <small class="text-muted">${supplier.email} | ${supplier.phone}</small>
                </div>
                <span class="badge bg-success">Actif</span>
            `;
            suppliersList.appendChild(item);
        });
    }

    function loadDemands() {
        const demandsList = document.getElementById('demandsList');
        demandsList.innerHTML = '';
        
        demands.forEach(demand => {
            const demandElement = document.createElement('div');
            demandElement.className = 'mb-3';
            
            let statusBadge = demand.status === 'pending' ? 
                '<span class="badge bg-warning">En attente</span>' : 
                '<span class="badge bg-info">En cours</span>';
            
            demandElement.innerHTML = `
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h6 class="mb-1">${demand.title}</h6>
                        <small class="text-muted">Demandé par: ${demand.requester}</small>
                    </div>
                    ${statusBadge}
                </div>
                <p class="text-muted small mb-2">${demand.description}</p>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Date: ${demand.date}</small>
                    <button class="btn btn-sm btn-outline-primary" onclick="processDemand(${demand.id})">
                        ${demand.status === 'pending' ? 'Traiter →' : 'Voir détails →'}
                    </button>
                </div>
            `;
            demandsList.appendChild(demandElement);
        });
    }

    function updateStats() {
        const pendingOrders = orders.filter(order => order.status === 'pending').length;
        const deliveredOrders = orders.filter(order => order.status === 'delivered').length;
        
        document.getElementById('pendingOrders').textContent = pendingOrders;
        document.getElementById('deliveredOrders').textContent = deliveredOrders;
    }

    function showNewOrderModal() {
        const modal = new bootstrap.Modal(document.getElementById('newOrderModal'));
        modal.show();
    }

    function showAddSupplierModal() {
        const modal = new bootstrap.Modal(document.getElementById('addSupplierModal'));
        modal.show();
    }

    function calculateTotal() {
        const quantity = parseInt(document.getElementById('orderQuantity').value) || 0;
        const unitPrice = parseFloat(document.getElementById('orderUnitPrice').value) || 0;
        const total = quantity * unitPrice;
        document.getElementById('orderTotalAmount').value = total.toFixed(2);
    }

    function setDeliveryDate() {
        // Set delivery date to 14 days from now
        const today = new Date();
        const deliveryDate = new Date(today);
        deliveryDate.setDate(today.getDate() + 14);
        
        const formattedDate = deliveryDate.toISOString().split('T')[0];
        document.getElementById('orderDeliveryDate').value = formattedDate;
    }

    function loadSupplierOptions() {
        const select = document.getElementById('orderSupplier');
        select.innerHTML = '<option value="">Sélectionner un fournisseur</option>';
        
        suppliers.forEach(supplier => {
            const option = document.createElement('option');
            option.value = supplier.name;
            option.textContent = supplier.name;
            select.appendChild(option);
        });
    }

    function createOrder() {
        const supplier = document.getElementById('orderSupplier').value;
        const equipmentType = document.getElementById('orderEquipmentType').value;
        const model = document.getElementById('orderModel').value;
        const quantity = parseInt(document.getElementById('orderQuantity').value);
        const unitPrice = parseFloat(document.getElementById('orderUnitPrice').value);
        const orderNumber = document.getElementById('orderNumber').value;
        const deliveryDate = document.getElementById('orderDeliveryDate').value;
        const notes = document.getElementById('orderNotes').value;
        
        if (!supplier || !equipmentType || !model || !quantity || !unitPrice) {
            alert('Veuillez remplir tous les champs obligatoires');
            return;
        }
        
        const newOrder = {
            id: orders.length + 1,
            number: orderNumber,
            supplier: supplier,
            equipment: `${model} (${equipmentType})`,
            quantity: quantity,
            amount: quantity * unitPrice,
            date: new Date().toLocaleDateString('fr-FR'),
            status: 'pending'
        };
        
        orders.unshift(newOrder);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('newOrderModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('newOrderForm').reset();
        setDeliveryDate();
        
        // Update UI
        loadOrders();
        updateStats();
        
        alert('Commande créée avec succès!');
    }

    function addSupplier() {
        const name = document.getElementById('supplierName').value;
        const email = document.getElementById('supplierEmail').value;
        const phone = document.getElementById('supplierPhone').value;
        const address = document.getElementById('supplierAddress').value;
        
        if (!name || !email) {
            alert('Veuillez remplir les champs obligatoires');
            return;
        }
        
        const newSupplier = {
            id: suppliers.length + 1,
            name: name,
            email: email,
            phone: phone,
            address: address,
            status: 'active'
        };
        
        suppliers.push(newSupplier);
        
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('addSupplierModal'));
        modal.hide();
        
        // Reset form
        document.getElementById('addSupplierForm').reset();
        
        // Update UI
        loadSuppliers();
        loadSupplierOptions();
        
        alert('Fournisseur ajouté avec succès!');
    }

    function submitDemand(event) {
        event.preventDefault();
        
        const description = document.getElementById('demandDescription').value;
        const priority = document.getElementById('demandPriority').value;
        
        if (!description) {
            alert('Veuillez décrire votre besoin');
            return;
        }
        
        const newDemand = {
            id: demands.length + 1,
            title: 'Nouvelle demande',
            requester: 'Moi',
            description: description,
            date: new Date().toLocaleDateString('fr-FR'),
            status: 'pending',
            priority: priority
        };
        
        demands.unshift(newDemand);
        
        // Reset form
        document.getElementById('newDemandForm').reset();
        
        // Update UI
        loadDemands();
        
        alert('Demande soumise avec succès!');
    }

    // Order actions
    function viewOrder(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (order) {
            alert(`Détails de la commande:\n\nN°: ${order.number}\nFournisseur: ${order.supplier}\nÉquipement: ${order.equipment}\nQuantité: ${order.quantity}\nMontant: ${order.amount} €\nDate: ${order.date}\nStatut: ${order.status}`);
        }
    }

    function markAsDelivered(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (order && confirm(`Marquer la commande ${order.number} comme livrée?`)) {
            order.status = 'delivered';
            loadOrders();
            updateStats();
            alert('Commande marquée comme livrée!');
        }
    }

    function cancelOrder(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (order && confirm(`Annuler la commande ${order.number}?`)) {
            orders = orders.filter(o => o.id !== orderId);
            loadOrders();
            updateStats();
            alert('Commande annulée!');
        }
    }

    function downloadInvoice(orderId) {
        const order = orders.find(o => o.id === orderId);
        if (order) {
            alert(`Facture pour la commande ${order.number} téléchargée!`);
        }
    }

    function processDemand(demandId) {
        const demand = demands.find(d => d.id === demandId);
        if (demand) {
            if (demand.status === 'pending') {
                if (confirm(`Traiter la demande "${demand.title}"?`)) {
                    demand.status = 'in_progress';
                    loadDemands();
                    alert('Demande mise en traitement!');
                }
            } else {
                alert(`Détails de la demande:\n\nTitre: ${demand.title}\nDemandeur: ${demand.requester}\nDescription: ${demand.description}\nDate: ${demand.date}\nStatut: ${demand.status}`);
            }
        }
    }
</script>
@endsection