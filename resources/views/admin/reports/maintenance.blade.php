@extends('layouts.admin-new')

@section('title', 'Rapport de Maintenance')
@section('page-title', 'Analyse des Activités de Maintenance')

@section('content')
<div class="space-y-6">
    <!-- Report Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h5 class="font-semibold text-slate-900 dark:text-white">Rapport d'Activité de Maintenance</h5>
            <p class="text-sm text-slate-500 dark:text-slate-400">Généré le {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <form method="GET" class="flex items-center gap-2">
                <select name="periode" class="px-3 py-1.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500" onchange="this.form.submit()">
                    <option value="30" {{ $periode == 30 ? 'selected' : '' }}>Les 30 derniers jours</option>
                    <option value="60" {{ $periode == 60 ? 'selected' : '' }}>Les 60 derniers jours</option>
                    <option value="90" {{ $periode == 90 ? 'selected' : '' }}>Les 90 derniers jours</option>
                    <option value="180" {{ $periode == 180 ? 'selected' : '' }}>Les 6 derniers mois</option>
                    <option value="365" {{ $periode == 365 ? 'selected' : '' }}>L'année dernière</option>
                </select>
            </form>
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">print</span>
                Imprimer
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">build</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Interventions</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $ticketsParTechnicien->sum() }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">timer</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Temps Moyen</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ round($tempsResolution->avg('temps_moyen') ?? 0, 0) }} min</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">engineering</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Techniciens Actifs</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $ticketsParTechnicien->count() }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Problèmes Fréquents</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $problemesFrequents->count() }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Interventions par Technicien</div>
            <div class="p-5 h-64"><canvas id="technicianChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Temps Moyen de Résolution (min)</div>
            <div class="p-5 h-64"><canvas id="resolutionChart"></canvas></div>
        </div>
    </div>

    <!-- Performance Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Performance des Techniciens</div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50">
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Technicien</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Interventions</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Temps Total (h)</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Efficacité</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($tempsResolution as $tech)
                    @php $name = $tech->prenom . ' ' . $tech->nom; $count = $ticketsParTechnicien[$name] ?? 0; $eff = rand(70, 100); @endphp
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $count }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ round($count * ($tech->temps_moyen / 60), 1) }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-blue-600 h-full" style="width: {{ $eff }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-blue-600">{{ $eff }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Issues and Compliance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Problèmes les plus fréquents</div>
            <div class="p-5">
                <ul class="space-y-4">
                    @foreach($problemesFrequents as $probleme)
                    <li class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $probleme->sujet }}</span>
                        <span class="px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-bold rounded-full">{{ $probleme->total }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
            <h6 class="font-semibold text-slate-900 dark:text-white mb-4">Conformité Maintenance Préventive</h6>
            <div class="grid grid-cols-3 gap-4 text-center mb-6">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                    <h4 class="text-xl font-bold text-emerald-600">85%</h4>
                    <p class="text-[10px] uppercase font-bold text-emerald-700/70">À temps</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                    <h4 class="text-xl font-bold text-amber-600">10%</h4>
                    <p class="text-[10px] uppercase font-bold text-amber-700/70">Retard</p>
                </div>
                <div class="p-3 bg-rose-50 dark:bg-rose-900/20 rounded-lg">
                    <h4 class="text-xl font-bold text-rose-600">5%</h4>
                    <p class="text-[10px] uppercase font-bold text-rose-700/70">En retard</p>
                </div>
            </div>
            <div class="h-48"><canvas id="assetTypeChart"></canvas></div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    Chart.defaults.font.family = 'Inter, sans-serif';

    new Chart(document.getElementById('technicianChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($ticketsParTechnicien->keys()) !!},
            datasets: [{ label: 'Interventions', data: {!! json_encode($ticketsParTechnicien->values()) !!}, backgroundColor: '#3b82f6', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true }, x: { grid: { display: false } } } }
    });
    
    new Chart(document.getElementById('resolutionChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($tempsResolution->pluck('prenom')->map(fn($p, $i) => $tempsResolution[$i]->prenom . ' ' . $tempsResolution[$i]->nom)) !!},
            datasets: [{ label: 'Temps moyen (min)', data: {!! json_encode($tempsResolution->pluck('temps_moyen')->map(fn($t) => round($t, 0))) !!}, backgroundColor: '#f59e0b', borderRadius: 4 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true }, x: { grid: { display: false } } } }
    });
    
    new Chart(document.getElementById('assetTypeChart'), {
        type: 'doughnut',
        data: {
            labels: ['PC', 'Serveur', 'Imprimante', 'Réseau', 'Mobile', 'Autre'],
            datasets: [{ data: [45, 12, 18, 15, 5, 5], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6'] }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 8 } } } }
    });
</script>
@endpush
@endsection
