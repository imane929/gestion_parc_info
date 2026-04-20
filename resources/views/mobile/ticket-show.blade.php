@php
$ticket = \App\Models\TicketMaintenance::with(['actif', 'createur', 'assigneA', 'interventions', 'commentaires'])
    ->findOrFail($id);

$priorityColors = [
    'basse' => 'bg-slate-100 text-slate-600',
    'moyenne' => 'bg-blue-50 text-blue-600',
    'haute' => 'bg-orange-50 text-orange-600',
    'urgente' => 'bg-red-50 text-red-600',
];

$statusColors = [
    'ouvert' => 'bg-blue-100 text-blue-700 border-blue-200',
    'en_cours' => 'bg-purple-100 text-purple-700 border-purple-200',
    'en_attente' => 'bg-amber-100 text-amber-700 border-amber-200',
    'resolu' => 'bg-green-100 text-green-700 border-green-200',
    'ferme' => 'bg-slate-100 text-slate-600 border-slate-200',
];

$typeIcons = [
    'pc' => 'laptop_mac',
    'imprimante' => 'print',
    'serveur' => 'dns',
    'reseau' => 'router',
    'peripherique' => 'keyboard',
    'mobile' => 'smartphone',
    'autre' => 'devices',
];
@endphp

@extends('layouts.mobile')

@section('title', 'Ticket #' . $ticket->numero)

<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 flex items-center justify-between px-6 h-16 glass-header shadow-sm">
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.tickets.index') }}" class="p-2 -ml-2 rounded-full hover:bg-slate-100 transition-colors">
            <span class="material-symbols-outlined text-slate-700">arrow_back</span>
        </a>
        <h1 class="font-inter text-lg font-bold text-slate-900">Ticket #{{ $ticket->numero }}</h1>
    </div>
    <div class="flex items-center gap-2">
        <button class="p-2 rounded-full hover:bg-slate-100 transition-colors">
            <span class="material-symbols-outlined text-slate-600">more_vert</span>
        </button>
        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-xs">
            {{ auth()->user()->initials }}
        </div>
    </div>
</header>

