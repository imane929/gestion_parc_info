@extends('layouts.app')

@section('title', 'Détails de la localisation')
@section('page-title', 'Détails de la localisation')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <!-- Location Info Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 dark:bg-slate-900 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Informations</h2>
        </div>
        
        <div class="p-6">
            <div class="text-center mb-6">
                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center shadow-lg shadow-cyan-500/25">
                    <span class="material-symbols-outlined text-white text-3xl">location_on</span>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $localisation->nom_complet }}</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined">business</span>
                        <span>Site</span>
                    </div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $localisation->site }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined">apartment</span>
                        <span>Bâtiment</span>
                    </div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $localisation->batiment ?? '-' }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined">layers</span>
                        <span>Étage</span>
                    </div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $localisation->etage ?? '-' }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3 border-b border-slate-200/60 dark:border-slate-700">
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined">door_front</span>
                        <span>Bureau</span>
                    </div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $localisation->bureau ?? '-' }}</span>
                </div>
                
                <div class="flex items-center justify-between py-3">
                    <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                        <span class="material-symbols-outlined">inventory_2</span>
                        <span>Total actifs</span>
                    </div>
                    <span class="px-3 py-1 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white text-sm font-semibold">{{ $localisation->actifs->count() }}</span>
                </div>
            </div>
        </div>
        
        <div class="px-6 pb-6">
            <div class="flex gap-2">
                @can('edit localisations')
                <a href="{{ route('admin.localisations.edit', $localisation) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 rounded-xl transition">
                    <span class="material-symbols-outlined">edit</span>
                    Modifier
                </a>
                @endcan
                @can('delete localisations')
                <form method="POST" action="{{ route('admin.localisations.destroy', $localisation) }}" class="flex-1">
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
    </div>
    
    <!-- Assets in Location -->
    <div class="lg:col-span-3 bg-white rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 dark:bg-slate-900 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Actifs dans cette localisation</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-800/50">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Marque/Modèle</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">État</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Assigné à</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/60 dark:divide-slate-700">
                    @forelse($localisation->actifs as $actif)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-slate-900 dark:text-white">{{ $actif->code_inventaire }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-300">
                                <span class="material-symbols-outlined text-lg">desktop_windows</span>
                                {{ ucfirst($actif->type) }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-900 dark:text-white font-medium">{{ $actif->marque }}</div>
                            <div class="text-sm text-slate-500 dark:text-slate-400">{{ $actif->modele }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            $etatClasses = [
                                'neuf' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300',
                                'bon' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300',
                                'moyen' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300',
                                'mauvais' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300',
                            ];
                            $etatClass = $etatClasses[$actif->etat] ?? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $etatClass }}">{{ ucfirst($actif->etat) }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                            @if($actif->utilisateurAffecte)
                                {{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.actifs.show', $actif) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-700 transition">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl text-slate-400">inventory_2</span>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400">Aucun actif dans cette localisation</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection