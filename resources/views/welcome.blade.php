<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'AssetFlow') }} | Gérez Votre Infrastructure IT</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary-fixed-dim": "#adc6ff",
                        "tertiary-container": "#b75b00",
                        "surface-container-high": "#dee9fc",
                        "surface-bright": "#f8f9ff",
                        "on-tertiary-container": "#fffbff",
                        "outline": "#727785",
                        "outline-variant": "#c2c6d6",
                        "error": "#ba1a1a",
                        "surface-tint": "#005ac2",
                        "on-surface-variant": "#424754",
                        "secondary-fixed": "#e9ddff",
                        "on-secondary-fixed-variant": "#5516be",
                        "surface-container-highest": "#d9e3f6",
                        "secondary-fixed-dim": "#d0bcff",
                        "tertiary-fixed-dim": "#ffb786",
                        "on-tertiary-fixed-variant": "#723600",
                        "on-surface": "#121c2a",
                        "inverse-on-surface": "#eaf1ff",
                        "inverse-surface": "#27313f",
                        "surface": "#f8f9ff",
                        "surface-container": "#e6eeff",
                        "on-tertiary": "#ffffff",
                        "background": "#f8f9ff",
                        "tertiary-fixed": "#ffdcc6",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "primary-fixed": "#d8e2ff",
                        "tertiary": "#924700",
                        "surface-container-low": "#eff4ff",
                        "secondary": "#6b38d4",
                        "inverse-primary": "#adc6ff",
                        "on-secondary": "#ffffff",
                        "primary-container": "#2170e4",
                        "secondary-container": "#8455ef",
                        "on-primary-fixed-variant": "#004395",
                        "on-secondary-container": "#fffbff",
                        "error-container": "#ffdad6",
                        "surface-variant": "#d9e3f6",
                        "surface-dim": "#d0dbed",
                        "on-error": "#ffffff",
                        "on-background": "#121c2a",
                        "on-tertiary-fixed": "#311400",
                        "primary": "#0058be",
                        "on-secondary-fixed": "#23005c",
                        "on-primary-fixed": "#001a42",
                        "on-error-container": "#93000a",
                        "on-primary-container": "#fefcff"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    fontFamily: {
                        headline: ["Inter"],
                        body: ["Inter"],
                        label: ["Inter"]
                    }
                },
            },
        }
    </script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background text-on-background antialiased overflow-x-hidden">
    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm dark:shadow-none font-['Inter'] antialiased tracking-tight">
        <nav class="flex justify-between items-center px-8 h-16 max-w-screen-2xl mx-auto">
            <div class="text-2xl font-bold tracking-tighter text-blue-700 dark:text-blue-500 flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'AssetFlow') }}" class="h-10 w-auto">
                <span class="hidden sm:inline">{{ config('app.name', 'AssetFlow') }}</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors" href="#features">Fonctionnalités</a>
                <a class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors" href="#solutions">Solutions</a>
                <a class="text-slate-600 dark:text-slate-400 hover:text-blue-600 transition-colors" href="#about">À propos</a>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:block text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer text-sm font-medium">
                        Tableau de bord
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:block text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer text-sm font-medium">
                        Connexion
                    </a>
                    <a href="{{ route('request-access') }}" class="bg-gradient-to-r from-primary to-primary-container text-white px-5 py-2.5 rounded-lg font-semibold text-sm hover:shadow-lg hover:shadow-primary/20 transition-all active:scale-95 duration-150 ease-in-out">
                        Demander l'accès
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main class="pt-16">
        <!-- Hero Section -->
        <section class="relative min-h-[870px] flex items-center overflow-hidden bg-surface">
            <!-- Background Decorative Elements -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <div class="absolute top-[-10%] right-[-5%] w-[60%] h-[80%] rounded-full bg-primary/5 blur-[120px]"></div>
                <div class="absolute bottom-[-10%] left-[-5%] w-[40%] h-[60%] rounded-full bg-secondary/5 blur-[100px]"></div>
            </div>
            <div class="container mx-auto px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8 max-w-2xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-surface-container text-primary text-xs font-bold uppercase tracking-widest">
                            <span class="flex h-2 w-2 rounded-full bg-primary animate-pulse"></span>
                            Gestion IT de Nouvelle Génération
                        </div>
                        <h1 class="text-5xl lg:text-7xl font-bold text-on-background leading-[1.1] tracking-tight">
                            Maîtrisez Votre <span class="text-primary italic">Infrastructure</span> IT
                        </h1>
                        <p class="text-xl text-on-surface-variant leading-relaxed">
                            Une plateforme unifiée pour gérer vos actifs, tickets et licences avec précision. Transformez le chaos en clarté structurelle avec AssetFlow.
                        </p>
                        <div class="flex flex-wrap gap-4 pt-4">
                            @auth
                                <a href="{{ route('admin.dashboard') }}" class="bg-gradient-to-r from-primary to-primary-container text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-primary/30 transition-all active:scale-95">
                                    Aller au Tableau de Bord
                                </a>
                            @else
                                <a href="{{ route('request-access') }}" class="bg-gradient-to-r from-primary to-primary-container text-white px-8 py-4 rounded-xl font-bold text-lg hover:shadow-xl hover:shadow-primary/30 transition-all active:scale-95">
                                    Demander l'accès
                                </a>
                                <a href="{{ route('login') }}" class="bg-surface-container-high text-on-surface px-8 py-4 rounded-xl font-bold text-lg hover:bg-surface-container-highest transition-all">
                                    Connexion
                                </a>
                            @endauth
                        </div>
                        <div class="flex items-center gap-6 pt-8">
                            <div class="flex -space-x-3">
                                <img class="h-10 w-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&h=100&fit=crop&crop=face" alt="User">
                                <img class="h-10 w-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop&crop=face" alt="User">
                                <img class="h-10 w-10 rounded-full border-2 border-white object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop&crop=face" alt="User">
                            </div>
                            <p class="text-sm text-on-surface-variant font-medium">Adopté par 500+ Équipes IT d'Entreprise</p>
                        </div>
                    </div>
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-primary/20 to-secondary/20 rounded-[2.5rem] blur-2xl group-hover:blur-3xl transition-all duration-500"></div>
                        <div class="relative bg-surface-container-lowest p-4 rounded-[2rem] shadow-2xl">
                            <div class="bg-gradient-to-br from-surface-container-low to-surface-container-high rounded-[1.5rem] p-8 shadow-inner">
                                <!-- Mock Dashboard Preview -->
                                <div class="space-y-4">
                                    <div class="flex items-center gap-4 mb-6">
                                        <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-8 w-auto">
                                        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">En Direct</span>
                                    </div>
                                    
                                    <!-- Stats Row -->
                                    <div class="grid grid-cols-3 gap-3 mb-6">
                                        <div class="bg-white p-4 rounded-xl">
                                            <div class="text-xs text-slate-500 uppercase font-bold">Actifs</div>
                                            <div class="text-2xl font-bold text-slate-800">1,284</div>
                                        </div>
                                        <div class="bg-white p-4 rounded-xl">
                                            <div class="text-xs text-slate-500 uppercase font-bold">Tickets</div>
                                            <div class="text-2xl font-bold text-slate-800">142</div>
                                        </div>
                                        <div class="bg-white p-4 rounded-xl">
                                            <div class="text-xs text-slate-500 uppercase font-bold">Licences</div>
                                            <div class="text-2xl font-bold text-slate-800">892</div>
                                        </div>
                                    </div>
                                    
                                    <!-- Chart Preview -->
                                    <div class="bg-white p-4 rounded-xl">
                                        <div class="text-sm font-bold text-slate-700 mb-3">Distribution des Actifs</div>
                                        <div class="flex items-end gap-2 h-24">
                                            <div class="flex-1 bg-blue-200 rounded-t h-[60%]"></div>
                                            <div class="flex-1 bg-blue-300 rounded-t h-[80%]"></div>
                                            <div class="flex-1 bg-blue-400 rounded-t h-[45%]"></div>
                                            <div class="flex-1 bg-blue-500 rounded-t h-[70%]"></div>
                                            <div class="flex-1 bg-blue-600 rounded-t h-[90%]"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Floating Metric Card -->
                        <div class="absolute -bottom-8 -left-8 bg-white p-6 rounded-2xl shadow-xl border border-outline-variant/10 max-w-[200px]">
                            <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">Efficacité en Direct</p>
                            <p class="text-3xl font-bold text-on-background">99.9%</p>
                            <div class="w-full bg-surface-container h-1.5 rounded-full mt-3 overflow-hidden">
                                <div class="bg-primary h-full w-[99.9%]"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Value Propositions - Bento Grid Style -->
        <section id="features" class="py-24 bg-background">
            <div class="container mx-auto px-8">
                <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                    <h2 class="text-4xl font-bold text-on-background tracking-tight">Contrôle Architecturale sur Chaque Nœud</h2>
                    <p class="text-lg text-on-surface-variant">Nous avons remplacé les tableurs désordonnés par un écosystème sophistiqué conçu pour les professionnels IT modernes.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <!-- Centralized Inventory -->
                    <div class="md:col-span-2 bg-surface-container-low p-10 rounded-3xl relative overflow-hidden group">
                        <div class="relative z-10 h-full flex flex-col justify-between">
                            <div>
                                <div class="h-14 w-14 bg-primary rounded-2xl flex items-center justify-center text-white mb-8 group-hover:scale-110 transition-transform duration-300">
                                    <span class="material-symbols-outlined text-3xl">inventory_2</span>
                                </div>
                                <h3 class="text-2xl font-bold text-on-background mb-4">Inventaire Centralisé</h3>
                                <p class="text-on-surface-variant leading-relaxed mb-6">
                                    Visibilité complète sur l'ensemble de votre parc matériel et logiciel. Une source unique de vérité pour tout, des serveurs aux appareils mobiles.
                                </p>
                            </div>
                            <div class="flex items-center gap-2 text-primary font-bold text-sm cursor-pointer hover:gap-3 transition-all">
                                EXPLORER LES ACTIFS <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </div>
                        </div>
                        <div class="absolute bottom-[-10%] right-[-5%] opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-symbols-outlined text-[12rem]">hub</span>
                        </div>
                    </div>
                    <!-- Smart Maintenance -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="h-12 w-12 bg-secondary/10 text-secondary rounded-xl flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-2xl">build</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Maintenance Intelligente</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Alertes prédictives et flux de travail automatisés de tickets qui détectent les problèmes avant qu'ils ne perturbent votre équipe.
                        </p>
                    </div>
                    <!-- License Compliance -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="h-12 w-12 bg-tertiary/10 text-tertiary rounded-xl flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-2xl">verified_user</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Conformité des Licences</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Éliminez les risques avec un suivi en temps réel de l'utilisation des licences, des dates d'expiration et de l'optimisation des dépenses logicielles.
                        </p>
                    </div>
                    <!-- Actionable Insights (Full width on small, tall on lg) -->
                    <div class="md:col-span-3 lg:col-span-4 bg-on-background text-white p-10 rounded-[2.5rem] mt-6 flex flex-col md:flex-row items-center gap-12 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary/20 to-transparent"></div>
                        <div class="relative z-10 flex-1 space-y-6">
                            <div class="inline-block px-3 py-1 rounded-full bg-white/10 text-primary-fixed-dim text-[10px] font-bold uppercase tracking-widest">Analytique Avancée</div>
                            <h3 class="text-3xl font-bold leading-tight">Informations Actionnables</h3>
                            <p class="text-slate-400 text-lg">
                                Plongez dans la santé de votre infrastructure avec des tableaux de bord de rapports personnalisés. Transformez des ensembles de données complexes en décisions stratégiques claires.
                            </p>
                            <a href="{{ route('request-access') }}" class="bg-white text-on-background px-6 py-3 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors inline-block">
                                Commencer
                            </a>
                        </div>
                        <div class="relative z-10 w-full md:w-1/2 h-64 bg-slate-800 rounded-2xl overflow-hidden shadow-2xl border border-white/5 flex items-center justify-center">
                            <div class="text-center">
                                <span class="material-symbols-outlined text-[4rem] text-primary/50">assessment</span>
                                <p class="text-slate-500 text-sm mt-2">Aperçu du Tableau de Bord des Rapports</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Social Proof / Stats -->
        <section class="py-20 border-y border-outline-variant/10">
            <div class="container mx-auto px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-12 text-center">
                    <div>
                        <p class="text-5xl font-bold text-on-background mb-2">2M+</p>
                        <p class="text-xs font-bold text-primary uppercase tracking-widest">Actifs Gérés</p>
                    </div>
                    <div>
                        <p class="text-5xl font-bold text-on-background mb-2">99.9%</p>
                        <p class="text-xs font-bold text-primary uppercase tracking-widest">Disponibilité Garantie</p>
                    </div>
                    <div>
                        <p class="text-5xl font-bold text-on-background mb-2">150%</p>
                        <p class="text-xs font-bold text-primary uppercase tracking-widest">ROI la 1ère Année</p>
                    </div>
                    <div>
                        <p class="text-5xl font-bold text-on-background mb-2">24/7</p>
                        <p class="text-xs font-bold text-primary uppercase tracking-widest">Support Expert</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Solutions Section -->
        <section id="solutions" class="py-24 bg-surface">
            <div class="container mx-auto px-8">
                <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
                    <h2 class="text-4xl font-bold text-on-background tracking-tight">Suite Complète de Gestion IT</h2>
                    <p class="text-lg text-on-surface-variant">Tout ce dont vous avez besoin pour gérer votre infrastructure IT sur une plateforme puissante.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Feature Card 1 -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 hover:shadow-xl transition-all duration-300 group">
                        <div class="h-14 w-14 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">devices</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Suivi du Matériel</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Suivez les ordinateurs, serveurs, équipements réseau et périphériques avec des spécifications détaillées et surveillance de l'état.
                        </p>
                    </div>
                    
                    <!-- Feature Card 2 -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 hover:shadow-xl transition-all duration-300 group">
                        <div class="h-14 w-14 bg-purple-100 rounded-2xl flex items-center justify-center text-purple-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">confirmation_number</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Gestion des Tickets</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Système de tickets de support simplifié avec affectation, suivi et flux de travail de résolution pour un service IT efficace.
                        </p>
                    </div>
                    
                    <!-- Feature Card 3 -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 hover:shadow-xl transition-all duration-300 group">
                        <div class="h-14 w-14 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">vpn_key</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Gestion des Licences</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Surveillez les licences logicielles, suivez les dates d'expiration et assurezvous de la conformité dans toute votre organisation.
                        </p>
                    </div>
                    
                    <!-- Feature Card 4 -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 hover:shadow-xl transition-all duration-300 group">
                        <div class="h-14 w-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">location_on</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Suivi des Localisations</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Organisez les actifs par localisation, bâtiment, étage et salle. Suivez les mouvements et maintenez des dossiers précis.
                        </p>
                    </div>
                    
                    <!-- Feature Card 5 -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 hover:shadow-xl transition-all duration-300 group">
                        <div class="h-14 w-14 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">handshake</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Gestion des Prestataires</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Gérez les fournisseurs de services, suivez les contrats et entretenez des relations avec tous vos fournisseurs IT.
                        </p>
                    </div>
                    
                    <!-- Feature Card 6 -->
                    <div class="bg-white p-8 rounded-3xl border border-outline-variant/10 hover:shadow-xl transition-all duration-300 group">
                        <div class="h-14 w-14 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 mb-6 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-3xl">build</span>
                        </div>
                        <h3 class="text-xl font-bold text-on-background mb-3">Planification de la Maintenance</h3>
                        <p class="text-sm text-on-surface-variant leading-relaxed">
                            Planifiez la maintenance préventive, suivez l'historique des services et assureszvous des performances optimales de tous les actifs.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="about" class="py-24 container mx-auto px-8">
            <div class="bg-gradient-to-br from-primary to-primary-container rounded-[3rem] p-12 lg:p-20 text-center text-white relative overflow-hidden shadow-2xl shadow-primary/20">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/3 translate-y-1/3"></div>
                </div>
                <div class="relative z-10 max-w-3xl mx-auto space-y-8">
                    <h2 class="text-4xl lg:text-5xl font-bold leading-tight tracking-tight">Prêt à architecter votre infrastructure d'entreprise?</h2>
                    <p class="text-white/80 text-xl">Rejoignez les équipes IT les plus innovantes et rationalisez la gestion de vos actifs dès aujourd'hui.</p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="bg-white text-primary px-10 py-5 rounded-2xl font-bold text-lg hover:scale-105 transition-transform">
                                Aller au Tableau de Bord
                            </a>
                        @else
                            <a href="{{ route('request-access') }}" class="bg-white text-primary px-10 py-5 rounded-2xl font-bold text-lg hover:scale-105 transition-transform">
                                Demander Votre Accès
                            </a>
                            <a href="{{ route('contact') }}" class="bg-primary-container/50 backdrop-blur-sm border border-white/20 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-primary-container transition-colors">
                                Contacter le Support
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full py-12 px-8 bg-slate-50 dark:bg-slate-950 border-t border-slate-200/50 dark:border-slate-800/50">
        <div class="max-w-screen-2xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="space-y-2 text-center md:text-left">
                <div class="font-bold text-slate-900 dark:text-white text-xl flex items-center gap-2">
                    <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-8 w-auto">
                    AssetFlow
                </div>
                <p class="text-sm font-['Inter'] text-slate-500 dark:text-slate-400">© 2024 AssetFlow Gestion IT. Tous droits réservés.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-8">
                <a class="text-sm font-['Inter'] text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer hover:underline" href="#">Politique de Confidentialité</a>
                <a class="text-sm font-['Inter'] text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer hover:underline" href="#">Conditions d'Utilisation</a>
                <a class="text-sm font-['Inter'] text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer hover:underline" href="#">Sécurité</a>
                <a class="text-sm font-['Inter'] text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors cursor-pointer hover:underline" href="{{ route('contact') }}">Contacter le Support</a>
            </div>
            <div class="flex gap-4">
                <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 cursor-pointer hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-lg">public</span>
                </div>
                <div class="h-10 w-10 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 cursor-pointer hover:bg-primary hover:text-white transition-all">
                    <span class="material-symbols-outlined text-lg">mail</span>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
