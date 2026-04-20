@php
$user = auth()->user();
$totalActifs = $stats['total_actifs'] ?? 0;
$ticketsEnCours = $stats['tickets_en_cours'] ?? 0;
$licencesExpirant = $stats['licences_expirant'] ?? 0;
$contratsExpirant = $stats['contrats_expirant'] ?? 0;

$total = $totalActifs ?: 1;
$neuf = $actifsParEtat['neuf'] ?? 0;
$bon = $actifsParEtat['bon'] ?? 0;
$moyen = $actifsParEtat['moyen'] ?? 0;
$mauvais = $actifsParEtat['mauvais'] ?? 0;
$horsService = $actifsParEtat['hors_service'] ?? 0;
@endphp

@extends('layouts.mobile')

@section('title', 'Dashboard')

@php
$priorityColors = [
    'basse' => 'bg-slate-100 text-slate-600',
    'moyenne' => 'bg-blue-50 text-blue-600',
    'haute' => 'bg-orange-50 text-orange-600',
    'urgente' => 'bg-red-50 text-red-600',
];

$ticketStatusColors = [
    'ouvert' => 'bg-blue-50 text-blue-600 border-l-blue-500',
    'en_cours' => 'bg-purple-50 text-purple-600 border-l-purple-500',
    'en_attente' => 'bg-amber-50 text-amber-600 border-l-amber-500',
    'resolu' => 'bg-green-50 text-green-600 border-l-green-500',
    'ferme' => 'bg-slate-100 text-slate-600 border-l-slate-400',
];
@endphp

<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 flex items-center justify-between px-6 h-16 glass-header shadow-sm">
    <div class="flex items-center gap-4">
        <button class="p-2 -ml-2 rounded-full hover:bg-slate-100 transition-colors">
            <span class="material-symbols-outlined text-slate-700">menu</span>
        </button>
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="AssetFlow" class="h-6 w-auto">
        </a>
    </div>
    <div class="w-9 h-9 rounded-full ring-2 ring-white shadow-sm overflow-hidden bg-slate-200">
        @if($user->photo_url)
            <img alt="user_profile_avatar" class="w-full h-full object-cover" src="{{ $user->photo_url }}">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary to-blue-700 text-white font-bold text-sm">
                {{ $user->initials }}
            </div>
        @endif
    </div>
</header>

