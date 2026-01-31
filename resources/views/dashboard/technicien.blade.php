<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Technicien - Gestion Parc Informatique</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary-color: #3b82f6;
            --secondary-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            margin: 0;
            min-height: 100vh;
        }
        
        .technician-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        /* Header */
        .tech-header {
            background: white;
            border-radius: 20px;
            padding: 25px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-left h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        
        .header-left p {
            color: #6b7280;
            margin-top: 8px;
            margin: 0;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .notification-badge {
            position: relative;
            cursor: pointer;
        }
        
        .notification-badge i {
            font-size: 1.3rem;
            color: #6b7280;
        }
        
        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .tech-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            background: #f0f9ff;
            border-radius: 12px;
            border: 1px solid #dbeafe;
        }
        
        .tech-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary-color), #60a5fa);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .tech-info h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
        }
        
        .tech-info p {
            margin: 2px 0 0 0;
            font-size: 0.85rem;
            color: #6b7280;
        }
        
        /* Stats Cards */
        .tech-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .tech-stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            transition: all 0.3s;
        }
        
        .tech-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .tech-stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .tech-stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        
        .tech-stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1f2937;
            margin: 10px 0;
        }
        
        .tech-stat-label {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        /* Main Content */
        .tech-main-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }
        
        .tech-main-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
        }
        
        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        /* Tickets Table */
        .tickets-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .tickets-table th {
            background: #f9fafb;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .tickets-table td {
            padding: 16px;
            border-bottom: 1px solid #e5e7eb;
            color: #1f2937;
        }
        
        .tickets-table tr:hover {
            background: #f9fafb;
        }
        
        .priority-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .priority-high {
            background: #fee2e2;
            color: #dc2626;
        }
        
        .priority-medium {
            background: #fef3c7;
            color: #d97706;
        }
        
        .priority-low {
            background: #d1fae5;
            color: #059669;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        
        .status-open {
            background: #dbeafe;
            color: #1d4ed8;
        }
        
        .status-in-progress {
            background: #fef3c7;
            color: #d97706;
        }
        
        .status-resolved {
            background: #d1fae5;
            color: #065f46;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        
        .btn-small {
            padding: 6px 12px;
            border-radius: 8px;
            border: none;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-view {
            background: #dbeafe;
            color: #1d4ed8;
        }
        
        .btn-view:hover {
            background: #bfdbfe;
        }
        
        .btn-start {
            background: #fef3c7;
            color: #d97706;
        }
        
        .btn-start:hover {
            background: #fde68a;
        }
        
        .btn-complete {
            background: #d1fae5;
            color: #065f46;
        }
        
        .btn-complete:hover {
            background: #a7f3d0;
        }
        
        /* Sidebar Tasks */
        .tasks-list {
            list-style: none;
            padding: 0;
        }
        
        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .task-item:last-child {
            border-bottom: none;
        }
        
        .task-info h4 {
            margin: 0 0 5px 0;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .task-info p {
            margin: 0;
            color: #6b7280;
            font-size: 0.85rem;
        }
        
        .task-checkbox {
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .task-checkbox.checked {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
            color: white;
        }
        
        /* Quick Actions */
        .tech-quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .tech-action-btn {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 25px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 15px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: inherit;
        }
        
        .tech-action-btn:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(59, 130, 246, 0.15);
        }
        
        .tech-action-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), #60a5fa);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .tech-action-text {
            font-weight: 600;
            color: #1f2937;
            text-align: center;
        }
        
        /* Equipment Status */
        .equipment-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 10px;
        }
        
        .equipment-info h4 {
            margin: 0 0 5px 0;
            font-weight: 600;
        }
        
        .equipment-info p {
            margin: 0;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        /* Logout Button */
        .logout-section {
            text-align: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn-logout {
            padding: 12px 30px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .tech-main-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .tech-header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .tech-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .tech-quick-actions {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 480px) {
            .tech-stats-grid {
                grid-template-columns: 1fr;
            }
            
            .tech-quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="technician-container">
        <!-- Header -->
        <div class="tech-header">
            <div class="header-left">
                <h1>Tableau de Bord Technicien</h1>
                <p>Gérez vos interventions et suivez vos équipements</p>
            </div>
            <div class="header-right">
                <div class="notification-badge">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">3</span>
                </div>
                <div class="tech-profile">
                    <div class="tech-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="tech-info">
                        <h3>{{ auth()->user()->name }}</h3>
                        <p>Technicien IT</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="tech-stats-grid">
            <div class="tech-stat-card">
                <div class="tech-stat-header">
                    <div class="tech-stat-icon" style="background: #dbeafe; color: var(--primary-color);">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <span class="priority-badge priority-high">Urgent</span>
                </div>
                <div class="tech-stat-value">8</div>
                <div class="tech-stat-label">Tickets Assignés</div>
            </div>
            
            <div class="tech-stat-card">
                <div class="tech-stat-header">
                    <div class="tech-stat-icon" style="background: #fef3c7; color: var(--warning-color);">
                        <i class="fas fa-tools"></i>
                    </div>
                    <span class="status-badge status-in-progress">En cours</span>
                </div>
                <div class="tech-stat-value">5</div>
                <div class="tech-stat-label">Interventions Actives</div>
            </div>
            
            <div class="tech-stat-card">
                <div class="tech-stat-header">
                    <div class="tech-stat-icon" style="background: #d1fae5; color: var(--secondary-color);">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <span class="status-badge status-resolved">Terminés</span>
                </div>
                <div class="tech-stat-value">24</div>
                <div class="tech-stat-label">Tickets Résolus</div>
            </div>
            
            <div class="tech-stat-card">
                <div class="tech-stat-header">
                    <div class="tech-stat-icon" style="background: #f3f4f6; color: #6b7280;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <span style="color: #6b7280; font-size: 0.9rem;">Moyenne</span>
                </div>
                <div class="tech-stat-value">2.4h</div>
                <div class="tech-stat-label">Temps de Réponse</div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="tech-quick-actions">
            <a href="#" class="tech-action-btn">
                <div class="tech-action-icon">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div class="tech-action-text">Nouveau Ticket</div>
            </a>
            
            <a href="#" class="tech-action-btn">
                <div class="tech-action-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="tech-action-text">Mes Interventions</div>
            </a>
            
            <a href="#" class="tech-action-btn">
                <div class="tech-action-icon">
                    <i class="fas fa-history"></i>
                </div>
                <div class="tech-action-text">Historique</div>
            </a>
            
            <a href="#" class="tech-action-btn">
                <div class="tech-action-icon">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="tech-action-text">Rapports</div>
            </a>
        </div>
        
        <!-- Main Content -->
        <div class="tech-main-grid">
            <!-- Left Column: Tickets -->
            <div class="tech-main-card">
                <div class="card-title">
                    Tickets de Maintenance
                    <button class="btn-small btn-view">
                        <i class="fas fa-plus"></i> Nouveau
                    </button>
                </div>
                <div style="overflow-x: auto;">
                    <table class="tickets-table">
                        <thead>
                            <tr>
                                <th>ID Ticket</th>
                                <th>Équipement</th>
                                <th>Priorité</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#TK-2024-001</td>
                                <td>Serveur Dell R740</td>
                                <td><span class="priority-badge priority-high">Haute</span></td>
                                <td><span class="status-badge status-open">Ouvert</span></td>
                                <td>15/01/2024</td>
                                <td class="action-buttons">
                                    <button class="btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-small btn-start">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#TK-2024-002</td>
                                <td>Imprimante HP LaserJet</td>
                                <td><span class="priority-badge priority-medium">Moyenne</span></td>
                                <td><span class="status-badge status-in-progress">En cours</span></td>
                                <td>14/01/2024</td>
                                <td class="action-buttons">
                                    <button class="btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-small btn-complete">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#TK-2024-003</td>
                                <td>PC Portable Lenovo</td>
                                <td><span class="priority-badge priority-low">Basse</span></td>
                                <td><span class="status-badge status-in-progress">En cours</span></td>
                                <td>13/01/2024</td>
                                <td class="action-buttons">
                                    <button class="btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-small btn-complete">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>#TK-2024-004</td>
                                <td>Switch Cisco 2960</td>
                                <td><span class="priority-badge priority-high">Haute</span></td>
                                <td><span class="status-badge status-open">Ouvert</span></td>
                                <td>12/01/2024</td>
                                <td class="action-buttons">
                                    <button class="btn-small btn-view">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-small btn-start">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Right Column: Tasks & Equipment -->
            <div>
                <!-- Daily Tasks -->
                <div class="tech-main-card" style="margin-bottom: 25px;">
                    <div class="card-title">
                        Tâches du Jour
                        <span style="font-size: 0.9rem; color: #6b7280;">3/5 complétées</span>
                    </div>
                    <ul class="tasks-list">
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Vérifier backup serveur</h4>
                                <p>10:00 AM - Salle serveurs</p>
                            </div>
                            <div class="task-checkbox checked">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Maintenance imprimante 203</h4>
                                <p>11:30 AM - Bureau 203</p>
                            </div>
                            <div class="task-checkbox checked">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Installation nouveau PC</h4>
                                <p>14:00 PM - Direction</p>
                            </div>
                            <div class="task-checkbox checked">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Diagnostic réseau étage 2</h4>
                                <p>15:30 PM - Étage 2</p>
                            </div>
                            <div class="task-checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                        <li class="task-item">
                            <div class="task-info">
                                <h4>Mise à jour inventaire</h4>
                                <p>16:00 PM - Bureau</p>
                            </div>
                            <div class="task-checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <!-- Equipment Status -->
                <div class="tech-main-card">
                    <div class="card-title">
                        État des Équipements
                    </div>
                    <div class="equipment-status">
                        <div class="equipment-info">
                            <h4>PC Bureau 205</h4>
                            <p>Dernière maintenance: 10/01/2024</p>
                        </div>
                        <span class="status-badge status-resolved">OK</span>
                    </div>
                    <div class="equipment-status">
                        <div class="equipment-info">
                            <h4>Serveur Principal</h4>
                            <p>Prochaine maintenance: 25/01/2024</p>
                        </div>
                        <span class="status-badge status-open">À vérifier</span>
                    </div>
                    <div class="equipment-status">
                        <div class="equipment-info">
                            <h4>Imprimante Réunion</h4>
                            <p>Cartouche à 15%</p>
                        </div>
                        <span class="priority-badge priority-medium">Attention</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Logout Section -->
        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Task checkbox functionality
            const checkboxes = document.querySelectorAll('.task-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.classList.toggle('checked');
                });
            });
            
            // Animate stats
            function animateCounter(element, start, end, duration) {
                let startTime = null;
                const step = (timestamp) => {
                    if (!startTime) startTime = timestamp;
                    const progress = Math.min((timestamp - startTime) / duration, 1);
                    const value = Math.floor(progress * (end - start) + start);
                    element.textContent = value;
                    if (progress < 1) {
                        requestAnimationFrame(step);
                    }
                };
                requestAnimationFrame(step);
            }
            
            // Animate all stat values
            const statValues = document.querySelectorAll('.tech-stat-value');
            statValues.forEach(stat => {
                const target = parseInt(stat.textContent);
                animateCounter(stat, 0, target, 1500);
            });
            
            // Notification click
            const notificationBtn = document.querySelector('.notification-badge');
            notificationBtn.addEventListener('click', function() {
                alert('Vous avez 3 notifications non lues');
            });
        });
    </script>
</body>
</html>