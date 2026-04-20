<div class="grid grid-cols-2 lg:grid-cols-6 gap-3 lg:gap-4 mb-4 lg:mb-6">
    <a href="{{ route('admin.actifs.index') }}" class="stat-card bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow text-decoration-none">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">computer</span>
            </div>
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total_actifs'] ?? $actifs->total() ?? 0 }}</h3>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Total Assets</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.actifs.index', ['affectation' => 'avec']) }}" class="stat-card bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow text-decoration-none">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
            </div>
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['actifs_affectes'] ?? $actifs->whereNotNull('utilisateur_affecte_id')->count() ?? 0 }}</h3>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">In Use</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.actifs.index', ['affectation' => 'sans']) }}" class="stat-card bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow text-decoration-none">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">inventory_2</span>
            </div>
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['actifs_en_stock'] ?? $actifs->whereNull('utilisateur_affecte_id')->count() ?? 0 }}</h3>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">In Store</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.actifs.index', ['etat' => 'mauvais']) }}" class="stat-card bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow text-decoration-none">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400">build</span>
            </div>
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['actifs_en_repair'] ?? ($actifs->where('etat', 'mauvais')->count() + $actifs->where('etat', 'hors_service')->count()) ?? 0 }}</h3>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">In Repair</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.actifs.index') }}?garantie=valide" class="stat-card bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow text-decoration-none">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">verified_user</span>
            </div>
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['sous_garantie'] ?? $actifs->filter(function($a) { return $a->garantie_fin && \Carbon\Carbon::parse($a->garantie_fin) > now(); })->count() ?? 0 }}</h3>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Under Warranty</p>
            </div>
        </div>
    </a>
    
    <a href="{{ route('admin.actifs.index') }}?garantie=expiree" class="stat-card bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 hover:shadow-md transition-shadow text-decoration-none">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">warning</span>
            </div>
            <div>
                <h3 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['garantie_expiree'] ?? $actifs->filter(function($a) { return $a->garantie_fin && \Carbon\Carbon::parse($a->garantie_fin) <= now(); })->count() ?? 0 }}</h3>
                <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Warranty Expired</p>
            </div>
        </div>
    </a>
</div>

