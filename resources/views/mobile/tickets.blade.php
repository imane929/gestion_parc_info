@php
$priorityColors = [
    'basse' => 'bg-slate-100 text-slate-600',
    'moyenne' => 'bg-blue-50 text-blue-600',
    'haute' => 'bg-orange-50 text-orange-600',
    'urgente' => 'bg-red-50 text-red-600',
];

$statusColors = [
    'ouvert' => 'bg-blue-50 text-blue-600 border border-blue-200',
    'en_cours' => 'bg-purple-50 text-purple-600 border border-purple-200',
    'en_attente' => 'bg-amber-50 text-amber-600 border border-amber-200',
    'resolu' => 'bg-green-50 text-green-600 border border-green-200',
    'ferme' => 'bg-slate-100 text-slate-600 border border-slate-200',
];

$statusFilters = [
    'all' => 'Tous',
    'ouvert' => 'Ouverts',
    'en_cours' => 'En Cours',
    'en_attente' => 'En Attente',
    'resolu' => 'Résolus',
    'ferme' => 'Fermés',
];

$currentStatut = request('statut', 'all');
@endphp

@extends('layouts.mobile')

@section('title', 'Tickets')

<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 flex items-center justify-between px-6 h-16 glass-header shadow-sm">
    <div class="flex items-center gap-3">
        <a href="{{ route('mobile.dashboard') }}" class="p-2 -ml-2 rounded-full hover:bg-slate-100 transition-colors">
            <span class="material-symbols-outlined text-slate-700">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold text-primary font-inter tracking-tight">Tickets</h1>
    </div>
    @can('tickets.create')
    <a href="{{ route('tickets.create') }}" class="bg-primary text-white flex items-center gap-2 px-4 py-2 rounded-full shadow-md hover:shadow-lg transition-all">
        <span class="material-symbols-outlined text-[18px]">add</span>
        <span class="font-semibold text-xs">Nouveau</span>
    </a>
    @endcan
</header>

<main class="pt-20 px-4 max-w-4xl mx-auto">
    <!-- Search Bar -->
    <form action="{{ route('mobile.tickets.index') }}" method="GET" class="mb-6">
        <div class="relative group">
            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none transition-colors group-focus-within:text-primary">
                <span class="material-symbols-outlined text-slate-400 text-xl">search</span>
            </div>
            <input class="w-full bg-white border border-slate-200/30 rounded-2xl py-4 pl-12 pr-4 focus:ring-4 focus:ring-primary/10 focus:border-primary/50 transition-all text-sm outline-none shadow-sm" name="search" placeholder="Rechercher un ticket..." type="text" value="{{ request('search') }}"/>
        </div>
    </form>

    <!-- Status Tabs -->
    <div class="flex gap-2 mb-6 overflow-x-auto no-scrollbar pb-2">
        @foreach($statusFilters as $key => $label)
        <a href="{{ route('mobile.tickets.index', $key === 'all' ? [] : ['statut' => $key]) }}" 
           class="px-4 py-2 rounded-full text-xs font-bold whitespace-nowrap transition-colors {{ $currentStatut === $key ? 'bg-primary text-white shadow-md' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    <!-- Tickets List -->
    <div class="space-y-4 pb-8">
        @forelse($tickets as $ticket)
        <a href="{{ route('mobile.tickets.show', $ticket->id) }}" class="block bg-white p-5 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md hover:border-primary/20 transition-all">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <span class="text-xs font-bold text-primary">{{ $ticket->numero }}</span>
                    <h3 class="font-bold text-slate-900 mt-1">{{ $ticket->sujet }}</h3>
                </div>
                <div class="flex flex-col items-end gap-2">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $priorityColors[$ticket->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                        {{ $ticket->priorite }}
                    </span>
                    @if($ticket->priorite === 'urgente')
                        <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center gap-2 text-xs text-slate-500 mb-3">
                <span class="material-symbols-outlined text-sm">schedule</span>
                <span>{{ $ticket->created_at->diffForHumans() }}</span>
                @if($ticket->actif)
                <span class="mx-1">•</span>
                <span class="material-symbols-outlined text-sm">inventory_2</span>
                <span class="truncate max-w-[120px]">{{ $ticket->actif->code_inventaire }}</span>
                @endif
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase border {{ $statusColors[$ticket->statut] ?? 'bg-slate-100 text-slate-600 border-slate-200' }}">
                        {{ str_replace('_', ' ', $ticket->statut) }}
                    </span>
                </div>
                
                @if($ticket->assigneA)
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-gradient-to-br from-secondary to-purple-700 flex items-center justify-center text-white text-[10px] font-bold">
                        {{ substr($ticket->assigneA->prenom, 0, 1) }}{{ substr($ticket->assigneA->nom, 0, 1) }}
                    </div>
                    <span class="text-xs text-slate-600">{{ $ticket->assigneA->prenom }}</span>
                </div>
                @else
                <span class="text-xs text-slate-400 italic">Non assigné</span>
                @endif
            </div>
        </a>
        @empty
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-slate-200">confirmation_number</span>
            <p class="text-slate-500 mt-4">Aucun ticket trouvé</p>
            @can('tickets.create')
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 mt-4 text-primary font-semibold">
                <span class="material-symbols-outlined">add</span>
                Créer un nouveau ticket
            </a>
            @endcan
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($tickets->hasPages())
    <div class="flex justify-center pb-8">
        <div class="flex items-center gap-2">
            @if($tickets->onFirstPage())
                <span class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined">chevron_left</span>
                </span>
            @else
                <a href="{{ $tickets->previousPageUrl() }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-colors">
                    <span class="material-symbols-outlined">chevron_left</span>
                </a>
            @endif
            
            <span class="px-4 py-2 text-sm font-semibold text-slate-600">
                {{ $tickets->currentPage() }} / {{ $tickets->lastPage() }}
            </span>
            
            @if($tickets->hasMorePages())
                <a href="{{ $tickets->nextPageUrl() }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-600 hover:bg-primary hover:text-white hover:border-primary transition-colors">
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
    <a href="{{ route('mobile.dashboard') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">dashboard</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Home</span>
    </a>
    <a href="{{ route('mobile.actifs.index') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">inventory_2</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Assets</span>
    </a>
    <a href="{{ route('mobile.tickets.index') }}" class="flex flex-col items-center justify-center relative w-16">
        <div class="absolute -top-1 w-1 h-1 rounded-full bg-primary"></div>
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">confirmation_number</span>
        <span class="font-inter text-[10px] font-bold text-primary">Tickets</span>
    </a>
    <a href="{{ route('logiciels.index') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">terminal</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Soft</span>
    </a>
    <a href="{{ route('admin.profile.show') }}" class="flex flex-col items-center justify-center text-slate-400 group cursor-pointer w-16 hover:text-primary transition-colors">
        <span class="material-symbols-outlined group-hover:text-primary transition-colors">settings</span>
        <span class="font-inter text-[10px] font-medium group-hover:text-primary transition-colors">Config</span>
    </a>
</nav>
