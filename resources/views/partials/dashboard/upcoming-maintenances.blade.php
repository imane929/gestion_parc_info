<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Maintenances à venir</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Prochaines interventions planifiées</p>
        </div>
        <a href="{{ route('admin.maintenances.index') }}" class="flex items-center gap-1 text-sm font-medium text-primary hover:text-primary-dark transition-colors">
            Voir tout
            <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>
    <div class="space-y-3">
        @forelse($maintenancesPreventives as $maintenance)
        <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                <span class="material-symbols-outlined text-lg">build</span>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="font-medium text-slate-700 dark:text-slate-200 truncate">{{ $maintenance->actif->nom ?? 'Actif' }}</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $maintenance->date_prevue->translatedFormat('d M Y') }}</p>
            </div>
            <span class="badge bg-primary">Planifiée</span>
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-12 text-slate-400">
            <span class="material-symbols-outlined text-5xl mb-3">event_available</span>
            <p class="text-sm font-medium">Aucune maintenance planifiée</p>
        </div>
        @endforelse
    </div>
</div>
