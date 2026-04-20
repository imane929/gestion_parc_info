@extends('layouts.admin-new')

@section('title', 'Mes Actifs')

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-on-surface">Mes Actifs</h1>
    <p class="text-sm text-on-surface-variant">Équipements qui vous sont assignés</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider">Total Actifs</p>
                <p class="text-3xl font-bold text-on-surface mt-1">{{ $stats['total'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600">devices</span>
            </div>
        </div>
    </div>
    
    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider">En Service</p>
                <p class="text-3xl font-bold text-emerald-600 mt-1">{{ $stats['en_service'] }}</p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
            </div>
        </div>
    </div>
    
    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider">En Réparation</p>
                <p class="text-3xl font-bold text-amber-600 mt-1">{{ $stats['en_reparation'] }}</p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-600">build</span>
            </div>
        </div>
    </div>
</div>

<!-- Assets List -->
<div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
    @if($actifs->isEmpty())
        <div class="p-12 text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-slate-400 text-3xl">devices</span>
            </div>
            <h3 class="text-lg font-semibold text-on-surface mb-2">Aucun Actif Assigné</h3>
            <p class="text-sm text-on-surface-variant">Vous n'avez pas encore d'équipement assigné.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant/10">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Actif</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Type</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Statut</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Localisation</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Numéro de Série</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    @foreach($actifs as $actif)
                    <tr class="hover:bg-surface-container-low transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-lg">
                                        @if($actif->type == 'ordinateur_portable')
                                            laptop
                                        @elseif($actif->type == 'ordinateur_bureau')
                                            desktop_windows
                                        @elseif($actif->type == 'telephone')
                                            smartphone
                                        @elseif($actif->type == 'imprimante')
                                            print
                                        @elseif($actif->type == 'serveur')
                                            dns
                                        @else
                                            devices
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-on-surface">{{ $actif->marque }} {{ $actif->modele }}</p>
                                    <p class="text-xs text-on-surface-variant">{{ $actif->code_inventaire }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-on-surface">
                                @if($actif->type == 'ordinateur_portable')
                                    Ordinateur Portable
                                @elseif($actif->type == 'ordinateur_bureau')
                                    Ordinateur de Bureau
                                @elseif($actif->type == 'telephone')
                                    Téléphone
                                @elseif($actif->type == 'imprimante')
                                    Imprimante
                                @elseif($actif->type == 'serveur')
                                    Serveur
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $actif->type)) }}
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'en_service' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                    'en_reparation' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'hors_service' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                    'retire' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-400',
                                ];
                                $statusColor = $statusColors[$actif->etat] ?? 'bg-slate-100 text-slate-700';
                                $statusLabels = [
                                    'en_service' => 'En Service',
                                    'en_reparation' => 'En Réparation',
                                    'hors_service' => 'Hors Service',
                                    'retire' => 'Retiré',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $statusLabels[$actif->etat] ?? ucfirst($actif->etat) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-on-surface">{{ $actif->localisation->nom ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-on-surface-variant font-mono">{{ $actif->numero_serie ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
