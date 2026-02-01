<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Utilisateur') - Gestion Parc</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #10b981;
            --secondary: #3b82f6;
            --warning: #f59e0b;
            --danger: #ef4444;
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
        
        /* Simple header for user dashboard */
        .user-header {
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 40;
        }
        
        .user-content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
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
        
        /* Stats Cards for User */
        .user-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .user-stat-card {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid var(--border);
            text-align: center;
        }
        
        .user-stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        
        .user-stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0.5rem 0;
        }
        
        .user-stat-label {
            color: var(--gray);
            font-size: 0.95rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .user-content {
                padding: 1rem;
            }
            
            .user-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
            
            .user-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 576px) {
            .user-stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="user-header">
        <div>
            <h1 class="h3 mb-0">Tableau de Bord Utilisateur</h1>
        </div>
        
        <div class="user-profile">
            <div class="user-info">
                <h4>{{ Auth::user()->name }}</h4>
                <p>Utilisateur</p>
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
    <div class="user-content">
        @yield('content')
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>