<main class="pt-20 pb-28 px-6 max-w-md mx-auto">
    <!-- Welcome Banner -->
    <section class="mb-8">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-primary to-blue-700 p-6 text-white shadow-lg">
            <div class="relative z-10">
                <h2 class="text-2xl font-bold tracking-tight mb-1">Bienvenue, {{ $user->prenom }}</h2>
                <p class="text-sm font-medium text-blue-50">L'infrastructure est stable aujourd'hui.</p>
            </div>
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full"></div>
        </div>
    </section>

    <!-- Quick Stats Bento Grid -->
    <section class="grid grid-cols-2 gap-4 mb-8">
        <a href="{{ route('mobile.actifs.index') }}" class="bg-surface p-5 rounded-2xl shadow-soft flex flex-col justify-between h-36 border border-slate-100 hover:border-primary/20 transition-all">
            <div class="flex justify-between items-start">
                <div class="p-2 rounded-lg bg-blue-50">
                    <span class="material-symbols-outlined text-primary text-xl">inventory_2</span>
                </div>
                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Total</span>
            </div>
            <div>
                <div class="text-3xl font-bold text-on-surface">{{ $totalActifs }}</div>
                <div class="text-xs text-on-surface-variant font-medium">Assets gérés</div>
            </div>
        </a>
        
        <a href="{{ route('mobile.tickets.index') }}" class="bg-surface p-5 rounded-2xl shadow-soft flex flex-col justify-between h-36 border border-slate-100 hover:border-secondary/20 transition-all">
            <div class="flex justify-between items-start">
                <div class="p-2 rounded-lg bg-purple-50">
                    <span class="material-symbols-outlined text-secondary text-xl">confirmation_number</span>
                </div>
                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Tickets</span>
            </div>
            <div>
                <div class="text-3xl font-bold text-on-surface">{{ $ticketsEnCours }}</div>
                <div class="text-xs text-on-surface-variant font-medium">En attente</div>
            </div>
        </a>
        
        <a href="{{ route('admin.licences.index') }}" class="bg-surface p-5 rounded-2xl shadow-soft flex flex-col justify-between h-36 border border-slate-100 transition-all">
            <div class="flex justify-between items-start">
                <div class="p-2 rounded-lg bg-amber-50">
                    <span class="material-symbols-outlined text-amber-500 text-xl">key</span>
                </div>
                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Licences</span>
            </div>
            <div>
                <div class="text-3xl font-bold text-on-surface">{{ $licencesExpirant }}</div>
                <div class="text-xs text-on-surface-variant font-medium">Expirant</div>
            </div>
        </a>
        
        <a href="{{ route('admin.contrats.index') }}" class="bg-surface p-5 rounded-2xl shadow-soft flex flex-col justify-between h-36 border border-slate-100 transition-all">
            <div class="flex justify-between items-start">
                <div class="p-2 rounded-lg bg-red-50">
                    <span class="material-symbols-outlined text-red-500 text-xl">description</span>
                </div>
                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Contrats</span>
            </div>
            <div>
                <div class="text-3xl font-bold text-on-surface">{{ $contratsExpirant }}</div>
                <div class="text-xs text-on-surface-variant font-medium">À renouveler</div>
            </div>
        </a>
    </section>

    <!-- Asset Status Doughnut Chart Section -->
    <section class="mb-8">
        <div class="flex items-center justify-between mb-4 px-1">
            <h3 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">État du Parc</h3>
            <a href="{{ route('mobile.actifs.index') }}" class="material-symbols-outlined text-slate-400 text-sm hover:text-primary">info</a>
        </div>
        <div class="bg-surface p-6 rounded-2xl shadow-soft border border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-8">
            <div class="relative w-36 h-36 flex items-center justify-center">
                <svg class="w-full h-full transform -rotate-90">
                    @php
                        $circumference = 2 * M_PI * 52;
                        $neufOffset = $circumference * (1 - ($neuf / $total));
                        $bonOffset = $circumference * (1 - (($bon + $neuf) / $total));
                        $moyenOffset = $circumference * (1 - (($bon + $neuf + $moyen) / $total));
                        $mauvaisOffset = $circumference * (1 - (($bon + $neuf + $moyen + $mauvais) / $total));
                    @endphp
                    <circle class="text-slate-100" cx="72" cy="72" fill="transparent" r="52" stroke="currentColor" stroke-width="12"></circle>
                    <circle class="text-green-500" cx="72" cy="72" fill="transparent" r="52" stroke="currentColor" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $neufOffset }}" stroke-linecap="round" stroke-width="12"></circle>
                    <circle class="text-primary" cx="72" cy="72" fill="transparent" r="52" stroke="currentColor" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $bonOffset }}" stroke-linecap="round" stroke-width="12"></circle>
                    <circle class="text-amber-500" cx="72" cy="72" fill="transparent" r="52" stroke="currentColor" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $moyenOffset }}" stroke-linecap="round" stroke-width="12"></circle>
                    <circle class="text-red-500" cx="72" cy="72" fill="transparent" r="52" stroke="currentColor" stroke-dasharray="{{ $circumference }}" stroke-dashoffset="{{ $mauvaisOffset }}" stroke-linecap="round" stroke-width="12"></circle>
                </svg>
                <div class="absolute flex flex-col items-center">
                    <span class="text-2xl font-bold text-on-surface">{{ $totalActifs }}</span>
                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total</span>
                </div>
            </div>
            <div class="grid grid-cols-2 sm:flex sm:flex-col gap-4 w-full sm:w-auto">
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500 ring-4 ring-green-50"></div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-on-surface">Neuf</span>
                        <span class="text-[10px] text-slate-400 font-medium">{{ $neuf }} ({{ $totalActifs ? round($neuf / $totalActifs * 100) : 0 }}%)</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-primary ring-4 ring-blue-50"></div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-on-surface">Bon</span>
                        <span class="text-[10px] text-slate-400 font-medium">{{ $bon }} ({{ $totalActifs ? round($bon / $totalActifs * 100) : 0 }}%)</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-500 ring-4 ring-amber-50"></div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-on-surface">Moyen</span>
                        <span class="text-[10px] text-slate-400 font-medium">{{ $moyen }} ({{ $totalActifs ? round($moyen / $totalActifs * 100) : 0 }}%)</span>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-2.5 h-2.5 rounded-full bg-red-500 ring-4 ring-red-50"></div>
                    <div class="flex flex-col">
                        <span class="text-xs font-bold text-on-surface">HS</span>
                        <span class="text-[10px] text-slate-400 font-medium">{{ $horsService }} ({{ $totalActifs ? round($horsService / $totalActifs * 100) : 0 }}%)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Tickets List -->
    <section>
        <div class="flex justify-between items-end mb-4 px-1">
            <h3 class="text-xs font-bold uppercase tracking-widest text-on-surface-variant">Tickets Récents</h3>
            <a href="{{ route('mobile.tickets.index') }}" class="text-xs font-bold text-primary hover:underline">Voir tout</a>
        </div>
        <div class="space-y-4">
            @forelse($ticketsRecents as $ticket)
            <a href="{{ route('mobile.tickets.show', $ticket->id) }}" class="bg-surface p-4 rounded-xl shadow-soft border-l-4 {{ $ticketStatusColors[$ticket->statut] ?? 'border-slate-300' }} flex items-center justify-between hover:bg-slate-50 transition-colors cursor-pointer group">
                <div>
                    <p class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors">{{ $ticket->sujet }}</p>
                    <p class="text-[11px] text-on-surface-variant mt-0.5">{{ $ticket->numero }} • {{ $ticket->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-2 px-2 py-1 rounded-lg {{ $priorityColors[$ticket->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                    @if($ticket->priorite === 'urgente')
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    @endif
                    <span class="text-[10px] font-bold uppercase tracking-tight">{{ $ticket->priorite }}</span>
                </div>
            </a>
            @empty
            <div class="bg-surface p-6 rounded-xl shadow-soft text-center">
                <span class="material-symbols-outlined text-4xl text-slate-300">check_circle</span>
                <p class="text-sm text-slate-500 mt-2">Aucun ticket récent</p>
            </div>
            @endforelse
        </div>
    </section>
</main>

<!-- BottomNavBar -->
<nav class="fixed bottom-0 w-full z-50 flex justify-around items-center h-18 pb-safe px-4 bg-white/90 backdrop-blur-md border-t border-slate-100 shadow-[0_-10px_30px_rgba(0,0,0,0.03)]">
    <a href="{{ route('mobile.dashboard') }}" class="flex flex-col items-center justify-center gap-1 w-14 h-full relative group">
        <div class="absolute -top-0.5 left-1/2 -translate-x-1/2 w-8 h-1 bg-primary rounded-full opacity-100 transition-opacity"></div>
        <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">dashboard</span>
        <span class="text-[10px] font-bold text-primary">Accueil</span>
    </a>
    <a href="{{ route('mobile.actifs.index') }}" class="flex flex-col items-center justify-center gap-1 w-14 h-full text-slate-400 hover:text-primary transition-colors">
        <span class="material-symbols-outlined">inventory_2</span>
        <span class="text-[10px] font-bold">Assets</span>
    </a>
    <a href="{{ route('mobile.tickets.index') }}" class="flex flex-col items-center justify-center gap-1 w-14 h-full text-slate-400 hover:text-primary transition-colors">
        <span class="material-symbols-outlined">confirmation_number</span>
        <span class="text-[10px] font-bold">Tickets</span>
    </a>
    <a href="{{ route('logiciels.index') }}" class="flex flex-col items-center justify-center gap-1 w-14 h-full text-slate-400 hover:text-primary transition-colors">
        <span class="material-symbols-outlined">terminal</span>
        <span class="text-[10px] font-bold">Soft</span>
    </a>
    <a href="{{ route('admin.profile.show') }}" class="flex flex-col items-center justify-center gap-1 w-14 h-full text-slate-400 hover:text-primary transition-colors">
        <span class="material-symbols-outlined">settings</span>
        <span class="text-[10px] font-bold">Param.</span>
    </a>
</nav>
