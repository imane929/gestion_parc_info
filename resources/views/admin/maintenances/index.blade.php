@extends('layouts.admin-new')

@section('title', 'Maintenance préventive')
@section('page-title', 'Maintenance préventive')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">Maintenance</h2>
            <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Planifier et suivre la maintenance des équipements</p>
        </div>
        @can('create maintenances')
        <a href="{{ route('admin.maintenances.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">Planifier</span>
        </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg lg:text-xl">event</span>
                </div>
                <div>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] ?? 0 }}</p>
                    <p class="text-xs lg:text-sm text-slate-500">Total</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg lg:text-xl">schedule</span>
                </div>
                <div>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['planifiees'] ?? 0 }}</p>
                    <p class="text-xs lg:text-sm text-slate-500">Planifiées</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg lg:text-xl">sync</span>
                </div>
                <div>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['en_cours'] ?? 0 }}</p>
                    <p class="text-xs lg:text-sm text-slate-500">En cours</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg lg:text-xl">warning</span>
                </div>
                <div>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['retard'] ?? 0 }}</p>
                    <p class="text-xs lg:text-sm text-slate-500">En retard</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white dark:bg-slate-800 rounded-xl p-3 lg:p-4 border border-slate-200 dark:border-slate-700">
        <div class="flex flex-col gap-3">
            <input type="text" name="search" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500" placeholder="Rechercher..." value="{{ request('search') }}">
            <div class="flex flex-wrap gap-2">
                <select name="statut" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous les statuts</option>
                    <option value="planifie" {{ request('statut') == 'planifie' ? 'selected' : '' }}>Planifié</option>
                    <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="termine" {{ request('statut') == 'termine' ? 'selected' : '' }}>Terminé</option>
                </select>
                <div class="flex gap-2 ml-auto">
                    <button type="submit" class="px-3 lg:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">Filtrer</button>
                    <a href="{{ route('admin.maintenances.index') }}" class="px-3 lg:px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium">Réinitialiser</a>
                </div>
            </div>
        </div>
    </form>

    <!-- Desktop Table View -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden hidden lg:block">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Actif</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Statut</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($maintenances as $maintenance)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                        <td class="px-4 py-3">
                            <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $maintenance->actif->code_inventaire ?? 'N/A' }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $maintenance->actif->marque ?? '' }}</p>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-200 capitalize">{{ $maintenance->type }}</td>
                        <td class="px-4 py-3">
                            @php
                                $colors = ['planifie' => 'bg-blue-100 text-blue-700', 'en_cours' => 'bg-amber-100 text-amber-700', 'termine' => 'bg-emerald-100 text-emerald-700', 'annule' => 'bg-slate-100 text-slate-700'];
                            @endphp
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colors[$maintenance->statut] ?? 'bg-slate-100' }}">{{ ucfirst($maintenance->statut) }}</span>
                        </td>
                        <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-200">{{ $maintenance->date_prevue->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.maintenances.show', $maintenance->id) }}" class="p-2 text-slate-500 hover:text-blue-500 hover:bg-blue-50 rounded-lg"><span class="material-symbols-outlined">visibility</span></a>
                                @can('edit maintenances')<a href="{{ route('admin.maintenances.edit', $maintenance->id) }}" class="p-2 text-slate-500 hover:text-yellow-500 hover:bg-yellow-50 rounded-lg"><span class="material-symbols-outlined">edit</span></a>@endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-12 text-center text-slate-500">Aucune maintenance trouvée</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700">
            {{ $maintenances->links() }}
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3">
        @forelse($maintenances as $maintenance)
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $maintenance->actif->code_inventaire ?? 'N/A' }}</span>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $maintenance->actif->marque ?? '' }}</p>
                </div>
                @php
                    $colors = ['planifie' => 'bg-blue-100 text-blue-700', 'en_cours' => 'bg-amber-100 text-amber-700', 'termine' => 'bg-emerald-100 text-emerald-700', 'annule' => 'bg-slate-100 text-slate-700'];
                @endphp
                <span class="px-2 py-1 rounded-full text-[10px] font-medium {{ $colors[$maintenance->statut] ?? 'bg-slate-100' }}">{{ ucfirst($maintenance->statut) }}</span>
            </div>
            <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400 mb-3">
                <span class="capitalize">{{ $maintenance->type }}</span>
                <span>•</span>
                <span>{{ $maintenance->date_prevue->format('d/m/Y') }}</span>
            </div>
            <div class="flex gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('admin.maintenances.show', $maintenance->id) }}" class="flex-1 py-2 text-center text-xs font-medium text-blue-600 bg-blue-50 rounded-lg">View</a>
                @can('edit maintenances')<a href="{{ route('admin.maintenances.edit', $maintenance->id) }}" class="flex-1 py-2 text-center text-xs font-medium text-yellow-600 bg-yellow-50 rounded-lg">Edit</a>@endcan
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-500">No maintenance found</div>
        @endforelse
    </div>
</div>
@endsection

