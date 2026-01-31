<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion Parc Informatique</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen gradient-bg">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <!-- Logo & Title -->
        <div class="text-center mb-10">
            <div class="flex justify-center mb-4">
                <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-xl border border-white/30">
                    <i class="fas fa-laptop-house text-5xl text-white"></i>
                </div>
            </div>
            <h1 class="text-5xl font-bold text-white mb-4">Gestion Parc Informatique</h1>
            <p class="text-white/80 text-xl max-w-2xl">Système de gestion des équipements, pannes et utilisateurs</p>
        </div>

        <!-- Action Cards -->
        <div class="grid md:grid-cols-2 gap-8 max-w-4xl w-full mb-12">
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="text-center mb-6">
                    <i class="fas fa-user-shield text-4xl text-white mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-2">Administrateur</h3>
                    <p class="text-white/80">Gérez tous les équipements, utilisateurs et tickets</p>
                </div>
            </div>
            
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20">
                <div class="text-center mb-6">
                    <i class="fas fa-tools text-4xl text-white mb-4"></i>
                    <h3 class="text-2xl font-bold text-white mb-2">Technicien</h3>
                    <p class="text-white/80">Gérez les tickets de maintenance et interventions</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl card-shadow p-8 max-w-md w-full">
            <div class="space-y-4">
                @auth
                    <!-- If logged in -->
                    <div class="text-center">
                        <p class="text-gray-700 mb-4">Connecté en tant que: <span class="font-bold">{{ auth()->user()->name }}</span></p>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                               class="block w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                               <i class="fas fa-tachometer-alt mr-2"></i>Dashboard Admin
                            </a>
                        @elseif(auth()->user()->role === 'technicien')
                            <a href="{{ route('technicien.dashboard') }}"
                               class="block w-full bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                               <i class="fas fa-tools mr-2"></i>Dashboard Technicien
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                               class="block w-full bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                               <i class="fas fa-home mr-2"></i>Mon Dashboard
                            </a>
                        @endif
                        
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Log Out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @else
                    <!-- If not logged in -->
                    <a href="{{ route('login') }}"
                       class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-center">
                       <i class="fas fa-sign-in-alt mr-2"></i>Se Connecter
                    </a>
                    
                    <a href="{{ route('register') }}"
                       class="block w-full bg-white border-2 border-blue-500 text-blue-600 hover:bg-blue-50 font-semibold py-3 px-4 rounded-lg transition-all duration-200 text-center">
                       <i class="fas fa-user-plus mr-2"></i>Créer un Compte
                    </a>
                    
                    <div class="text-center mt-4">
                        <a href="{{ route('password.request') }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            Mot de passe oublié?
                        </a>
                    </div>
                @endauth
            </div>
            
        </div>

        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-white/70">
                &copy; {{ date('Y') }} Gestion Parc Informatique • Département Informatique
            </p>
            <p class="text-white/50 text-sm mt-1">
                Version 1.0 • Développé avec Laravel
            </p>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    
    <script>
        // Add floating animation to icons
        document.addEventListener('DOMContentLoaded', function() {
            const icons = document.querySelectorAll('.fa-laptop-house, .fa-user-shield, .fa-tools');
            icons.forEach((icon, index) => {
                icon.style.animation = `float 3s ease-in-out ${index * 0.5}s infinite`;
            });
            
            // Add keyframes for floating animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes float {
                    0%, 100% { transform: translateY(0); }
                    50% { transform: translateY(-10px); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>