<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - Gestion Parc Informatique</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #818cf8;
            --secondary: #7c3aed;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
            --border: #e5e7eb;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: #f8fafc;
            margin: 0;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid var(--border);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            padding: 0;
        }
        
        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .logo {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .logo-text {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--dark);
        }
        
        .nav-container {
            padding: 20px 0;
            height: calc(100vh - 90px);
            overflow-y: auto;
        }
        
        .nav-group {
            margin-bottom: 25px;
        }
        
        .nav-title {
            padding: 0 20px 12px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--gray);
            font-weight: 600;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover {
            background: var(--light);
            color: var(--primary);
            border-left-color: var(--primary-light);
        }
        
        .nav-link.active {
            background: linear-gradient(to right, rgba(79, 70, 229, 0.05), transparent);
            color: var(--primary);
            font-weight: 600;
            border-left-color: var(--primary);
        }
        
        .nav-link i {
            width: 20px;
            font-size: 1.1rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Top Bar */
        .top-bar {
            background: white;
            border-radius: 15px;
            padding: 20px 25px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }
        
        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }
        
        .page-title p {
            color: var(--gray);
            margin-top: 5px;
            margin: 0;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .user-info h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }
        
        .user-info p {
            margin: 0;
            font-size: 0.85rem;
            color: var(--gray);
        }
        
        .logout-btn {
            background: none;
            border: none;
            color: var(--danger);
            font-size: 1.2rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.1);
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        
        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 10px 0;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.95rem;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .action-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 15px;
            padding: 25px 20px;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .action-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.15);
        }
        
        .action-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .action-text {
            font-weight: 600;
            color: var(--dark);
            text-align: center;
        }
        
        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }
        
        .chart-card, .recent-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
        }
        
        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-laptop-house"></i>
            </div>
            <div class="logo-text">Gestion Parc</div>
        </div>
        
        <div class="nav-container">
            <!-- Main Navigation -->
            <div class="nav-group">
                <div class="nav-title">Navigation Principale</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de Bord</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link">
                    <i class="fas fa-users"></i>
                    <span>Gérer Utilisateurs</span>
                </a>
                <a href="{{ route('admin.equipements.index') }}" class="nav-link">
                    <i class="fas fa-desktop"></i>
                    <span>Équipements</span>
                </a>
            </div>
            
            <!-- Management -->
            <div class="nav-group">
                <div class="nav-title">Gestion</div>
                <a href="{{ route('admin.affectations.index') }}" class="nav-link">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Affectations</span>
                </a>
                <a href="{{ route('admin.tickets.index') }}" class="nav-link">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Tickets Maintenance</span>
                </a>
                <a href="{{ route('admin.historique') }}" class="nav-link">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
            </div>
            
            <!-- Reports & Settings -->
            <div class="nav-group">
                <div class="nav-title">Rapports & Configuration</div>
                <a href="{{ route('admin.rapports.index') }}" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    <span>Rapports</span>
                </a>
                <a href="{{ route('admin.configuration.index') }}" class="nav-link">
                    <i class="fas fa-cog"></i>
                    <span>Configuration</span>
                </a>
                <a href="{{ route('admin.approvisionnement') }}" class="nav-link">
                    <i class="fas fa-box"></i>
                    <span>Approvisionnement</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="page-title">
                <h1>Tableau de Bord Administrateur</h1>
                <p>Bienvenue, {{ auth()->user()->name }}. Voici un aperçu de votre système.</p>
            </div>
            
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>Administrateur</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: rgba(79, 70, 229, 0.1); color: var(--primary);">
                        <i class="fas fa-desktop"></i>
                    </div>
                </div>
                <div class="stat-value" id="totalEquipements">{{ $stats['totalEquipements'] ?? 0 }}</div>
                <div class="stat-label">Équipements Totaux</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success);">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="stat-value" id="totalUsers">{{ $stats['totalUsers'] ?? 0 }}</div>
                <div class="stat-label">Utilisateurs Actifs</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning);">
                        <i class="fas fa-tools"></i>
                    </div>
                </div>
                <div class="stat-value" id="maintenanceCount">{{ $stats['maintenanceCount'] ?? 0 }}</div>
                <div class="stat-label">En Maintenance</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: var(--danger);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="stat-value" id="openTickets">{{ $stats['openTickets'] ?? 0 }}</div>
                <div class="stat-label">Tickets Ouverts</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="{{ route('admin.users.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="action-text">Ajouter Utilisateur</div>
            </a>
            
            <a href="{{ route('admin.equipements.create') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="action-text">Ajouter Équipement</div>
            </a>
            
            <a href="{{ route('admin.rapports.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-file-export"></i>
                </div>
                <div class="action-text">Générer Rapport</div>
            </a>
            
            <a href="{{ route('admin.configuration.index') }}" class="action-card">
                <div class="action-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <div class="action-text">Configurer Système</div>
            </a>
        </div>
        
        <!-- Main Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column: Chart -->
            <div class="chart-card">
                <div class="card-header">
                    <div class="card-title">Statistiques des Équipements</div>
                </div>
                <canvas id="equipmentChart" height="250"></canvas>
            </div>
            
            <!-- Right Column: Recent Maintenance -->
            <div class="recent-card">
                <div class="card-header">
                    <div class="card-title">Maintenance Récente</div>
                </div>
                <div id="maintenanceList">
                    @forelse($stats['recentTickets'] ?? [] as $ticket)
                    <div class="maintenance-item" style="padding: 15px; border-bottom: 1px solid var(--border);">
                        <div class="maintenance-info">
                            <h6 style="margin: 0 0 5px 0; font-weight: 600;">{{ $ticket->equipement->nom ?? 'N/A' }}</h6>
                            <p style="margin: 0; color: var(--gray); font-size: 0.9rem;">{{ Str::limit($ticket->description, 50) }}</p>
                        </div>
                        <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                    </div>
                    @empty
                    <p class="text-center text-muted my-3">Aucune maintenance récente</p>
                    @endforelse
                </div>
            </div>
        </div>
        
        <!-- Recent Equipment Table -->
        <div class="chart-card">
            <div class="card-header">
                <div class="card-title">Équipements Récemment Ajoutés</div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Type</th>
                            <th>État</th>
                            <th>Localisation</th>
                            <th>Date Ajout</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['recentEquipments'] ?? [] as $equipment)
                        <tr>
                            <td>#{{ $equipment->id }}</td>
                            <td>{{ $equipment->nom }}</td>
                            <td>{{ $equipment->type }}</td>
                            <td>
                                @if($equipment->etat == 'neuf' || $equipment->etat == 'bon')
                                <span class="badge bg-success">{{ $equipment->etat }}</span>
                                @elseif($equipment->etat == 'moyen')
                                <span class="badge bg-warning">{{ $equipment->etat }}</span>
                                @else
                                <span class="badge bg-danger">{{ $equipment->etat }}</span>
                                @endif
                            </td>
                            <td>{{ $equipment->localisation }}</td>
                            <td>{{ $equipment->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Aucun équipement récent
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('equipmentChart').getContext('2d');
            
            // Get equipment data from PHP
            const equipmentData = @json($stats['equipmentByType'] ?? []);
            
            const labels = Object.keys(equipmentData);
            const data = Object.values(equipmentData);
            
            const backgroundColors = [
                'rgba(79, 70, 229, 0.7)',
                'rgba(124, 58, 237, 0.7)',
                'rgba(59, 130, 246, 0.7)',
                'rgba(16, 185, 129, 0.7)',
                'rgba(245, 158, 11, 0.7)',
                'rgba(239, 68, 68, 0.7)',
                'rgba(139, 92, 246, 0.7)',
                'rgba(6, 182, 212, 0.7)'
            ];
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: backgroundColors.slice(0, labels.length),
                        borderColor: backgroundColors.slice(0, labels.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>