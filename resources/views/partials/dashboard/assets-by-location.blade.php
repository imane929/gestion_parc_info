<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
    <h3 class="text-lg font-bold mb-4">Actifs par localisation</h3>
    <div class="space-y-4">
        @forelse($actifsParLocalisation as $loc)
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400 text-sm">location_on</span>
                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $loc->nom }}</span>
            </div>
            <span class="font-bold text-slate-900 dark:text-white">{{ $loc->total }}</span>
        </div>
        <div class="h-1 bg-slate-100 rounded-full">
            <div class="bg-blue-600 h-1 rounded-full" style="width: {{ ($loc->total / max(1, $stats['total_actifs'] ?? 1)) * 100 }}%"></div>
        </div>
        @empty
        <p class="text-center text-slate-500 py-4">Aucune donnée de localisation</p>
        @endforelse
    </div>
</div>
