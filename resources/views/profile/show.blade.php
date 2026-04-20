@extends('layouts.admin-new')

@section('title', 'Mon profil')

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-on-surface">Mon profil</h1>
    <p class="text-sm text-on-surface-variant">Gérez les informations de votre compte</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Profile Card -->
    <div class="lg:col-span-4">
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/10">
            <div class="text-center mb-6">
                @if(auth()->user()->photo_url)
                    <img src="{{ auth()->user()->photo_url }}" 
                         alt="Avatar" 
                         class="w-28 h-28 rounded-full object-cover mx-auto mb-4 ring-4 ring-primary/20">
                @else
                    <div class="w-28 h-28 rounded-full mx-auto mb-4 bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-3xl font-bold ring-4 ring-primary/20">
                        {{ auth()->user()->initials ?? 'U' }}
                    </div>
                @endif
                
                <h2 class="text-lg font-bold text-on-surface">{{ auth()->user()->full_name }}</h2>
                <p class="text-sm text-on-surface-variant">{{ auth()->user()->roles->first()->libelle ?? 'User' }}</p>
                
                <div class="flex items-center justify-center gap-2 mt-3">
                    <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-medium rounded-full">
                        {{ auth()->user()->email }}
                    </span>
                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 text-xs font-medium rounded-full">
                        {{ ucfirst(auth()->user()->etat_compte ?? 'active') }}
                    </span>
                </div>
            </div>
            
            <div class="space-y-3 pt-4 border-t border-outline-variant/10">
                <div class="flex items-center gap-3 text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant">phone</span>
                    <span class="text-on-surface">{{ auth()->user()->telephone ?? 'Not provided' }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant">calendar_month</span>
                    <span class="text-on-surface">Membre depuis {{ auth()->user()->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <span class="material-symbols-outlined text-on-surface-variant">schedule</span>
                    <span class="text-on-surface">Dernière connexion : {{ auth()->user()->derniere_connexion_at?->diffForHumans() ?? 'Jamais' }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.profile.edit') }}" class="mt-6 w-full flex items-center justify-center gap-2 px-4 py-3 bg-primary text-white rounded-xl font-medium hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined">edit</span>
                Modifier le profil
            </a>
        </div>
    </div>
    
    <!-- Tabs Content -->
    <div class="lg:col-span-8">
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-outline-variant/10 overflow-x-auto">
                <button onclick="showTab('info')" id="tab-info" class="tab-btn active px-6 py-4 text-sm font-medium text-primary border-b-2 border-primary whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">person</span>
                    Informations
                </button>
                <button onclick="showTab('tickets')" id="tab-tickets" class="tab-btn px-6 py-4 text-sm font-medium text-on-surface-variant border-b-2 border-transparent hover:text-on-surface whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">confirmation_number</span>
                    Mes tickets
                </button>
                <button onclick="showTab('assets')" id="tab-assets" class="tab-btn px-6 py-4 text-sm font-medium text-on-surface-variant border-b-2 border-transparent hover:text-on-surface whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">devices</span>
                    Mes actifs
                </button>
            </div>
            
            <!-- Tab Contents -->
            <div class="p-6">
                <!-- Personal Info Tab -->
                <div id="content-info" class="tab-content">
                    <h3 class="text-lg font-semibold text-on-surface mb-4">Informations personnelles</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <div class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Nom complet</div>
                            <div class="text-sm font-semibold text-on-surface">{{ auth()->user()->full_name }}</div>
                        </div>
                        
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <div class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Email</div>
                            <div class="text-sm font-semibold text-on-surface">{{ auth()->user()->email }}</div>
                        </div>
                        
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <div class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Téléphone</div>
                            <div class="text-sm font-semibold text-on-surface">{{ auth()->user()->telephone ?? 'Non renseigné' }}</div>
                        </div>
                        
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <div class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Rôle</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach(auth()->user()->roles as $role)
                                    <span class="px-3 py-1 bg-primary/10 text-primary text-xs font-medium rounded-full">{{ $role->libelle }}</span>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <div class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Statut du compte</div>
                            <span class="inline-flex items-center px-3 py-1 bg-emerald-500/10 text-emerald-600 text-xs font-medium rounded-full">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2"></span>
                                {{ ucfirst(auth()->user()->etat_compte ?? 'active') }}
                            </span>
                        </div>
                        
                        <div class="p-4 bg-surface-container-low rounded-xl">
                            <div class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-1">Membre depuis</div>
                            <div class="text-sm font-semibold text-on-surface">{{ auth()->user()->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Mes tickets -->
                <div id="content-tickets" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-on-surface mb-4">Mes tickets</h3>
                    
                    @forelse(auth()->user()->ticketsCrees()->latest()->take(5)->get() as $ticket)
                    <div class="flex items-center gap-4 p-4 bg-surface-container-low rounded-xl mb-3 hover:bg-surface-container transition-colors">
                        <div class="w-3 h-3 rounded-full flex-shrink-0 {{ $ticket->priorite == 'urgente' ? 'bg-error' : ($ticket->priorite == 'haute' ? 'bg-tertiary' : 'bg-primary') }}"></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-on-surface-variant">#T-{{ $ticket->id }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                    @if($ticket->statut == 'ouvert') bg-error/10 text-error
                                    @elseif($ticket->statut == 'en_cours') bg-primary/10 text-primary
                                    @else bg-surface-container-high text-on-surface-variant @endif">
                                    {{ $ticket->statut }}
                                </span>
                            </div>
                            <div class="text-sm font-medium text-on-surface truncate">{{ $ticket->titre }}</div>
                        </div>
                        <div class="text-xs text-on-surface-variant flex-shrink-0">{{ $ticket->created_at->format('d/m/Y') }}</div>
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 rounded-lg hover:bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">confirmation_number</span>
                        <p class="text-on-surface-variant">Aucun ticket créé</p>
                    </div>
                    @endforelse
                    
                    @if(auth()->user()->ticketsCrees()->count() > 5)
                    <div class="text-center mt-4">
                        <a href="{{ route('admin.tickets.index', ['createur_id' => auth()->id()]) }}" class="text-primary text-sm font-medium hover:underline">
                            Voir tous les tickets →
                        </a>
                    </div>
                    @endif
                </div>
                
                <!-- Mes actifs -->
                <div id="content-assets" class="tab-content hidden">
                    <h3 class="text-lg font-semibold text-on-surface mb-4">Mes actifs</h3>
                    
                    @forelse(auth()->user()->actifsAffectes as $actif)
                    <div class="flex items-center gap-4 p-4 bg-surface-container-low rounded-xl mb-3 hover:bg-surface-container transition-colors">
                        <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-primary">devices</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold text-on-surface-variant">{{ $actif->code_inventaire }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                    @if($actif->etat == 'neuf') bg-emerald-500/10 text-emerald-600
                                    @elseif($actif->etat == 'bon') bg-primary/10 text-primary
                                    @elseif($actif->etat == 'moyen') bg-amber-500/10 text-amber-600
                                    @else bg-error/10 text-error @endif">
                                    {{ ucfirst($actif->etat) }}
                                </span>
                            </div>
                            <div class="text-sm font-semibold text-on-surface">{{ $actif->marque }} {{ $actif->modele }}</div>
                            <div class="text-xs text-on-surface-variant">{{ ucfirst($actif->type) }}</div>
                        </div>
                        @if($actif->garantie_fin)
                            @if($actif->garantieEstValide())
                                <div class="text-right flex-shrink-0">
                                    <div class="text-xs text-on-surface-variant">Garantie</div>
                                    <div class="text-xs font-medium text-emerald-600">{{ $actif->jours_restants_garantie }} jours restants</div>
                                </div>
                            @else
                                <span class="px-2 py-1 bg-error/10 text-error text-xs font-medium rounded-lg">Expiré</span>
                            @endif
                        @endif
                        <a href="{{ route('admin.actifs.show', $actif) }}" class="p-2 rounded-lg hover:bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </a>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">devices</span>
                        <p class="text-on-surface-variant">Aucun actif affecté</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
        // Show selected tab content
        document.getElementById('content-' + tabName).classList.remove('hidden');
        
        // Update tab buttons
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('active', 'text-primary', 'border-primary');
            el.classList.add('text-on-surface-variant', 'border-transparent');
        });
        
        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.add('active', 'text-primary', 'border-primary');
        activeTab.classList.remove('text-on-surface-variant', 'border-transparent');
    }
</script>

<style>
    .tab-btn.active {
        color: #0058be;
        border-color: #0058be;
    }
</style>
@endsection
