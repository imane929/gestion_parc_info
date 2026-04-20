@extends('layouts.admin-new')

@section('title', 'Rapport d\'Inventaire')
@section('page-title', 'Inventaire Complet des Actifs')

@section('content')
<div class="space-y-6">
    <!-- Report Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h5 class="font-semibold text-slate-900 dark:text-white">Inventaire Global des Actifs</h5>
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
                <span class="material-symbols-outlined text-2xl">inventory_2</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Actifs</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $actifsParType->sum() }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">verified</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Bon État</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ ($actifsParEtat['bon'] ?? 0) + ($actifsParEtat['neuf'] ?? 0) }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">warning</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">État Moyen</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $actifsParEtat['moyen'] ?? 0 }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Hors Service</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ ($actifsParEtat['mauvais'] ?? 0) + ($actifsParEtat['hors_service'] ?? 0) }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Par Type</div>
            <div class="p-5 h-64"><canvas id="typeChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Par État</div>
            <div class="p-5 h-64"><canvas id="stateChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Par Âge</div>
            <div class="p-5 h-64"><canvas id="ageChart"></canvas></div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- By Type Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Répartition par Type</div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Type</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Nombre</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Pourcentage</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($actifsParType as $type => $count)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ ucfirst($type) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $count }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-blue-600 h-full" style="width: {{ ($count / $actifsParType->sum()) * 100 }}%"></div>
                                    </div>
                                    <span class="text-xs font-medium text-slate-500">{{ round(($count / $actifsParType->sum()) * 100, 1) }}%</span>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- By Location Table -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Répartition par Localisation</div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Localisation</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Total</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">PC</th>
                            <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase border-b border-slate-200 dark:border-slate-700">Serv.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @foreach($actifsParLocalisation as $location => $counts)
                        @php
                            $counts = is_array($counts) ? $counts : ['total' => $counts, 'pc' => 0, 'serveur' => 0];
                        @endphp
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $location }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300 font-bold">{{ is_array($counts) ? array_sum($counts) : ($counts['total'] ?? 0) }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $counts['pc'] ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm text-slate-500">{{ $counts['serveur'] ?? 0 }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Age and Lifecycle -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-5">
            <h6 class="font-semibold text-slate-900 dark:text-white mb-4">Répartition par Âge</h6>
            <div class="space-y-4">
                @foreach($actifsParAge as $range => $count)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-slate-600 dark:text-slate-400">{{ $range }}</span>
                        <span class="text-slate-900 dark:text-white font-bold">{{ $count }} ({{ round(($count / $actifsParAge->sum()) * 100, 1) }}%)</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                        <div class="bg-blue-500 h-full" style="width: {{ ($count / $actifsParAge->sum()) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800 p-5">
            <h6 class="font-bold text-blue-800 dark:text-blue-300 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">info</span>
                Résumé du Cycle de Vie
            </h6>
            <div class="space-y-4 text-sm text-blue-700 dark:text-blue-400">
                <div class="flex justify-between items-center p-3 bg-white/50 dark:bg-white/5 rounded-lg">
                    <span>Âge moyen des actifs:</span>
                    <span class="font-bold text-lg">3.2 ans</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white/50 dark:bg-white/5 rounded-lg">
                    <span>Actifs de moins de 3 ans:</span>
                    <span class="font-bold text-lg text-emerald-600">{{ ($actifsParAge['< 1 an'] ?? 0) + ($actifsParAge['1-3 ans'] ?? 0) }}</span>
                </div>
                <div class="flex justify-between items-center p-3 bg-white/50 dark:bg-white/5 rounded-lg">
                    <span>Actifs de plus de 5 ans (à remplacer):</span>
                    <span class="font-bold text-lg text-rose-600">{{ $actifsParAge['> 5 ans'] ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    Chart.defaults.font.family = 'Inter, sans-serif';

    new Chart(document.getElementById('typeChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($actifsParType->keys()->map(fn($t) => ucfirst($t))) !!},
            datasets: [{
                data: {!! json_encode($actifsParType->values()) !!},
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } } }
    });
    
    new Chart(document.getElementById('stateChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($actifsParEtat->keys()->map(fn($e) => ucfirst($e))) !!},
            datasets: [{
                data: {!! json_encode($actifsParEtat->values()) !!},
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#64748b']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } } }
    });
    
    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($actifsParAge->keys()) !!},
            datasets: [{
                label: 'Nombre d\'actifs',
                data: {!! json_encode($actifsParAge->values()) !!},
                backgroundColor: '#3b82f6',
                borderRadius: 4
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }
        }
    });
    
    document.getElementById('exportCSV').addEventListener('click', function() {
        let csv = 'Type,Nombre,Pourcentage\n';
        @foreach($actifsParType as $type => $count)
            csv += '{{ $type }},{{ $count }},{{ round(($count / $actifsParType->sum()) * 100, 1) }}%\n';
        @endforeach
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'rapport_inventaire_{{ now()->format('Y-m-d') }}.csv';
        a.click();
    });
</script>
@endpush
@endsection
