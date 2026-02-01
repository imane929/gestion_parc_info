@extends('layouts.admin')

@section('title', 'Historique')

@section('content')
<div class="content-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h2 mb-1">Historique des Activités</h1>
            <p class="text-muted mb-0">Consultez l'historique complet des activités du système</p>
        </div>
        <div class="btn-group">
            <button class="btn btn-outline-danger" onclick="deleteAllHistory()">
                <i class="fas fa-trash me-2"></i>Effacer tout
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title mb-0">Liste des Activités</h3>
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Rechercher..." id="searchInput" style="width: 250px;">
                </div>
                <select class="form-select" id="filterType" style="width: 200px;">
                    <option value="">Tous les types</option>
                    <option value="user">Utilisateurs</option>
                    <option value="equipement">Équipements</option>
                    <option value="ticket">Tickets</option>
                    <option value="affectation">Affectations</option>
                </select>
                <button class="btn btn-outline-secondary" onclick="refreshHistory()">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date & Heure</th>
                        <th>Utilisateur</th>
                        <th>Type</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>IP</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="historyBody">
                    <!-- History will be loaded dynamically -->
                </tbody>
            </table>
        </div>
        
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-muted" id="historyCount">
                Chargement...
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm" onclick="prevPage()" id="prevBtn" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span class="px-3 py-1" id="pageInfo">Page 1</span>
                <button class="btn btn-outline-secondary btn-sm" onclick="nextPage()" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fas fa-history fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Activitités aujourd'hui</h4>
                            <p class="stat-number mb-0" style="font-size: 2rem; font-weight: bold;" id="todayCount">0</p>
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
                            <i class="fas fa-calendar-week fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Activitités cette semaine</h4>
                            <p class="stat-number mb-0" style="font-size: 2rem; font-weight: bold;" id="weekCount">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-info text-white d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                            <i class="fas fa-calendar-alt fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Activitités ce mois</h4>
                            <p class="stat-number mb-0" style="font-size: 2rem; font-weight: bold;" id="monthCount">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Sample history data
    let allHistory = [
        {
            id: 1,
            date: new Date().toLocaleString('fr-FR'),
            user: { name: 'Administrateur', email: 'admin@parc.com', role: 'admin' },
            type: 'equipement',
            action: 'Ajout',
            description: 'Ordinateur portable Dell XPS 13 ajouté au parc',
            ip: '192.168.1.100'
        },
        {
            id: 2,
            date: new Date(Date.now() - 3600000).toLocaleString('fr-FR'), // 1 hour ago
            user: { name: 'Technicien', email: 'tech@parc.com', role: 'technicien' },
            type: 'ticket',
            action: 'Résolution',
            description: 'Ticket #T12345 marqué comme résolu',
            ip: '192.168.1.101'
        },
        {
            id: 3,
            date: new Date(Date.now() - 7200000).toLocaleString('fr-FR'), // 2 hours ago
            user: { name: 'Administrateur', email: 'admin@parc.com', role: 'admin' },
            type: 'user',
            action: 'Création',
            description: 'Nouvel utilisateur "Utilisateur Test" créé',
            ip: '192.168.1.100'
        }
    ];

    // Load real activities from localStorage
    function loadHistoryFromStorage() {
        const storedHistory = localStorage.getItem('system_history');
        if (storedHistory) {
            try {
                const parsed = JSON.parse(storedHistory);
                if (Array.isArray(parsed)) {
                    // Merge with sample data, avoiding duplicates
                    parsed.forEach(activity => {
                        if (!allHistory.some(a => a.id === activity.id)) {
                            allHistory.push(activity);
                        }
                    });
                }
            } catch (e) {
                console.error('Error loading history from storage:', e);
            }
        }
    }

    // Save activity to localStorage
    function saveActivity(activity) {
        allHistory.unshift(activity); // Add to beginning
        localStorage.setItem('system_history', JSON.stringify(allHistory));
        loadHistory();
    }

    // Generate activity types based on user actions
    function generateActivity(type, action, description) {
        const user = {
            name: "{{ auth()->user()->name }}",
            email: "{{ auth()->user()->email }}",
            role: "{{ auth()->user()->role }}"
        };

        return {
            id: Date.now(), // Unique ID based on timestamp
            date: new Date().toLocaleString('fr-FR'),
            user: user,
            type: type,
            action: action,
            description: description,
            ip: '{{ request()->ip() }}' // Get real IP from Laravel
        };
    }

    // Pagination variables
    let currentPage = 1;
    const itemsPerPage = 10;
    let filteredHistory = [];

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadHistoryFromStorage();
        loadHistory();
        setupEventListeners();
        updateStats();
        
        // Listen for activity events (for real-time updates)
        window.addEventListener('activity', function(event) {
            if (event.detail) {
                saveActivity(event.detail);
            }
        });
    });

    function loadHistory() {
        // Apply filters
        const searchText = document.getElementById('searchInput').value.toLowerCase();
        const filterType = document.getElementById('filterType').value;
        
        filteredHistory = allHistory.filter(activity => {
            // Search filter
            if (searchText) {
                const searchable = [
                    activity.user.name,
                    activity.user.email,
                    activity.type,
                    activity.action,
                    activity.description,
                    activity.ip
                ].join(' ').toLowerCase();
                
                if (!searchable.includes(searchText)) {
                    return false;
                }
            }
            
            // Type filter
            if (filterType && activity.type !== filterType) {
                return false;
            }
            
            return true;
        });
        
        // Update pagination
        updatePagination();
        renderHistory();
    }

    function renderHistory() {
        const historyBody = document.getElementById('historyBody');
        historyBody.innerHTML = '';
        
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const pageHistory = filteredHistory.slice(startIndex, endIndex);
        
        if (pageHistory.length === 0) {
            historyBody.innerHTML = `
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        Aucune activité trouvée
                    </td>
                </tr>
            `;
            return;
        }
        
        pageHistory.forEach(activity => {
            const row = document.createElement('tr');
            
            // Determine badge color based on type
            let badgeClass = '';
            switch(activity.type) {
                case 'user':
                    badgeClass = 'badge-success';
                    break;
                case 'equipement':
                    badgeClass = 'badge-primary';
                    break;
                case 'ticket':
                    badgeClass = 'badge-warning';
                    break;
                case 'affectation':
                    badgeClass = 'badge-info';
                    break;
                default:
                    badgeClass = 'badge-secondary';
            }
            
            // Determine avatar color based on role
            let avatarBg = 'bg-primary';
            if (activity.user.role === 'technicien') avatarBg = 'bg-success';
            if (activity.user.role === 'utilisateur') avatarBg = 'bg-warning';
            
            row.innerHTML = `
                <td><strong>#ACT${activity.id.toString().padStart(3, '0')}</strong></td>
                <td>${activity.date}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar ${avatarBg} text-white d-flex align-items-center justify-content-center rounded-circle me-2" style="width: 36px; height: 36px;">
                            ${activity.user.name.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <strong>${activity.user.name}</strong>
                            <div class="text-muted small">${activity.user.email}</div>
                        </div>
                    </div>
                </td>
                <td><span class="badge ${badgeClass}">${activity.type.charAt(0).toUpperCase() + activity.type.slice(1)}</span></td>
                <td>${activity.action}</td>
                <td>${activity.description}</td>
                <td>${activity.ip}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteActivity(${activity.id})" title="Supprimer">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            historyBody.appendChild(row);
        });
        
        // Update count
        document.getElementById('historyCount').textContent = 
            `Affichage de ${startIndex + 1} à ${Math.min(endIndex, filteredHistory.length)} sur ${filteredHistory.length} activités`;
    }

    function updatePagination() {
        const totalPages = Math.ceil(filteredHistory.length / itemsPerPage);
        document.getElementById('pageInfo').textContent = `Page ${currentPage} sur ${totalPages}`;
        
        document.getElementById('prevBtn').disabled = currentPage <= 1;
        document.getElementById('nextBtn').disabled = currentPage >= totalPages;
        
        // Reset to page 1 if current page is invalid
        if (currentPage > totalPages && totalPages > 0) {
            currentPage = totalPages;
            renderHistory();
        }
    }

    function nextPage() {
        const totalPages = Math.ceil(filteredHistory.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            renderHistory();
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            renderHistory();
        }
    }

    function setupEventListeners() {
        document.getElementById('searchInput').addEventListener('input', function() {
            currentPage = 1;
            loadHistory();
        });
        
        document.getElementById('filterType').addEventListener('change', function() {
            currentPage = 1;
            loadHistory();
        });
    }

    function updateStats() {
        const now = new Date();
        const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
        const weekStart = new Date(today);
        weekStart.setDate(today.getDate() - today.getDay());
        const monthStart = new Date(now.getFullYear(), now.getMonth(), 1);
        
        const todayCount = allHistory.filter(activity => {
            const activityDate = new Date(activity.date);
            return activityDate >= today;
        }).length;
        
        const weekCount = allHistory.filter(activity => {
            const activityDate = new Date(activity.date);
            return activityDate >= weekStart;
        }).length;
        
        const monthCount = allHistory.filter(activity => {
            const activityDate = new Date(activity.date);
            return activityDate >= monthStart;
        }).length;
        
        document.getElementById('todayCount').textContent = todayCount;
        document.getElementById('weekCount').textContent = weekCount;
        document.getElementById('monthCount').textContent = monthCount;
    }

    function deleteActivity(activityId) {
        if (confirm('Voulez-vous vraiment supprimer cette activité?')) {
            allHistory = allHistory.filter(activity => activity.id !== activityId);
            localStorage.setItem('system_history', JSON.stringify(allHistory));
            loadHistory();
            updateStats();
        }
    }

    function deleteAllHistory() {
        if (confirm('Voulez-vous vraiment supprimer tout l\'historique? Cette action est irréversible.')) {
            allHistory = [];
            localStorage.removeItem('system_history');
            loadHistory();
            updateStats();
            alert('Historique supprimé avec succès!');
        }
    }

    function refreshHistory() {
        currentPage = 1;
        loadHistory();
        updateStats();
        
        // Add a refresh activity
        const refreshActivity = generateActivity(
            'system',
            'Actualisation',
            'Historique actualisé par l\'utilisateur'
        );
        saveActivity(refreshActivity);
    }

    // Function to add activities from other pages
    function logActivity(type, action, description) {
        const activity = generateActivity(type, action, description);
        
        // Dispatch event for real-time update if on history page
        window.dispatchEvent(new CustomEvent('activity', { detail: activity }));
        
        // Also save to localStorage
        allHistory.unshift(activity);
        localStorage.setItem('system_history', JSON.stringify(allHistory));
        
        return activity;
    }
</script>
@endsection