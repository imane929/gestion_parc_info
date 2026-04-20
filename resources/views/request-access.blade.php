<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Demander l'accès | AssetFlow</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#0058be",
                        "primary-container": "#2170e4",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#fefcff",
                        "on-surface": "#121c2a",
                        "on-surface-variant": "#424754",
                        "surface": "#f8f9ff",
                        "surface-container": "#e6eeff",
                        "surface-container-low": "#eff4ff",
                        "surface-container-high": "#dee9fc",
                        "surface-container-highest": "#d9e3f6",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#727785",
                        "outline-variant": "#c2c6d6",
                        "background": "#f8f9ff",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "tertiary": "#924700",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#b75b00",
                        "on-tertiary-container": "#fffbff",
                        "tertiary-fixed": "#ffdcc6",
                        "on-tertiary-fixed": "#311400",
                        "secondary": "#6b38d4",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#8455ef",
                        "on-secondary-container": "#fffbff",
                        "inverse-surface": "#27313f",
                        "inverse-on-surface": "#eaf1ff",
                    },
                    "fontFamily": {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    }
                },
            },
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .gradient-text {
            background: linear-gradient(135deg, #0058be 0%, #2170e4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="bg-background text-on-surface min-h-screen relative">
    <!-- Background Elements -->
    <div class="fixed top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-3xl"></div>
    <div class="fixed bottom-0 left-0 w-[400px] h-[400px] bg-secondary/5 rounded-full blur-3xl"></div>
    <div class="fixed top-1/3 left-1/4 w-32 h-32 bg-tertiary/10 rounded-full blur-2xl"></div>

    <!-- Header -->
    <header class="relative z-10 px-8 py-4">
        <a href="/" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-10 w-auto">
            <div>
                <span class="text-2xl font-bold tracking-tight text-gray-800">AssetFlow</span>
                <span class="text-xs font-semibold text-primary-container block -mt-1">IT Management</span>
            </div>
        </a>
    </header>

    <!-- Main Content -->
    <main class="relative z-10 flex-1 flex items-center justify-center px-4 py-12 min-h-screen">
        <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            
            <!-- Left Side - Content -->
            <div class="hidden lg:block space-y-8 pl-8">
                <div>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-primary/10 rounded-full mb-4">
                        <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                        <span class="text-xs font-semibold text-primary uppercase tracking-wider">Enterprise Solution</span>
                    </div>
                    <h1 class="text-5xl font-bold text-gray-900 leading-tight mb-4">
                        Demandez l'accès à <span class="gradient-text">AssetFlow</span>
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed max-w-md">
                        Remplissez le formulaire ci-dessous pour soumettre une demande d'accès à notre plateforme de gestion des actifs informatiques.
                    </p>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary mb-3">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">Gestion Centralisée</h3>
                        <p class="text-sm text-gray-500">Suivi en temps réel de tous vos actifs</p>
                    </div>
                    <div class="bg-white/60 backdrop-blur-sm rounded-2xl p-5 border border-gray-100 shadow-sm hover:shadow-md transition-all">
                        <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary mb-3">
                            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">insights</span>
                        </div>
                        <h3 class="font-semibold text-gray-800 mb-1">Analyses Avancées</h3>
                        <p class="text-sm text-gray-500">Tableaux de bord et rapports détaillés</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-sm">check</span>
                        </span>
                        <span>Réponse sous 24h</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                            <span class="material-symbols-outlined text-emerald-600 text-sm">check</span>
                        </span>
                        <span>Support dédié</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="bg-white/80 backdrop-blur-xl rounded-3xl p-8 md:p-10 shadow-[0_20px_60px_rgba(18,28,42,0.08)] border border-gray-100/50">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Demande d'accès</h2>
                    <p class="text-gray-500">Veuillez fournir vos informations pour soumettre votre demande.</p>
                </div>

                @if(session('success'))
                    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 text-emerald-700">
                        <span class="material-symbols-outlined">check_circle</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                        <div class="flex items-center gap-3 text-red-700 mb-2">
                            <span class="material-symbols-outlined">error</span>
                            <span class="font-semibold">Erreur</span>
                        </div>
                        <ul class="text-sm text-red-600 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('request-access.submit') }}" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Prénom</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined">person</span>
                                </span>
                                <input name="prenom" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Votre prénom" type="text" required/>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700 ml-1">Nom</label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined">badge</span>
                                </span>
                                <input name="nom" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all" placeholder="Votre nom" type="text" required/>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Email professionnel</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <span class="material-symbols-outlined">email</span>
                            </span>
                            <input name="email" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3.5 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all" placeholder="votre.email@entreprise.com" type="email" required/>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Département</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <span class="material-symbols-outlined">business</span>
                            </span>
                            <select name="departement" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-10 py-3.5 text-gray-800 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all appearance-none">
                                <option disabled selected value="">Sélectionner un département</option>
                                <option>Technologies de l'Information</option>
                                <option>Finance</option>
                                <option>Ressources Humaines</option>
                                <option>Opérations</option>
                                <option>Juridique</option>
                                <option>Marketing</option>
                                <option>Ventes</option>
                                <option>Ingénierie</option>
                                <option>Autre</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                <span class="material-symbols-outlined">expand_more</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700 ml-1">Motif de la demande</label>
                        <div class="relative group">
                            <span class="absolute left-4 top-4 text-gray-400">
                                <span class="material-symbols-outlined">description</span>
                            </span>
                            <textarea name="raison" class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-12 pr-4 py-3 text-gray-800 placeholder:text-gray-400 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all resize-none" placeholder="Décrivez brièvement pourquoi vous avez besoin d'accès..." rows="3" required></textarea>
                        </div>
                    </div>
                    
                    <div class="pt-2 space-y-4">
                        <button class="w-full py-4 bg-gradient-to-r from-primary to-primary-container text-white font-semibold rounded-xl shadow-[0_4px_16px_rgba(0,88,190,0.25)] hover:shadow-[0_6px_20px_rgba(0,88,190,0.3)] hover:scale-[1.01] active:scale-[0.99] transition-all" type="submit">
                            Soumettre la demande
                        </button>
                        <a class="flex items-center justify-center gap-2 w-full py-3 text-gray-500 font-medium hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-all" href="{{ route('login') }}">
                            <span class="material-symbols-outlined text-sm">arrow_back</span>
                            Retour à la connexion
                        </a>
                    </div>
                </form>
                
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">info</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 leading-relaxed">Les demandes sont généralement examinées sous <span class="font-semibold text-gray-700">24 heures ouvrables</span> par l'équipe administrative.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>