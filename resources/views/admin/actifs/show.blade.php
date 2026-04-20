@extends('layouts.app')

@section('title', 'Détails de l\'actif')
@section('page-title', 'Détails de l\'actif')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Main Info Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 dark:bg-slate-900 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Informations</h2>
        </div>
        
        <div class="p-6">
            <div class="text-center mb-6">
                @php
                $typeIcons = [
                    'pc' => 'desktop_windows',
                    'serveur' => 'dns',
                    'imprimante' => 'print',
                    'reseau' => 'router',
                    'peripherique' => 'mouse',
                    'mobile' => 'smartphone',
                    'autre' => 'devices'
                ];
                $typeIcon = $typeIcons[$actif->type] ?? 'devices';
                @endphp
                <div class="w-24 h-24 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/25">
                    <span class="material-symbols-outlined text-white text-4xl">{{ $typeIcon }}</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $actif->marque }} {{ $actif->modele }}</h3>
                <p class="text-slate-500 dark:text-slate-400">{{ $actif->code_inventaire }}</p>
            </div>
            
            <div class="space-y-3">
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">category</span>
                        <span>Type</span>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-xs font-medium">{{ ucfirst($actif->type) }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">qr_code</span>
                        <span>N° série</span>
                    </div>
                    <code class="text-xs text-slate-900 dark:text-white">{{ $actif->numero_serie }}</code>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">event</span>
                        <span>Acheté</span>
                    </div>
                    <span class="text-slate-900 dark:text-white">{{ $actif->date_achat ? $actif->date_achat->format('d/m/Y') : '-' }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">verified_user</span>
                        <span>Garantie</span>
                    </div>
                    @if($actif->garantie_fin)
                        <div class="text-right">
                            <span class="{{ $actif->garantieEstValide() ? 'text-emerald-600' : 'text-red-600' }} text-sm font-medium">
                                {{ \Carbon\Carbon::parse($actif->garantie_fin)->format('d/m/Y') }}
                            </span>
                            @if($actif->garantieEstValide())
                                <p class="text-xs text-slate-500">{{ $actif->jours_restants_garantie ?? \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($actif->garantie_fin)) }} jours restants</p>
                            @endif
                        </div>
                    @else
                        <span class="text-slate-400">-</span>
                    @endif
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">location_on</span>
                        <span>Localisation</span>
                    </div>
                    <span class="text-slate-900 dark:text-white">{{ $actif->localisation?->nom_complet ?? '-' }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">person</span>
                        <span>Affecté à</span>
                    </div>
                    <span class="text-slate-900 dark:text-white">{{ $actif->utilisateurAffecte?->full_name ?? '-' }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined text-lg">inventory_2</span>
                        <span>État</span>
                    </div>
                    @php
                    $etatClasses = [
                        'neuf' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                        'bon' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                        'moyen' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300',
                        'mauvais' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                        'hors_service' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                    ];
                    $etatClass = $etatClasses[$actif->etat] ?? 'bg-slate-100 text-slate-700';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $etatClass }}">{{ ucfirst($actif->etat) }}</span>
                </div>
                
                @if($actif->description)
                <div class="pt-3 border-t border-slate-200/60 dark:border-slate-700">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1">Description</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $actif->description }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <div class="px-6 pb-6 flex gap-2">
            @can('edit actifs')
            <a href="{{ route('admin.actifs.edit', $actif) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition">
                <span class="material-symbols-outlined">edit</span>
                Modifier
            </a>
            @endcan
            @can('delete actifs')
            <form method="POST" action="{{ route('admin.actifs.destroy', $actif) }}" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-xl transition delete-confirm">
                    <span class="material-symbols-outlined">delete</span>
                    Supprimer
                </button>
            </form>
            @endcan
        </div>
    </div>
    
    <!-- Tabs Content -->
    <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 dark:bg-slate-900 overflow-hidden">
        <div class="border-b border-slate-200/60 dark:border-slate-700">
            <nav class="flex space-x-4 px-4" aria-label="Tabs">
                <button class="tab-btn active py-4 px-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600" data-tab="history">
                    <span class="material-symbols-outlined text-lg align-middle">history</span>
                    Historique
                </button>
                <button class="tab-btn py-4 px-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400" data-tab="maintenance">
                    <span class="material-symbols-outlined text-lg align-middle">build</span>
                    Maintenances
                </button>
                <button class="tab-btn py-4 px-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400" data-tab="software">
                    <span class="material-symbols-outlined text-lg align-middle">apps</span>
                    Logiciels
                </button>
                <button class="tab-btn py-4 px-2 text-sm font-medium text-slate-500 hover:text-slate-700 dark:text-slate-400" data-tab="tickets">
                    <span class="material-symbols-outlined text-lg align-middle">confirmation_number</span>
                    Tickets
                </button>
            </nav>
        </div>
        
        <div class="p-6">
            <!-- History Tab -->
            <div class="tab-content" id="history">
                <div class="relative pl-6 border-l-2 border-slate-200 dark:border-slate-700">
                    @forelse($actif->historiques()->latest()->take(10)->get() as $historique)
                    <div class="relative pb-6">
                        <div class="absolute -left-[31px] w-4 h-4 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 border-2 border-white dark:border-slate-900"></div>
                        <h4 class="text-sm font-semibold text-slate-900 dark:text-white">{{ $historique->evenement }}</h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $historique->details }}</p>
                        <p class="text-xs text-slate-400 mt-1">{{ $historique->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-4xl text-slate-300">history</span>
                        <p class="text-slate-500 mt-2">Aucun historique</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Maintenance Tab -->
            <div class="tab-content hidden" id="maintenance">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Type</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Date</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($actif->maintenancesPreventives as $maintenance)
                            <tr>
                                <td class="py-3 px-4 text-slate-900 dark:text-white">{{ ucfirst($maintenance->type) }}</td>
                                <td class="py-3 px-4 text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($maintenance->date_prevue)->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">
                                    @php
                                    $statusClasses = [
                                        'planifie' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                                        'en_cours' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300',
                                        'termine' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                                        'annule' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                                    ];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusClasses[$maintenance->statut] ?? 'bg-slate-100' }}">{{ ucfirst($maintenance->statut) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">build</span>
                                    <p class="text-slate-500 mt-2">Aucune maintenance</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Software Tab -->
            <div class="tab-content hidden" id="software">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Logiciel</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Version</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Licence</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($actif->installationsLogiciels as $installation)
                            <tr>
                                <td class="py-3 px-4 text-slate-900 dark:text-white">{{ $installation->licence->logiciel->nom }}</td>
                                <td class="py-3 px-4 text-slate-500 dark:text-slate-400">{{ $installation->licence->logiciel->version }}</td>
                                <td class="py-3 px-4 text-slate-500 dark:text-slate-400">{{ $installation->licence->cle_licence }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">apps</span>
                                    <p class="text-slate-500 mt-2">Aucun logiciel installé</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Tickets Tab -->
            <div class="tab-content hidden" id="tickets">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Ticket</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Sujet</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                            @forelse($actif->tickets as $ticket)
                            <tr>
                                <td class="py-3 px-4 text-slate-900 dark:text-white font-medium">{{ $ticket->numero }}</td>
                                <td class="py-3 px-4 text-slate-500 dark:text-slate-400">{{ Str::limit($ticket->sujet, 40) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">{{ ucfirst($ticket->statut) }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-300">confirmation_number</span>
                                    <p class="text-slate-500 mt-2">Aucun ticket</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update buttons
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
                b.classList.add('text-slate-500');
            });
            this.classList.add('active', 'text-blue-600', 'border-b-2', 'border-blue-600');
            this.classList.remove('text-slate-500');
            
            // Update content
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(this.dataset.tab).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection