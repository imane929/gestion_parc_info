@extends('layouts.admin-new')

@section('title', 'Rapport des Contrats')
@section('page-title', 'Analyse des Contrats de Maintenance')

@section('content')
<div class="space-y-6">
    <!-- Report Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h5 class="font-semibold text-slate-900 dark:text-white">Rapport des Contrats et Prestataires</h5>
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
                <span class="material-symbols-outlined text-2xl">description</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Contrats</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $contrats->count() }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">verified</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Contrats Actifs</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $contratsParStatut['actifs'] }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Expire Bientôt</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $contratsExpirant->count() }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400">
                <span class="material-symbols-outlined text-2xl">cancel</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Expirés</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $contratsParStatut['expires'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts and Financials -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Répartition par Statut</div>
            <div class="p-5 h-64"><canvas id="statusChart"></canvas></div>
        </div>
        <div class="bg-slate-900 rounded-xl p-6 text-white shadow-xl flex flex-col justify-center">
            <div class="text-center">
                <span class="material-symbols-outlined text-5xl text-blue-400 mb-4">payments</span>
                <p class="text-slate-400 uppercase text-xs font-bold tracking-wider mb-2">Valeur Annuelle Totale</p>
                <h2 class="text-3xl font-black text-white">{{ number_format($valeurTotale, 2) }} DH</h2>
                <div class="mt-6 pt-6 border-t border-white/10 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400">Coût moyen / contrat:</span>
                        <span class="font-bold">{{ $contrats->count() > 0 ? number_format($valeurTotale / $contrats->count(), 2) : 0 }} DH</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed List -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Détails des Contrats de Maintenance</div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50 text-xs uppercase font-bold text-slate-500">
                        <th class="px-6 py-3">Réf/Titre</th>
                        <th class="px-6 py-3">Prestataire</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Période</th>
                        <th class="px-6 py-3">Statut</th>
                        <th class="px-6 py-3 text-right">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @foreach($contrats as $contrat)
                    @php 
                        $isExpired = $contrat->date_fin < now();
                        $isActive = $contrat->date_debut <= now() && $contrat->date_fin >= now();
                        $statusText = $isExpired ? 'Expiré' : ($isActive ? 'Actif' : 'Futur');
                        $statusClass = $isExpired ? 'text-rose-600 bg-rose-50' : ($isActive ? 'text-emerald-600 bg-emerald-50' : 'text-blue-600 bg-blue-50');
                    @endphp
                    <tr class="text-sm hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-900 dark:text-white">{{ $contrat->numero_contrat }}</div>
                            <div class="text-xs text-slate-500">{{ $contrat->titre }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">{{ $contrat->prestataire->nom }}</td>
                        <td class="px-6 py-4 text-slate-600">{{ ucfirst($contrat->type) }}</td>
                        <td class="px-6 py-4 text-slate-500 text-xs">
                            {{ $contrat->date_debut->format('d/m/Y') }} - {{ $contrat->date_fin->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-slate-900 dark:text-white">{{ number_format($contrat->montant, 2) }} DH</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    Chart.defaults.font.family = 'Inter, sans-serif';

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Actifs', 'Expirés', 'Futurs'],
            datasets: [{
                data: [{{ $contratsParStatut['actifs'] }}, {{ $contratsParStatut['expires'] }}, {{ $contratsParStatut['futurs'] }}],
                backgroundColor: ['#10b981', '#ef4444', '#3b82f6']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } } }
    });
</script>
@endpush
@endsection
