<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'IT Asset Management') }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
            --border-color: #e2e8f0;
            --sidebar-width: 260px;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            font-size: 14px;
            color: #334155;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-brand {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        
        .sidebar-brand-text {
            color: white;
            font-weight: 600;
            font-size: 16px;
        }
        
        .sidebar-brand-text small {
            font-size: 11px;
            color: rgba(255,255,255,0.5);
            display: block;
        }
        
        .sidebar-menu {
            padding: 15px 0;
        }
        
        .sidebar-menu-title {
            padding: 10px 20px 5px;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .sidebar-menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            gap: 12px;
            font-weight: 500;
        }
        
        .sidebar-menu-item:hover {
            background: rgba(255,255,255,0.05);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .sidebar-menu-item.active {
            background: rgba(37, 99, 235, 0.2);
            color: white;
            border-left-color: var(--primary-color);
        }
        
        .sidebar-menu-item i {
            width: 20px;
            text-align: center;
            font-size: 16px;
        }
        
        .sidebar-menu-item .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.15);
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
        }
        
        /* Header */
        .main-header {
            background: white;
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .header-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header-btn {
            width: 40px;
            height: 40px;
            border: none;
            background: var(--light-color);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-color);
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .header-btn:hover {
            background: var(--primary-color);
            color: white;
        }
        
        .header-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            font-size: 10px;
            min-width: 18px;
            height: 18px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 15px 5px 5px;
            background: var(--light-color);
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .user-dropdown:hover {
            background: #e2e8f0;
        }
        
        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 13px;
        }
        
        .user-info {
            line-height: 1.3;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 13px;
            color: var(--dark-color);
        }
        
        .user-role {
            font-size: 11px;
            color: var(--secondary-color);
        }
        
        /* Page Content */
        .page-content {
            padding: 30px;
        }
        
        /* Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }
        
        .stat-icon.primary { background: #dbeafe; color: #3b82f6; }
        .stat-icon.success { background: #dcfce7; color: #22c55e; }
        .stat-icon.warning { background: #fef3c7; color: #f59e0b; }
        .stat-icon.danger { background: #fee2e2; color: #ef4444; }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark-color);
            margin: 10px 0 5px;
        }
        
        .stat-label {
            font-size: 13px;
            color: var(--secondary-color);
        }
        
        /* Tables */
        .data-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .data-table thead {
            background: var(--light-color);
        }
        
        .data-table thead th {
            border: none;
            padding: 15px 20px;
            font-weight: 600;
            color: var(--secondary-color);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .data-table tbody td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        .data-table tbody tr:hover {
            background: var(--light-color);
        }
        
        /* Badges */
        .badge-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .badge-status.active { background: #dbeafe; color: #1d4ed8; }
        .badge-status.inactive { background: #f1f5f9; color: #475569; }
        .badge-status.pending { background: #fef3c7; color: #b45309; }
        .badge-status.resolved { background: #dcfce7; color: #15803d; }
        .badge-status.warning { background: #fef3c7; color: #b45309; }
        .badge-status.success { background: #dcfce7; color: #15803d; }
        
        /* Custom Card */
        .custom-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .custom-card-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .custom-card-title {
            font-size: 16px;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .custom-card-body {
            padding: 20px;
        }
        
        /* Buttons */
        .btn-primary-custom {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .btn-primary-custom:hover {
            background: #1d4ed8;
            color: white;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stat-card .stat-icon.blue { background: #dbeafe; color: #3b82f6; }
        .stat-card .stat-icon.green { background: #dcfce7; color: #22c55e; }
        .stat-card .stat-icon.orange { background: #ffedd5; color: #f97316; }
        .stat-card .stat-icon.red { background: #fee2e2; color: #ef4444; }
        .stat-card .stat-icon.purple { background: #f3e8ff; color: #a855f7; }
        
        /* Sidebar User Section */
        .sidebar-user {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        
        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 0;
        }
        
        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            background: var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 12px;
            flex-shrink: 0;
        }
        
        .sidebar-user-details {
            min-width: 0;
        }
        
        .sidebar-user-name {
            color: white;
            font-weight: 600;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .sidebar-user-role {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
        }
        
        .sidebar-logout-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.7);
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        
        .sidebar-logout-btn:hover {
            background: var(--danger-color);
            color: white;
        }
    </style>
    
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fas fa-server"></i>
            </div>
            <div class="sidebar-brand-text">
                IT Assets
                <small>Management</small>
            </div>
        </div>
        
        <nav class="sidebar-menu">
            <!-- Main -->
            <div class="sidebar-menu-title">Main</div>
            
            <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Assets -->
            @can('actifs.view')
            <div class="sidebar-menu-title">Assets</div>

            <a href="{{ route('admin.actifs.index') }}" class="sidebar-menu-item {{ request()->routeIs('actifs.*') ? 'active' : '' }}">
                <i class="fas fa-desktop"></i>
                <span>All Assets</span>
                <span class="badge">156</span>
            </a>
            @endcan

            @can('localisations.view')
            <a href="{{ route('admin.localisations.index') }}" class="sidebar-menu-item {{ request()->routeIs('localisations.*') ? 'active' : '' }}">
                <i class="fas fa-map-marker-alt"></i>
                <span>Locations</span>
            </a>
            @endcan

            @can('logiciels.view')
            <a href="{{ route('admin.logiciels.index') }}" class="sidebar-menu-item {{ request()->routeIs('logiciels.*') ? 'active' : '' }}">
                <i class="fas fa-code"></i>
                <span>Software</span>
            </a>
            @endcan

            @can('licences.view')
            <a href="{{ route('admin.licences.index') }}" class="sidebar-menu-item {{ request()->routeIs('licences.*') ? 'active' : '' }}">
                <i class="fas fa-key"></i>
                <span>Licenses</span>
            </a>
            @endcan

            @canany(['tickets.view', 'interventions.view', 'maintenances.view'])
            <!-- Support -->
            <div class="sidebar-menu-title">Support</div>

            @can('tickets.view')
            <a href="{{ route('admin.tickets.index') }}" class="sidebar-menu-item {{ request()->routeIs('tickets.*') ? 'active' : '' }}">
                <i class="fas fa-ticket-alt"></i>
                <span>Tickets</span>
                @php
                     $openTicketsCount = \App\Models\TicketMaintenance::where('statut', 'ouvert')->count();
                 @endphp
                @if($openTicketsCount > 0)
                    <span class="badge">{{ $openTicketsCount }}</span>
                @endif
            </a>
            @endcan

            @can('interventions.view')
            <a href="{{ route('admin.interventions.index') }}" class="sidebar-menu-item {{ request()->routeIs('interventions.*') ? 'active' : '' }}">
                <i class="fas fa-tools"></i>
                <span>Interventions</span>
            </a>
            @endcan

            @can('maintenances.view')
            <a href="{{ route('admin.maintenances.index') }}" class="sidebar-menu-item {{ request()->routeIs('maintenances.*') ? 'active' : '' }}">
                <i class="fas fa-wrench"></i>
                <span>Maintenance</span>
            </a>
            @endcan
            @endcanany

            @canany(['contrats.view', 'prestataires.view'])
            <!-- Contracts -->
            <div class="sidebar-menu-title">Contracts</div>

            @can('contrats.view')
            <a href="{{ route('admin.contrats.index') }}" class="sidebar-menu-item {{ request()->routeIs('contrats.*') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i>
                <span>Contracts</span>
            </a>
            @endcan

            @can('prestataires.view')
            <a href="{{ route('admin.prestataires.index') }}" class="sidebar-menu-item {{ request()->routeIs('prestataires.*') ? 'active' : '' }}">
                <i class="fas fa-building"></i>
                <span>Providers</span>
            </a>
            @endcan
            @endcanany

            @can('notifications.view')
            <!-- Notifications -->
            <div class="sidebar-menu-title">Notifications</div>

            <a href="{{ route('admin.notifications.index') }}" class="sidebar-menu-item {{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}">
                <i class="fas fa-bell"></i>
                <span>Notifications</span>
                @php
                    $unreadCount = auth()->user()->notifications()->whereNull('lu_at')->count();
                @endphp
                @if($unreadCount > 0)
                    <span class="badge">{{ $unreadCount }}</span>
                @endif
            </a>
            @endcan

            @can('reports.view')
            <!-- Reports -->
            <div class="sidebar-menu-title">Reports</div>

            <a href="{{ route('admin.reports.index') }}" class="sidebar-menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i>
                <span>Reports</span>
            </a>
            @endcan

            <!-- Admin -->
            @if(auth()->user()->hasRoleByCode('admin'))
            <div class="sidebar-menu-title">Administration</div>

            <a href="{{ route('admin.utilisateurs.index') }}" class="sidebar-menu-item {{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>

            <a href="{{ route('admin.roles.index') }}" class="sidebar-menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <i class="fas fa-shield-alt"></i>
                <span>Roles</span>
            </a>

            <a href="{{ route('admin.settings.index') }}" class="sidebar-menu-item {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
            @endif
            
            <!-- User Section -->
            <div class="sidebar-user">
                <div class="sidebar-user-info">
                    <div class="sidebar-user-avatar">{{ auth()->user()->initials }}</div>
                    <div class="sidebar-user-details">
                        <div class="sidebar-user-name">{{ auth()->user()->full_name }}</div>
                        <div class="sidebar-user-role">{{ auth()->user()->roles->first()->libelle ?? 'User' }}</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-logout-btn" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </nav>
    </aside>
    
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="main-header">
            <div class="d-flex align-items-center gap-3">
                <button class="header-btn d-lg-none" onclick="toggleSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="header-title">@yield('page-title', 'Dashboard')</h1>
            </div>
            
            <div class="header-actions">
                <button class="header-btn" onclick="window.location.href='{{ route('admin.notifications.index') }}'">
                    <i class="fas fa-bell"></i>
                    @php
                        $unreadCount = auth()->user()->notifications()->whereNull('lu_at')->count();
                    @endphp
                    @if($unreadCount > 0)
                        <span class="badge">{{ $unreadCount }}</span>
                    @endif
                </button>
                
                <div class="dropdown">
                    <div class="user-dropdown" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            {{ auth()->user()->initials }}
                        </div>
                        <div class="user-info d-none d-md-block">
                            <div class="user-name">{{ auth()->user()->full_name }}</div>
                            <div class="user-role">{{ auth()->user()->roles->first()->libelle ?? 'User' }}</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2 text-muted" style="font-size: 12px;"></i>
                    </div>
                    
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.profile.show') }}">
                                <i class="fas fa-user me-2"></i> My Profile
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script>
        // Initialize dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl)
        })
        
        // Toggle sidebar on mobile
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
