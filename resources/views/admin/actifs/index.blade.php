@extends('layouts.admin-new')

@section('title', 'Actifs')
@section('page-title', 'Tous les actifs')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Stats Cards -->
    @include('admin.actifs.partials.stats-cards')
    
    <!-- Main Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-4 lg:px-5 py-3 lg:py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="text-base lg:text-lg font-semibold text-slate-900 dark:text-white">Actifs IT</h2>
            <div class="flex gap-2 flex-wrap">
                @can('create actifs')
                <a href="{{ route('admin.actifs.create') }}" class="inline-flex items-center gap-1 lg:gap-2 px-3 lg:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs lg:text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-base lg:text-lg">add</span>
                    <span class="hidden xs:inline">Nouvel actif</span>
                </a>
                @endcan
                <button type="button" class="p-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <span class="material-symbols-outlined text-lg">download</span>
                </button>
            </div>
        </div>
        
        <div class="p-3 lg:p-5">
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.actifs.index') }}" class="flex flex-wrap gap-2 lg:gap-3 mb-4 lg:mb-5" id="filterForm">
                <div class="flex-1 min-w-[140px] lg:min-w-[200px]">
                    <input type="text" name="search" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Rechercher..." value="{{ request('search') }}" id="searchInput">
                </div>
                <div class="w-28 lg:w-36">
                    <select name="type" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="typeFilter">
                        <option value="">Tous les types</option>
                        <option value="pc" {{ request('type') == 'pc' ? 'selected' : '' }}>Ordinateur</option>
                        <option value="serveur" {{ request('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                        <option value="imprimante" {{ request('type') == 'imprimante' ? 'selected' : '' }}>Imprimante</option>
                        <option value="reseau" {{ request('type') == 'reseau' ? 'selected' : '' }}>Réseau</option>
                        <option value="mobile" {{ request('type') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="peripherique" {{ request('type') == 'peripherique' ? 'selected' : '' }}>Périphérique</option>
                        <option value="autre" {{ request('type') == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
                <div class="w-28 lg:w-36">
                    <select name="etat" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="stateFilter">
                        <option value="">Tous les états</option>
                        <option value="neuf" {{ request('etat') == 'neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="bon" {{ request('etat') == 'bon' ? 'selected' : '' }}>Bon</option>
                        <option value="moyen" {{ request('etat') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                        <option value="mauvais" {{ request('etat') == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                        <option value="hors_service" {{ request('etat') == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                    </select>
                </div>
                <div class="hidden sm:block w-28 lg:w-36">
                    <select name="affectation" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="assignmentFilter">
                        <option value="">Tous</option>
                        <option value="avec" {{ request('affectation') == 'avec' ? 'selected' : '' }}>En cours</option>
                        <option value="sans" {{ request('affectation') == 'sans' ? 'selected' : '' }}>En stock</option>
                    </select>
                </div>
                <div class="flex gap-1 lg:gap-2">
                    <button type="submit" class="px-3 lg:px-4 py-2 lg:py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs lg:text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-base lg:text-lg align-middle">search</span>
                    </button>
                    <a href="{{ route('admin.actifs.index') }}" class="px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-xs lg:text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-base lg:text-lg align-middle">refresh</span>
                    </a>
                </div>
            </form>
            
            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full" id="assetsTable">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Code</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Type</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Marque/Modèle</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Numéro de série</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">État</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Localisation</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Affecté à</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Garantie</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($actifs as $actif)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="py-3 px-4">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $actif->code_inventaire }}</span>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $typeIcons = [
                                        'pc' => 'computer',
                                        'serveur' => 'dns',
                                        'imprimante' => 'print',
                                        'reseau' => 'router',
                                        'peripherique' => 'keyboard',
                                        'mobile' => 'smartphone',
                                        'autre' => 'devices'
                                    ];
                                @endphp
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 align-middle mr-1">{{ $typeIcons[$actif->type] ?? 'computer' }}</span>
                                <span class="text-slate-700 dark:text-slate-300">{{ ucfirst($actif->type) }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <strong class="text-slate-900 dark:text-white">{{ $actif->marque }}</strong>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $actif->modele }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <code class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-xs font-mono text-slate-700 dark:text-slate-300">{{ $actif->numero_serie }}</code>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $etatColors = [
                                        'neuf' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'bon' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'moyen' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'mauvais' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        'hors_service' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $etatColors[$actif->etat] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($actif->etat) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-300">
                                @if($actif->localisation)
                                    <span title="{{ $actif->localisation->nom_complet }}">{{ $actif->localisation->site }}</span>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($actif->utilisateurAffecte)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-[10px] font-semibold">
                                            {{ $actif->utilisateurAffecte->initials ?? substr($actif->utilisateurAffecte->prenom, 0, 1) . substr($actif->utilisateurAffecte->nom, 0, 1) }}
                                        </div>
                                        <span class="text-slate-700 dark:text-slate-300 text-sm">{{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}</span>
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($actif->garantie_fin)
                                    @php
                                        $garantieFin = \Carbon\Carbon::parse($actif->garantie_fin);
                                        $joursRestants = now()->diffInDays($garantieFin, false);
                                    @endphp
                                    @if($joursRestants > 0)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400" title="Expire le {{ $garantieFin->format('d/m/Y') }}">
                                            {{ $joursRestants }} jours
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400" title="Expiré le {{ $garantieFin->format('d/m/Y') }}">
                                            Expiré
                                        </span>
                                    @endif
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.actifs.show', $actif) }}" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Voir">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    @can('edit actifs')
                                    <a href="{{ route('admin.actifs.edit', $actif) }}" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors" title="Modifier">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    @endcan
                                    @can('affect actifs')
                                    <button type="button" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-green-50 dark:hover:bg-green-900/30 hover:text-green-600 dark:hover:text-green-400 transition-colors affecter-actif" 
                                            data-actif-id="{{ $actif->id }}"
                                            data-actif-nom="{{ $actif->marque }} {{ $actif->modele }} ({{ $actif->code_inventaire }})"
                                            title="Affecter">
                                        <span class="material-symbols-outlined text-lg">person_add</span>
                                    </button>
                                    @endcan
                                    @can('delete actifs')
                                    <form method="POST" action="{{ route('admin.actifs.destroy', $actif) }}" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-colors delete-confirm" title="Supprimer">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-3xl text-slate-400">desktop_windows</span>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 mb-4">Aucun actif trouvé</p>
                                    @can('create actifs')
                                    <a href="{{ route('admin.actifs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined">add</span>
                                        Ajouter un actif
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-3">
                @forelse($actifs as $actif)
                <div class="bg-slate-50 dark:bg-slate-700/30 rounded-lg p-4 border border-slate-200 dark:border-slate-600">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <span class="font-semibold text-slate-900 dark:text-white text-sm">{{ $actif->code_inventaire }}</span>
                            <div class="flex items-center gap-1 mt-1">
                                @php
                                    $typeIcons = [
                                        'pc' => 'computer',
                                        'serveur' => 'dns',
                                        'imprimante' => 'print',
                                        'reseau' => 'router',
                                        'peripherique' => 'keyboard',
                                        'mobile' => 'smartphone',
                                        'autre' => 'devices'
                                    ];
                                    $etatColors = [
                                        'neuf' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                        'bon' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'moyen' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'mauvais' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        'hors_service' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                    ];
                                @endphp
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">{{ $typeIcons[$actif->type] ?? 'computer' }}</span>
                                <span class="text-xs text-slate-600 dark:text-slate-400">{{ ucfirst($actif->type) }}</span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $etatColors[$actif->etat] ?? 'bg-slate-100 text-slate-600' }}">
                                    {{ ucfirst($actif->etat) }}
                                </span>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <a href="{{ route('admin.actifs.show', $actif) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </a>
                            @can('edit actifs')
                            <a href="{{ route('admin.actifs.edit', $actif) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-yellow-50 hover:text-yellow-600 transition-colors">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="text-sm font-medium text-slate-800 dark:text-slate-200">{{ $actif->marque }} {{ $actif->modele }}</div>
                    <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        @if($actif->localisation)
                            <span class="material-symbols-outlined text-xs align-middle">location_on</span> {{ $actif->localisation->site }}
                        @else
                            <span class="text-slate-400">Sans localisation</span>
                        @endif
                        @if($actif->utilisateurAffecte)
                            • <span class="material-symbols-outlined text-xs align-middle">person</span> {{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-slate-400">desktop_windows</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 mb-4">Aucun actif trouvé</p>
                    @can('create actifs')
                    <a href="{{ route('admin.actifs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined">add</span>
                        Ajouter un actif
                    </a>
                    @endcan
                </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-5 flex justify-end">
                {{ $actifs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Assignment Modal -->
<div id="affectationModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="affectationModalLabel" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeAffectationModal()"></div>
        <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="affectationForm" method="POST">
                @csrf
                <div class="px-4 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white" id="affectationModalLabel">Affecter l'actif</h3>
                    <button type="button" onclick="closeAffectationModal()" class="p-1 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Actif</label>
                        <input type="text" id="actifNom" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Utilisateur <span class="text-red-500">*</span></label>
                        <select name="utilisateur_id" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent select2" required>
                            <option value="">Sélectionner un utilisateur...</option>
                            @foreach($utilisateurs ?? [] as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->full_name ?? $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Date d'affectation <span class="text-red-500">*</span></label>
                        <input type="date" name="date_debut" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" value="{{ now()->format('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Commentaire (optionnel)</label>
                        <textarea name="commentaire" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="3" placeholder="Ajouter un commentaire..."></textarea>
                    </div>
                </div>
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-700/50 flex justify-end gap-2">
                    <button type="button" onclick="closeAffectationModal()" class="px-4 py-2 bg-white dark:bg-slate-600 border border-slate-300 dark:border-slate-500 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">Affecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="exportModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="exportModalLabel" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeExportModal()"></div>
        <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="GET" action="{{ route('admin.actifs.export') }}" id="exportForm">
                <div class="px-4 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white" id="exportModalLabel">Exporter les actifs</h3>
                    <button type="button" onclick="closeExportModal()" class="p-1 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Format</label>
                        <select name="format" id="exportFormat" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="csv">CSV</option>
                            <option value="xlsx">Excel (XLSX)</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Inclure</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="include_affectations" value="1" id="includeAffectations" checked class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Historique des affectations</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="include_maintenances" value="1" id="includeMaintenances" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Maintenances</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="include_logiciels" value="1" id="includeLogiciels" class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Logiciels installés</span>
                            </label>
                        </div>
                    </div>
                    <div>
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="type" value="{{ request('type') }}">
                        <input type="hidden" name="etat" value="{{ request('etat') }}">
                        <input type="hidden" name="affectation" value="{{ request('affectation') }}">
                        <p class="text-xs text-slate-500 dark:text-slate-400">L'exportation appliquera les filtres actuels</p>
                    </div>
                </div>
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-700/50 flex justify-end gap-2">
                    <button type="button" onclick="closeExportModal()" class="px-4 py-2 bg-white dark:bg-slate-600 border border-slate-300 dark:border-slate-500 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">Annuler</button>
                    <button type="submit" id="exportBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">download</span>
                        Exporter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const affectAssetUrlTemplate = @json(route('admin.actifs.affecter', ['actif' => '__ACTIF__']));

    function openAffectationModal(actifId, actifNom) {
        document.getElementById('actifNom').value = actifNom;
        document.getElementById('affectationForm').action = affectAssetUrlTemplate.replace('__ACTIF__', actifId);
        document.getElementById('affectationModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeAffectationModal() {
        document.getElementById('affectationModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    function openExportModal() {
        document.getElementById('exportModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeExportModal() {
        document.getElementById('exportModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.affecter-actif').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const actifId = this.dataset.actifId;
                const actifNom = this.dataset.actifNom;
                openAffectationModal(actifId, actifNom);
            });
        });
        
        document.getElementById('affectationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const url = form.action;
            const data = new FormData(form);
            
            fetch(url, {
                method: 'POST',
                body: data,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
                .then(data => {
                closeAffectationModal();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès !',
                        text: 'Actif affecté avec succès',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue'
                });
            });
        });
        
        document.getElementById('exportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const url = form.action;
            const params = new URLSearchParams(new FormData(form));
            window.location.href = url + '?' + params.toString();
            closeExportModal();
        });
        
        document.querySelector('[data-bs-toggle="modal"][data-bs-target="#exportModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            openExportModal();
        });
        
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('keyup', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, 500);
        });
        
        document.getElementById('typeFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        document.getElementById('stateFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
        
        document.getElementById('assignmentFilter').addEventListener('change', function() {
            document.getElementById('filterForm').submit();
        });
    });
</script>
@endpush
@endsection

