<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Gestion Parc</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
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
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #f5f7fa;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
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
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
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
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
        }
        
        /* Top Bar Styles */
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
        
        /* Card Styles */
        .card {
            background: white;
            border-radius: 15px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        /* Table Styles */
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            margin-bottom: 0;
        }
        
        .table th {
            background-color: #f8fafc;
            padding: 0.75rem 1.5rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }
        
        .table tr:hover {
            background-color: #f8fafc;
        }
        
        /* Button Styles */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
            color: white;
        }
        
        .btn-secondary {
            background-color: var(--gray);
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #4b5563;
            color: white;
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            background-color: #0da271;
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #dc2626;
            color: white;
        }
        
        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }
        
        /* Badge Styles */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .bg-primary { background-color: var(--primary); }
        .bg-secondary { background-color: var(--gray); }
        .bg-success { background-color: var(--success); }
        .bg-warning { background-color: var(--warning); }
        .bg-danger { background-color: var(--danger); }
        .bg-info { background-color: var(--info); }
        
        /* Form Styles */
        .form-control {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            width: 100%;
            transition: border-color 0.2s;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .form-select {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            width: 100%;
            background-color: white;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
        }
        
        .form-text {
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        /* Alert Styles */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
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
        
        /* Stat Card Styles */
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
        
        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
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
        }
        
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .page-title h1 {
                font-size: 1.5rem;
            }
            
            .card-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            width: 45px;
            height: 45px;
            background: white;
            border: 2px solid var(--border);
            border-radius: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 992px) {
            .mobile-menu-btn {
                display: flex;
            }
        }
        
        .mobile-menu-btn span {
            width: 20px;
            height: 2px;
            background: var(--dark);
            transition: all 0.3s;
        }
        
        /* Content Area */
        .content-area {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Flash Messages Container */
        .flash-container {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 1001;
            max-width: 400px;
        }
        
        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 1rem;
            height: 1rem;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: 50%;
            border-top-color: var(--primary);
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Mobile Menu Button -->
    <div class="mobile-menu-btn" id="mobileMenuBtn">
        <span></span>
        <span></span>
        <span></span>
    </div>
    
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
                <h1>@yield('title', 'Tableau de Bord')</h1>
                <p>@yield('subtitle', 'Gestion Parc Informatique')</p>
            </div>
            
            <div class="user-profile">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-info">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>Administrateur</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-left: 15px;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Flash Messages -->
        <div class="flash-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        
        <!-- Page Content -->
        <div class="content-area">
            @yield('content')
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992) {
                    if (!sidebar.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                        sidebar.classList.remove('mobile-open');
                    }
                }
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
            
            // Add active class to current page link
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Form validation
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const requiredFields = form.querySelectorAll('[required]');
                    let valid = true;
                    
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            valid = false;
                            field.classList.add('is-invalid');
                        } else {
                            field.classList.remove('is-invalid');
                        }
                    });
                    
                    if (!valid) {
                        e.preventDefault();
                        alert('Veuillez remplir tous les champs obligatoires.');
                    }
                });
            });
            
            // Table row click functionality
            const tableRows = document.querySelectorAll('tbody tr[data-href]');
            tableRows.forEach(row => {
                row.addEventListener('click', function() {
                    window.location.href = this.dataset.href;
                });
            });
        });
        
        // Confirm before delete
        function confirmDelete(event, message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
            if (!confirm(message)) {
                event.preventDefault();
                return false;
            }
            return true;
        }
        
        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
        }
        
        // Format dates
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
        
        // Copy to clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copié dans le presse-papier !');
            }).catch(err => {
                console.error('Erreur de copie : ', err);
            });
        }
        
        // Search filter for tables
        function filterTable(tableId, searchId) {
            const table = document.getElementById(tableId);
            const search = document.getElementById(searchId);
            const filter = search.value.toUpperCase();
            const tr = table.getElementsByTagName('tr');
            
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < td.length; j++) {
                    if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
                
                tr[i].style.display = found ? '' : 'none';
            }
        }
        
        // Modal helper
        function showModal(modalId) {
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
        
        // Loading state for buttons
        function setLoading(button, isLoading) {
            if (isLoading) {
                button.disabled = true;
                button.innerHTML = '<span class="spinner"></span> Chargement...';
            } else {
                button.disabled = false;
                button.innerHTML = button.getAttribute('data-original-text');
            }
        }

        // Listen for form submissions and log activities
        document.addEventListener('DOMContentLoaded', function() {
            // Log user creation
            const userForms = document.querySelectorAll('form[action*="users"]');
            userForms.forEach(form => {
                form.addEventListener('submit', function() {
                    logActivity('user', 'création', 'Nouvel utilisateur créé');
                });
            });

            // Log equipment creation
            const equipmentForms = document.querySelectorAll('form[action*="equipements"]');
            equipmentForms.forEach(form => {
                form.addEventListener('submit', function() {
                    logActivity('equipement', 'ajout', 'Nouvel équipement ajouté');
                });
            });

            // Log configuration changes
            const configForm = document.querySelector('form[action*="configuration"]');
            if (configForm) {
                configForm.addEventListener('submit', function() {
                    logActivity('system', 'configuration', 'Configuration mise à jour');
                });
            }
        });

        function logActivity(type, action, description) {
            // Store activity in localStorage
            const activities = JSON.parse(localStorage.getItem('system_activities') || '[]');
            activities.push({
                id: Date.now(),
                type: type,
                action: action,
                description: description,
                timestamp: new Date().toISOString(),
                user: "{{ auth()->user()->name }}"
            });
            localStorage.setItem('system_activities', JSON.stringify(activities));
        }
    </script>
    
    @stack('scripts')
</body>
</html>