<main class="pt-20 pb-28 px-4 max-w-lg mx-auto">
    <!-- Ticket Header Section -->
    <section class="mb-6 px-2">
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <span class="text-slate-400 font-medium text-xs tracking-wider">{{ $ticket->numero }}</span>
            <div class="flex gap-2">
                <span class="flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest border {{ $priorityColors[$ticket->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                    @if($ticket->priorite === 'urgente')
                        <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    @endif
                    {{ $ticket->priorite }}
                </span>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-widest border {{ $statusColors[$ticket->statut] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ str_replace('_', ' ', $ticket->statut) }}
                </span>
            </div>
        </div>
        <h2 class="text-2xl font-black text-slate-900 mb-3 leading-tight">{{ $ticket->sujet }}</h2>
        <p class="text-slate-500 text-sm flex items-center gap-1.5">
            <span class="material-symbols-outlined text-base">schedule</span>
            Signalé {{ $ticket->created_at->diffForHumans() }} par {{ $ticket->createur->full_name ?? 'System' }}
        </p>
    </section>

    <!-- Bento Grid Layout for Details -->
    <div class="space-y-4">
        <!-- Description Card -->
        <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black tracking-[0.1em] uppercase text-slate-400/70 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-base">description</span>
                Description
            </h3>
            <p class="text-slate-700 leading-relaxed text-[15px]">
                {{ $ticket->description }}
            </p>
        </div>

        <!-- Asset Info Card -->
        @if($ticket->actif)
        <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black tracking-[0.1em] uppercase text-slate-400/70 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-base">inventory_2</span>
                Actif Lié
            </h3>
            <a href="{{ route('admin.actifs.show', $ticket->actif->id) }}" class="flex items-center gap-4 p-3 bg-slate-50 rounded-xl border border-slate-100 hover:bg-slate-100 transition-colors">
                <div class="w-12 h-12 bg-primary/5 rounded-lg flex items-center justify-center border border-primary/10">
                    <span class="material-symbols-outlined text-primary text-2xl">{{ $typeIcons[$ticket->actif->type] ?? 'devices' }}</span>
                </div>
                <div class="flex-1">
                    <div class="font-bold text-slate-900 text-sm">{{ $ticket->actif->marque }} {{ $ticket->actif->modele }}</div>
                    <div class="text-slate-500 text-xs mb-1">{{ $ticket->actif->code_inventaire }}</div>
                    <div class="flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        <span class="text-[10px] font-bold text-green-600 uppercase tracking-tighter">{{ $ticket->actif->etat }}</span>
                    </div>
                </div>
                <span class="material-symbols-outlined text-primary text-xl">open_in_new</span>
            </a>
        </div>
        @endif

        <!-- Assignment Info -->
        <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black tracking-[0.1em] uppercase text-slate-400/70 mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-base">person</span>
                Assignation
            </h3>
            @if($ticket->assigneA)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-secondary to-purple-700 flex items-center justify-center text-white font-bold text-sm">
                    {{ substr($ticket->assigneA->prenom, 0, 1) }}{{ substr($ticket->assigneA->nom, 0, 1) }}
                </div>
                <div>
                    <div class="font-semibold text-slate-900">{{ $ticket->assigneA->full_name }}</div>
                    <div class="text-slate-500 text-xs">{{ $ticket->assigneA->roles->first()->libelle ?? 'Technicien' }}</div>
                </div>
            </div>
            @else
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-400">person_off</span>
                </div>
                <div>
                    <div class="font-semibold text-slate-400">Non assigné</div>
                    <div class="text-slate-500 text-xs">En attente d'assignation</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Activity Timeline -->
        <div class="p-5 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <h3 class="text-[10px] font-black tracking-[0.1em] uppercase text-slate-400/70 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-base">history</span>
                Activité Récente
            </h3>
            
            <div class="space-y-6 relative before:absolute before:left-[19px] before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-100">
                <!-- Ticket Created -->
                <div class="relative pl-12">
                    <div class="absolute left-0 top-0.5 w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center ring-4 ring-white z-10 border border-primary/20">
                        <span class="material-symbols-outlined text-primary text-xl font-bold">add</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Ticket créé</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $ticket->created_at->format('d/m/Y H:i') }} • {{ $ticket->createur->full_name ?? 'System' }}</div>
                    </div>
                </div>

                <!-- Assigned -->
                @if($ticket->assigneA)
                <div class="relative pl-12">
                    <div class="absolute left-0 top-0.5 w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center ring-4 ring-white z-10 border border-secondary/20">
                        <span class="material-symbols-outlined text-secondary text-xl font-bold">person</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Assigné à {{ $ticket->assigneA->full_name }}</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $ticket->created_at->addMinutes(10)->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                @endif

                <!-- Status Changed -->
                @if($ticket->statut !== 'ouvert')
                <div class="relative pl-12">
                    <div class="absolute left-0 top-0.5 w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center ring-4 ring-white z-10 border border-amber-200">
                        <span class="material-symbols-outlined text-amber-500 text-xl font-bold">autorenew</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">Statut changé vers "{{ str_replace('_', ' ', $ticket->statut) }}"</div>
                        <div class="text-[11px] text-slate-400 mt-0.5">{{ $ticket->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                @endif

                <!-- Comments -->
                @foreach($ticket->commentaires->take(3) as $comment)
                <div class="relative pl-12">
                    <div class="absolute left-0 top-0.5 w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center ring-4 ring-white z-10 border border-slate-200">
                        <span class="material-symbols-outlined text-slate-500 text-xl" style="font-variation-settings: 'FILL' 1;">chat</span>
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">{{ $comment->utilisateur->full_name ?? 'Unknown' }}</div>
                        <div class="text-sm text-slate-600 mt-2 p-3 bg-slate-50 rounded-lg rounded-tl-none italic border border-slate-100">
                            "{{ $comment->contenu }}"
                        </div>
                        <div class="text-[9px] text-slate-400/60 mt-2 uppercase tracking-widest font-bold text-right">
                            {{ $comment->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Quick Actions -->
        @if($ticket->statut !== 'ferme' && $ticket->statut !== 'resolu')
        <div class="grid grid-cols-2 gap-3 pt-2">
            @if($ticket->statut !== 'resolu')
            <form action="{{ route('admin.tickets.resoudre', $ticket->id) }}" method="POST">
                @csrf
                <button class="w-full flex items-center justify-center gap-2 bg-green-500 text-white py-4 px-6 rounded-2xl font-black text-sm active:scale-[0.97] transition-all shadow-lg shadow-green-500/20">
                    <span class="material-symbols-outlined text-xl">check_circle</span>
                    Résoudre
                </button>
            </form>
            @else
            <button class="w-full flex items-center justify-center gap-2 bg-green-500 text-white py-4 px-6 rounded-2xl font-black text-sm opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-xl">check_circle</span>
                Résolu
            </button>
            @endif
            
            @can('tickets.assign')
            <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="flex items-center justify-center gap-2 bg-slate-100 text-slate-700 py-4 px-6 rounded-2xl font-black text-sm active:scale-[0.97] transition-all border border-slate-200">
                <span class="material-symbols-outlined text-xl">person_add</span>
                Assigner
            </a>
            @endcan
        </div>
        @endif

        <!-- Add Comment -->
        @if($ticket->statut !== 'ferme')
        <form action="{{ route('admin.tickets.add-comment', $ticket->id) }}" method="POST" class="flex flex-col gap-3">
            @csrf
            <textarea name="contenu" rows="3" class="w-full p-4 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none" placeholder="Ajouter un commentaire..."></textarea>
            <button type="submit" class="flex items-center justify-center gap-2 bg-primary/5 border-2 border-dashed border-primary/20 text-primary py-3 px-6 rounded-2xl font-bold text-sm hover:bg-primary/10 transition-colors">
                <span class="material-symbols-outlined text-xl">add_comment</span>
                Ajouter un Commentaire
            </button>
        </form>
        @endif
    </div>
</main>

<!-- BottomNavBar -->
<nav class="fixed bottom-0 w-full z-50 flex justify-around items-center h-16 pb-safe px-2 bg-white/95 backdrop-blur-lg border-t border-slate-100 shadow-lg rounded-t-3xl">
    <a href="{{ route('mobile.dashboard') }}" class="flex flex-col items-center justify-center text-slate-400 hover:text-primary transition-all px-4">
        <span class="material-symbols-outlined text-2xl">dashboard</span>
        <span class="font-inter text-[9px] font-bold mt-1 uppercase tracking-tighter">Home</span>
    </a>
    <a href="{{ route('mobile.actifs.index') }}" class="flex flex-col items-center justify-center text-slate-400 opacity-50 transition-all px-4">
        <span class="material-symbols-outlined text-2xl">inventory_2</span>
        <span class="font-inter text-[9px] font-bold mt-1 uppercase tracking-tighter">Assets</span>
    </a>
    <a href="{{ route('mobile.tickets.index') }}" class="relative flex flex-col items-center justify-center text-primary px-4">
        <div class="absolute -top-1 w-1 h-1 rounded-full bg-primary"></div>
        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">confirmation_number</span>
        <span class="font-inter text-[9px] font-bold mt-1 uppercase tracking-tighter">Tickets</span>
    </a>
    <a href="{{ route('admin.logiciels.index') }}" class="flex flex-col items-center justify-center text-slate-400 opacity-50 transition-all px-4">
        <span class="material-symbols-outlined text-2xl">terminal</span>
        <span class="font-inter text-[9px] font-bold mt-1 uppercase tracking-tighter">Tools</span>
    </a>
    <a href="{{ route('admin.profile.show') }}" class="flex flex-col items-center justify-center text-slate-400 opacity-50 transition-all px-4">
        <span class="material-symbols-outlined text-2xl">settings</span>
        <span class="font-inter text-[9px] font-bold mt-1 uppercase tracking-tighter">Admin</span>
    </a>
</nav>
