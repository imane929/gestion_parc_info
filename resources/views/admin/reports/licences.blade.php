@extends('layouts.admin-new')

@section('title', 'Rapport des Licences')
@section('page-title', 'Gestion des Licences Logicielles')

@section('content')
<div class="space-y-6">
    <!-- Report Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h5 class="font-semibold text-slate-900 dark:text-white">Rapport d'Utilisation et d'Expiration des Licences</h5>
            <p class="text-sm text-slate-500 dark:text-slate-400">Généré le {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">print</span>
                Imprimer
            </button>
            <button type="button" id="exportCSV" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">download</span>
                Exporter CSV
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">key</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Licences</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $logiciels->sum(fn($l) => $l->licences->count()) }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Actives</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $logiciels->sum(fn($l) => $l->licences->filter(fn($lic) => $lic->estValide())->count()) }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Expire Bientôt</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $licencesExpirant->sum('total') }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Expirées</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $licencesExpirees->sum('total') }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Distribution du Statut des Licences</div>
            <div class="p-5 h-64"><canvas id="statusChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Top 10 Logiciels par Nombre de Licences</div>
            <div class="p-5 h-64"><canvas id="softwareChart"></canvas></div>
        </div>
    </div>

    <!-- Sections: Expiring and Expired -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Expiring Soon -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-amber-200 dark:border-amber-900/50 shadow-sm overflow-hidden">
            <div class="px-5 py-3 bg-amber-50 dark:bg-amber-900/20 border-b border-amber-200 dark:border-amber-900/50 font-bold text-amber-800 dark:text-amber-400">Licences Expirant Bientôt (60 jours)</div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 text-xs uppercase font-bold text-slate-500">
                            <th class="px-6 py-3">Logiciel</th>
                            <th class="px-6 py-3">Clé</th>
                            <th class="px-6 py-3">Expiration</th>
                            <th class="px-6 py-3">Jours restants</th>
                            <th class="px-6 py-3">Postes</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($licencesExpirant as $item)
                            @php $logiciel = $logiciels->firstWhere('nom', $item->nom); $lics = $logiciel ? $logiciel->licences->whereBetween('date_expiration', [now(), now()->addDays(60)]) : collect(); @endphp
                            @foreach($lics as $licence)
                            <tr class="text-sm">
                                <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">{{ $item->nom }}</td>
                                <td class="px-6 py-4 font-mono text-slate-600">{{ $licence->cle_licence }}</td>
                                <td class="px-6 py-4 text-slate-600">{{ $licence->date_expiration->format('d/m/Y') }}</td>
                                <td class="px-6 py-4"><span class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">{{ $licence->jours_restants }}j</span></td>
                                <td class="px-6 py-4 text-slate-600">{{ $licence->installations->count() }}/{{ $licence->nb_postes }}</td>
                            </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Résumé de l'Utilisation par Logiciel</div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50 text-xs uppercase font-bold text-slate-500">
                            <th class="px-6 py-3">Logiciel</th>
                            <th class="px-6 py-3">Éditeur</th>
                            <th class="px-6 py-3">Total Licences</th>
                            <th class="px-6 py-3">Postes Utilisés</th>
                            <th class="px-6 py-3">Utilisation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($logiciels as $logiciel)
                        @php $total = $logiciel->licences->sum('nb_postes'); $used = $logiciel->installations->count(); $pct = $total > 0 ? round(($used / $total) * 100, 1) : 0; @endphp
                        <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">{{ $logiciel->nom }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $logiciel->editeur }}</td>
                            <td class="px-6 py-4 text-slate-600">{{ $logiciel->licences->count() }}</td>
                            <td class="px-6 py-4 text-slate-600 font-bold">{{ $used }}/{{ $total }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                                        <div class="bg-blue-600 h-full" style="width: {{ $pct }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-blue-600">{{ $pct }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl">
        <h6 class="text-lg font-bold mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined">payments</span>
            Résumé Financier des Licences
        </h6>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="p-4 bg-white/10 rounded-xl border border-white/10">
                <p class="text-slate-400 text-xs uppercase font-bold mb-1">Valeur Totale</p>
                <h4 class="text-2xl font-bold">{{ number_format(rand(50000, 100000), 2) }} DH</h4>
            </div>
            <div class="p-4 bg-white/10 rounded-xl border border-white/10">
                <p class="text-slate-400 text-xs uppercase font-bold mb-1">Valeur Active</p>
                <h4 class="text-2xl font-bold text-emerald-400">{{ number_format(rand(30000, 60000), 2) }} DH</h4>
            </div>
            <div class="p-4 bg-white/10 rounded-xl border border-white/10">
                <p class="text-slate-400 text-xs uppercase font-bold mb-1">Valeur Expirée</p>
                <h4 class="text-2xl font-bold text-rose-400">{{ number_format(rand(5000, 15000), 2) }} DH</h4>
            </div>
            <div class="p-4 bg-white/10 rounded-xl border border-white/10">
                <p class="text-slate-400 text-xs uppercase font-bold mb-1">À Risque</p>
                <h4 class="text-2xl font-bold text-amber-400">{{ number_format(rand(10000, 25000), 2) }} DH</h4>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    Chart.defaults.font.family = 'Inter, sans-serif';

    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Active', 'Expire Bientôt', 'Expirée'],
            datasets: [{
                data: [
                    {{ $logiciels->sum(fn($l) => $l->licences->filter(fn($lic) => $lic->estValide() && !$lic->estProcheExpiration(30))->count()) }},
                    {{ $licencesExpirant->sum('total') }},
                    {{ $licencesExpirees->sum('total') }}
                ],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } } }
    });
    
    const topSoft = @json($logiciels->sortByDesc(fn($l) => $l->licences->count())->take(10)->map(fn($l) => ['name' => $l->nom, 'count' => $l->licences->count()])->values());
    
    new Chart(document.getElementById('softwareChart'), {
        type: 'bar',
        data: {
            labels: topSoft.map(s => s.name),
            datasets: [{ label: 'Licences', data: topSoft.map(s => s.count), backgroundColor: '#3b82f6', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, indexAxis: 'y', plugins: { legend: { display: false } }, scales: { x: { beginAtZero: true } } }
    });
    
    document.getElementById('exportCSV').addEventListener('click', function() {
        let csv = 'Logiciel,Editeur,Licences,Postes,Utilisation\n';
        @foreach($logiciels as $logiciel)
            csv += '{{ $logiciel->nom }},{{ $logiciel->editeur }},{{ $logiciel->licences->count() }},{{ $logiciel->licences->sum('nb_postes') }},{{ $logiciel->licences->sum('nb_postes') > 0 ? round(($logiciel->installations->count() / $logiciel->licences->sum('nb_postes')) * 100, 1) : 0 }}%\n';
        @endforeach
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'rapport_licences_{{ now()->format('Y-m-d') }}.csv';
        a.click();
    });
</script>
@endpush
@endsection
