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
        
        /* Sidebar - Updated to match other pages */
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
        
        /* Rest of your dashboard styles... */
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
    </style>
</head>
<body>
    <!-- Mobile Menu Button -->
    <button class="mobile-menu-btn d-none d-md-block d-lg-none" id="mobileMenuBtn" onclick="toggleSidebar()" style="position: fixed; top: 20px; left: 20px; z-index: 1001; background: white; border: 1px solid var(--border); border-radius: 8px; padding: 10px; cursor: pointer;">
        <i class="fas fa-bars"></i>
    </button>
    
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
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de Bord</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Gérer Utilisateurs</span>
                </a>
                <a href="{{ route('admin.equipements.index') }}" class="nav-link {{ request()->routeIs('admin.equipements.*') ? 'active' : '' }}">
                    <i class="fas fa-desktop"></i>
                    <span>Équipements</span>
                </a>
            </div>
            
            <!-- Management -->
            <div class="nav-group">
                <div class="nav-title">Gestion</div>
                <a href="{{ route('admin.affectations.index') }}" class="nav-link {{ request()->routeIs('admin.affectations.*') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Affectations</span>
                </a>
                <a href="{{ route('admin.tickets.index') }}" class="nav-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                    <i class="fas fa-ticket-alt"></i>
                    <span>Tickets Maintenance</span>
                </a>
                <a href="{{ route('admin.historique') }}" class="nav-link {{ request()->routeIs('admin.historique') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
            </div>
            
            <!-- Reports & Settings -->
            <div class="nav-group">
                <div class="nav-title">Rapports & Configuration</div>
                <a href="{{ route('admin.rapports.index') }}" class="nav-link {{ request()->routeIs('admin.rapports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar"></i>
                    <span>Rapports</span>
                </a>
                <a href="{{ route('admin.configuration.index') }}" class="nav-link {{ request()->routeIs('admin.configuration.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Configuration</span>
                </a>
                <a href="{{ route('admin.approvisionnement') }}" class="nav-link {{ request()->routeIs('admin.approvisionnement') ? 'active' : '' }}">
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
        
        @yield('content')
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            
            if (window.innerWidth <= 992) {
                if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });
        
        // Close sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>