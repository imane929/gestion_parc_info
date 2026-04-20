<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="base-url" content="{{ url('/') }}"/>

    <title>Connexion | AssetFlow</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#0058be",
                        "primary-container": "#2170e4",
                        "on-primary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#e6eeff",
                        "surface-container-highest": "#d9e3f6",
                        "surface-container-high": "#dee9fc",
                        "surface-bright": "#f8f9ff",
                        "on-surface": "#121c2a",
                        "on-surface-variant": "#424754",
                        "outline": "#727785",
                        "outline-variant": "#c2c6d6",
                        error: "#ba1a1a",
                        secondary: "#6b38d4",
                        tertiary: "#924700",
                        background: "#f8f9ff"
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"]
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap');
        
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9ff 0%, #e6eeff 50%, #f8f9ff 100%);
            min-height: 100vh;
        }
        
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #0058be 0%, #2170e4 50%, #6b38d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(0, 88, 190, 0.3); }
            50% { box-shadow: 0 0 40px rgba(0, 88, 190, 0.6); }
        }
        
        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(0, 88, 190, 0.15);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateX(8px);
        }
        
        .background-pattern {
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(0, 88, 190, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(107, 56, 212, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(33, 112, 228, 0.05) 0%, transparent 30%);
        }
        
        .shimmer {
            background: linear-gradient(
                90deg,
                rgba(255,255,255,0) 0%,
                rgba(255,255,255,0.5) 50%,
                rgba(255,255,255,0) 100%
            );
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col background-pattern relative">
    <!-- Decorative Elements -->
    <div class="fixed top-20 left-10 w-32 h-32 bg-primary/10 rounded-full blur-3xl"></div>
    <div class="fixed bottom-20 right-10 w-40 h-40 bg-secondary/10 rounded-full blur-3xl"></div>
    <div class="fixed top-1/2 left-1/4 w-20 h-20 bg-tertiary/10 rounded-full blur-2xl"></div>

    <!-- Header -->
    <header class="relative z-10 px-8 py-6">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-10 w-auto">
            <div>
                <span class="text-2xl font-bold tracking-tight text-gray-800">AssetFlow</span>
                <span class="text-xs font-semibold text-primary-container block -mt-1">IT Management</span>
            </div>
        </a>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Side - Content -->
            <div class="hidden lg:block space-y-8 pl-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 rounded-full mb-4">
                        <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                        <span class="text-xs font-semibold text-primary uppercase tracking-wider">Enterprise Solution</span>
                    </div>
                    <h1 class="text-5xl font-bold text-gray-900 leading-tight mb-4">
                        Gérez vos actifs <span class="gradient-text">informatiques</span><br/>
                        avec intelligence
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed max-w-md">
                        Une plateforme complète pour le suivi, la maintenance et l'optimisation de votre parc informatique.
                    </p>
                </div>
                
                <div class="space-y-4">
                    <div class="feature-card flex items-center gap-4 p-4 rounded-xl bg-white/50 border border-white/50 shadow-sm">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">dashboard</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Tableau de bord intuitif</p>
                            <p class="text-sm text-gray-500">Visualisez l'état de votre parc en temps réel</p>
                        </div>
                    </div>
                    
                    <div class="feature-card flex items-center gap-4 p-4 rounded-xl bg-white/50 border border-white/50 shadow-sm">
                        <div class="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">confirmation_number</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Gestion des tickets</p>
                            <p class="text-sm text-gray-500">Suivi complet des interventions et maintenances</p>
                        </div>
                    </div>
                    
                    <div class="feature-card flex items-center gap-4 p-4 rounded-xl bg-white/50 border border-white/50 shadow-sm">
                        <div class="w-12 h-12 bg-tertiary/10 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-tertiary">analytics</span>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">Rapports détaillés</p>
                            <p class="text-sm text-gray-500">Analysez et optimisez vos ressources IT</p>
                        </div>
                    </div>
                </div>
                
                <!-- Stats -->
                <div class="flex gap-8 pt-4">
                    <div>
                        <p class="text-3xl font-bold text-gray-900">500+</p>
                        <p class="text-sm text-gray-500">Entreprises</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900">10k+</p>
                        <p class="text-sm text-gray-500">Actifs gérés</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-gray-900">99.9%</p>
                        <p class="text-sm text-gray-500">Disponibilité</p>
                    </div>
                </div>
            </div>
            
            <!-- Right Side - Login Form -->
            <div class="w-full max-w-md">
                <div class="glass-card rounded-3xl p-8 shadow-2xl shadow-gray-200/50">
                    <!-- Form Header -->
                    <div class="text-center mb-8">
                        <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-12 mx-auto mb-4 w-auto">
                        <h2 class="text-2xl font-bold text-gray-800 mb-1">Bienvenue</h2>
                        <p class="text-gray-500 text-sm">Connectez-vous pour accéder au panneau d'administration</p>
                    </div>

                    <!-- Alerts -->
                    @if(session('status'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-700">
                            <span class="material-symbols-outlined">check_circle</span>
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <div class="flex items-center gap-3 text-red-700 mb-2">
                                <span class="material-symbols-outlined">error</span>
                                <span class="font-semibold">Erreur de connexion</span>
                            </div>
                            <ul class="text-sm text-red-600 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        
                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1" for="email">Adresse Email</label>
                            <div class="relative group">
                                <input class="w-full bg-white border-2 border-gray-100 focus:border-primary focus:ring-0 rounded-xl px-4 py-3.5 text-sm transition-all input-glow @error('email') border-red-300 @enderror" 
                                    id="email" name="email" value="{{ old('email') }}" 
                                    placeholder="admin@assetflow.com" type="email" required autofocus/>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">mail</span>
                            </div>
                        </div>
                        
                        <!-- Password -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="text-xs font-bold uppercase tracking-wider text-gray-500 ml-1" for="password">Mot de passe</label>
                                @if(Route::has('password.request'))
                                    <a class="text-xs font-semibold text-primary hover:text-primary-container transition-colors" href="{{ route('password.request') }}">Mot de passe oublié ?</a>
                                @endif
                            </div>
                            <div class="relative group">
                                <input class="w-full bg-white border-2 border-gray-100 focus:border-primary focus:ring-0 rounded-xl px-4 py-3.5 text-sm transition-all input-glow @error('password') border-red-300 @enderror" 
                                    id="password" name="password" placeholder="••••••••••" type="password" required/>
                                <span class="material-symbols-outlined absolute right-14 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">lock</span>
                                <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors" id="togglePassword">
                                    <span class="material-symbols-outlined">visibility</span>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="flex items-center gap-3">
                            <input class="w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary/20 cursor-pointer" id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}/>
                            <label class="text-sm text-gray-600 cursor-pointer" for="remember">Se souvenir de moi</label>
                        </div>
                        
                        <!-- Submit Button -->
                        <button class="w-full bg-gradient-to-r from-primary to-primary-container text-white font-semibold py-4 rounded-xl shadow-lg shadow-primary/25 hover:shadow-xl hover:shadow-primary/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2" type="submit">
                            <span>Se connecter</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                        <p class="text-gray-500 text-sm mb-3">Vous n'avez pas de compte ?</p>
                        <a class="inline-flex items-center gap-2 px-6 py-2.5 bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold rounded-full transition-all hover:scale-105" href="{{ route('request-access') }}">
                            <span class="material-symbols-outlined text-lg">person_add</span>
                            Demander l'accès
                        </a>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-400">© {{ date('Y') }} AssetFlow. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            // Add CSRF token to all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            if ($('.bg-red-50, .bg-emerald-50').length) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            $('#togglePassword').click(function() {
                const passwordInput = $('#password');
                const icon = $(this).find('.material-symbols-outlined');
                
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    icon.text('visibility_off');
                } else {
                    passwordInput.attr('type', 'password');
                    icon.text('visibility');
                }
            });
        });
    </script>
</body>
</html>