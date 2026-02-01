<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Technicien') - Gestion Parc</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #0ea5e9;
            --dark: #1f2937;
            --light: #f9fafb;
            --gray: #6b7280;
            --border: #e5e7eb;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            background-color: #1e293b;
            color: white;
            width: 250px;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
            z-index: 1000;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
        }
        
        .nav-section {
            padding: 0.75rem 1.5rem;
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: #2d3748;
            color: white;
            border-left-color: var(--primary);
        }
        
        .nav-link i {
            width: 20px;
            margin-right: 10px;
            text-align: center;
        }
        
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }
        
        /* Top Bar */
        .top-bar {
            background-color: white;
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), #60a5fa);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
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
        
        .content-container {
            padding: 2rem;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
            transition: all 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: var(--gray);
            font-size: 0.95rem;
        }
        
        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .action-card {
            background: white;
            border: 2px solid var(--border);
            border-radius: 0.75rem;
            padding: 1.5rem;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s;
            cursor: pointer;
            text-align: center;
        }
        
        .action-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.15);
            text-decoration: none;
            color: inherit;
        }
        
        .action-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), #60a5fa);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }
        
        .action-text {
            font-weight: 600;
            color: var(--dark);
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th {
            background-color: #f8fafc;
            padding: 0.75rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            border-bottom: 1px solid var(--border);
        }
        
        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
        }
        
        .table tr:hover {
            background-color: #f8fafc;
        }
        
        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .badge-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .content-container {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .quick-actions {
                grid-template-columns: repeat(2, 1fr);
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
        
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.25rem;
            color: var(--gray);
            cursor: pointer;
            padding: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
        }
        
        /* Flash Messages */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background-color: #d1fae5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        /* Tasks List */
        .tasks-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .task-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid var(--border);
        }
        
        .task-item:last-child {
            border-bottom: none;
        }
        
        .task-info h4 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
            font-size: 0.95rem;
        }
        
        .task-info p {
            margin: 0;
            color: var(--gray);
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
            background: var(--secondary);
            border-color: var(--secondary);
            color: white;
        }
        
        /* Equipment Status */
        .equipment-status {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 0.75rem;
            margin-bottom: 0.75rem;
        }
        
        .equipment-info h4 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
        }
        
        .equipment-info p {
            margin: 0;
            color: var(--gray);
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn" id="mobileMenuBtn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2 class="mb-0">Gestion Parc</h2>
            <small class="text-muted">Technicien</small>
        </div>
        
        <div class="nav-section">Navigation Principale</div>
        
        <a href="{{ route('technicien.dashboard') }}" class="nav-link {{ request()->routeIs('technicien.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Tableau de Bord
        </a>
        
        <a href="{{ route('technicien.tickets') }}" class="nav-link {{ request()->routeIs('technicien.tickets*') ? 'active' : '' }}">
            <i class="fas fa-ticket-alt"></i> Mes Tickets
        </a>
        
        <a href="{{ route('technicien.interventions') }}" class="nav-link {{ request()->routeIs('technicien.interventions*') ? 'active' : '' }}">
            <i class="fas fa-tools"></i> Interventions
        </a>
        
        <div class="nav-section">GESTION</div>
        
        <a href="{{ route('technicien.equipements') }}" class="nav-link {{ request()->routeIs('technicien.equipements*') ? 'active' : '' }}">
            <i class="fas fa-desktop"></i> Équipements
        </a>
        
        <a href="{{ route('technicien.historique') }}" class="nav-link {{ request()->routeIs('technicien.historique') ? 'active' : '' }}">
            <i class="fas fa-history"></i> Historique
        </a>
        
        <a href="{{ route('technicien.rapports') }}" class="nav-link {{ request()->routeIs('technicien.rapports*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Rapports
        </a>
        
        <!-- User Profile at Bottom -->
        <div class="mt-auto p-4 border-t border-gray-700">
            <div class="d-flex align-items-center">
                <div class="user-avatar me-3">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-400">Technicien</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="d-flex align-items-center">
                <h1 class="page-title mb-0">@yield('title', 'Tableau de Bord Technicien')</h1>
            </div>
            
            <div class="user-profile">
                <div class="user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>Technicien IT</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success mx-4 mt-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger mx-4 mt-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                </div>
            </div>
        @endif
        
        <!-- Page Content -->
        <div class="content-container">
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('mobile-open');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.remove('mobile-open');
                }
            }
        });
        
        // Close sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768) {
                sidebar.classList.remove('mobile-open');
            }
        });
        
        // Animate stats counter
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
        
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Animate all stat values
            const statValues = document.querySelectorAll('.stat-number');
            statValues.forEach(stat => {
                const target = parseInt(stat.textContent) || 0;
                animateCounter(stat, 0, target, 1500);
            });
            
            // Task checkbox functionality
            const checkboxes = document.querySelectorAll('.task-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', function() {
                    this.classList.toggle('checked');
                });
            });
            
            // Notification click
            const notificationBtn = document.querySelector('.notification-badge');
            if (notificationBtn) {
                notificationBtn.addEventListener('click', function() {
                    alert('Vous avez des notifications non lues');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>