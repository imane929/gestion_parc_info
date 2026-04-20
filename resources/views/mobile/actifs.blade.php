@php
$actifs = \App\Models\ActifInformatique::with(['localisation', 'utilisateurAffecte'])
    ->orderBy('created_at', 'desc')
    ->paginate(20);

$typeIcons = [
    'pc' => 'laptop_mac',
    'imprimante' => 'print',
    'serveur' => 'dns',
    'reseau' => 'router',
    'peripherique' => 'keyboard',
    'mobile' => 'smartphone',
    'autre' => 'devices',
];

$etatColors = [
    'neuf' => 'bg-green-50 text-green-700 border-green-200',
    'bon' => 'bg-blue-50 text-blue-700 border-blue-200',
    'moyen' => 'bg-amber-50 text-amber-700 border-amber-200',
    'mauvais' => 'bg-orange-50 text-orange-700 border-orange-200',
    'hors_service' => 'bg-red-50 text-red-700 border-red-200',
];
@endphp

@extends('layouts.mobile')

@section('title', 'Gestion des Actifs')

<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 flex items-center justify-between px-6 h-16 glass-header shadow-sm">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-slate-100 transition-colors">
            <span class="material-symbols-outlined text-slate-700">arrow_back</span>
        </a>
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-6 w-auto">
        </a>
    </div>
    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-xs">
        {{ auth()->user()->initials }}
    </div>
</header>

<main class="pt-20 px-4 max-w-4xl mx-auto">
    <!-- Section Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-slate-900">Gestion des Actifs</h2>
            @can('actifs.create')
            <a href="{{ route('admin.actifs.create') }}" class="bg-primary text-white flex items-center gap-2 px-5 py-2.5 rounded-full shadow-md hover:shadow-lg active:scale-95 transition-all">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span class="font-semibold text-sm">Nouvel Actif</span>
            </a>
            @endcan
        </div>
        
        <!-- Search Bar -->
        <form action="{{ route('admin.actifs.index') }}" method="GET" class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                <span class="material-symbols-outlined text-slate-400/60 text-[22px]">search</span>
            </div>
            <input class="w-full bg-white border border-slate-200/30 rounded-2xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-primary/10 focus:border-primary/50 transition-all text-sm outline-none shadow-sm" name="search" placeholder="Rechercher par nom, code ou utilisateur..." type="text" value="{{ request('search') }}"/>
            <div class="absolute inset-y-0 right-4 flex items-center">
                <a href="{{ route('admin.actifs.index') }}" class="material-symbols-outlined text-slate-400/60 text-[20px] cursor-pointer hover:text-primary transition-colors">tune</a>
            </div>
        </form>

        <!-- Filter Pills -->
        <div class="flex gap-2 mt-4 overflow-x-auto no-scrollbar pb-2">
            <a href="{{ route('admin.actifs.index') }}" class="px-4 py-2 rounded-full text-xs font-bold {{ !request('type') ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors whitespace-nowrap">
                Tous
            </a>
            @foreach(['pc', 'imprimante', 'serveur', 'mobile'] as $type)
            <a href="{{ route('admin.actifs.index', ['type' => $type]) }}" class="px-4 py-2 rounded-full text-xs font-bold {{ request('type') === $type ? 'bg-primary text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }} transition-colors whitespace-nowrap capitalize">
                {{ $type === 'imprimante' ? 'Imprimantes' : ucfirst($type) }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Asset Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($actifs as $actif)
        <a href="{{ route('admin.actifs.show', $actif->id) }}" class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100/20 flex flex-col gap-5 hover:border-primary/30 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-[10px] font-bold tracking-widest text-slate-400 uppercase mb-1">Code Inventaire</p>
                    <h3 class="font-bold text-lg text-primary group-hover:text-primary/80 transition-colors">{{ $actif->code_inventaire }}</h3>
                </div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold px-3 py-1 rounded-full border {{ $etatColors[$actif->etat] ?? 'bg-slate-50 text-slate-600' }}">
                    @if($actif->etat === 'neuf')
                        <span class="w-1.5 h-1.5 rounded-full bg-green-600 animate-pulse"></span>
                    @elseif($actif->etat === 'hors_service')
                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                    @endif
                    {{ strtoupper($actif->etat) }}
                </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">{{ $typeIcons[$actif->type] ?? 'devices' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-medium">Modèle</span>
                        <span class="text-sm font-semibold truncate">{{ $actif->marque }} {{ $actif->modele }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-secondary/5 flex items-center justify-center">
                        @if($actif->utilisateurAffecte)
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-secondary to-purple-700 flex items-center justify-center text-white text-xs font-bold">
                                {{ substr($actif->utilisateurAffecte->prenom, 0, 1) }}{{ substr($actif->utilisateurAffecte->nom, 0, 1) }}
                            </div>
                        @else
                            <span class="material-symbols-outlined text-secondary text-[20px]">person_off</span>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-slate-400 font-medium">Assigné à</span>
                        <span class="text-sm font-semibold truncate {{ !$actif->utilisateurAffecte ? 'text-slate-400 italic' : '' }}">
                            {{ $actif->utilisateurAffecte ? $actif->utilisateurAffecte->full_name : 'Non assigné' }}
                        </span>
                    </div>
                </div>
            </div>

            @if($actif->localisation)
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <span>{{ $actif->localisation->site }} - {{ $actif->localisation->batiment }} - {{ $actif->localisation->bureau }}</span>
            </div>
            @endif
        </a>
        @empty
        <div class="col-span-2 text-center py-12">
            <span class="material-symbols-outlined text-6xl text-slate-200">inventory_2</span>
            <p class="text-slate-500 mt-4">Aucun actif trouvé</p>
            @can('actifs.create')
            <a href="{{ route('admin.actifs.create') }}" class="inline-flex items-center gap-2 mt-4 text-primary font-semibold">
                <span class="material-symbols-outlined">add</span>
                Ajouter un nouvel actif
            </a>
            @endcan
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($actifs->hasPages())
    <div class="mt-12 mb-16 flex justify-center">
        <div class="flex items-center gap-2">
            @if($actifs->onFirstPage())
                <span class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined">chevron_left</span>
                </span>
            @else
                <a href="{{ $actifs->previousPageUrl() }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            @endif
            
            <span class="px-4 py-2 text-sm font-semibold text-slate-600">
                {{ $actifs->currentPage() }} / {{ $actifs->lastPage() }}
            </span>
            
            @if($actifs->hasMorePages())
                <a href="{{ $actifs->nextPageUrl() }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_right</span>
                </a>
            @else
                <span class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined">chevron_right</span>
                </span>
            @endif
        </div>
    </div>
    @endif
</main>

<!-- BottomNavBar -->
<nav class="fixed bottom-0 w-full z-50 flex justify-around items-center h-16 pb-safe px-2 bg-white/90 backdrop-blur-lg border-t border-slate-100 shadow-xl rounded-t-3xl">
    <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">dashboard</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Home</span>
    </a>
    <a href="{{ route('admin.actifs.index') }}" class="flex flex-col items-center justify-center relative w-16">
        <div class="absolute -top-1 w-1 h-1 rounded-full bg-primary"></div>
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
        <span class="font-inter text-[10px] font-bold text-primary">Assets</span>
    </a>
    <a href="{{ route('admin.tickets.index') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">confirmation_number</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Tickets</span>
    </a>
    <a href="{{ route('admin.logiciels.index') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">terminal</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Soft</span>
    </a>
    <a href="{{ route('admin.profile.show') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">settings</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Config</span>
    </a>
</nav>
