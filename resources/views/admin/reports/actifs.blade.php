@extends('layouts.admin-new')

@section('title', 'Rapport des Actifs')
@section('page-title', 'Rapport des Actifs Informatiques')

@section('content')
<div class="space-y-6">
    <!-- Report Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Type d'Actif</label>
                <select name="type" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les Types</option>
                    <option value="pc" {{ request('type') == 'pc' ? 'selected' : '' }}>PC</option>
                    <option value="serveur" {{ request('type') == 'serveur' ? 'selected' : '' }}>Serveur</option>
                    <option value="imprimante" {{ request('type') == 'imprimante' ? 'selected' : '' }}>Imprimante</option>
                    <option value="reseau" {{ request('type') == 'reseau' ? 'selected' : '' }}>Réseau</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">État</label>
                <select name="etat" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Tous les États</option>
                    <option value="neuf" {{ request('etat') == 'neuf' ? 'selected' : '' }}>Neuf</option>
                    <option value="bon" {{ request('etat') == 'bon' ? 'selected' : '' }}>Bon</option>
                    <option value="moyen" {{ request('etat') == 'moyen' ? 'selected' : '' }}>Moyen</option>
                    <option value="mauvais" {{ request('etat') == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                    <option value="hors_service" {{ request('etat') == 'hors_service' ? 'selected' : '' }}>Hors Service</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Localisation</label>
                <select name="localisation_id" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Toutes les Localisations</option>
                    @foreach(\App\Models\Localisation::all() as $loc)
                        <option value="{{ $loc->id }}" {{ request('localisation_id') == $loc->id ? 'selected' : '' }}>{{ $loc->nom_complet }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">filter_alt</span>
                    Filtrer
                </button>
                <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined text-lg">print</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">desktop_windows</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Actifs</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $totalCount ?? $actifs->total() }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">En Utilisation</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $inUse ?? 0 }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">warehouse</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">En Stock</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $inStore ?? 0 }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400">
                <span class="material-symbols-outlined text-2xl">verified_user</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Sous Garantie</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $underWarranty ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                <h6 class="font-semibold text-slate-900 dark:text-white">Actifs par Type</h6>
            </div>
            <div class="p-5">
                <div class="h-64">
                    <canvas id="typeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700">
                <h6 class="font-semibold text-slate-900 dark:text-white">Actifs par État</h6>
            </div>
            <div class="p-5">
                <div class="h-64">
                    <canvas id="stateChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h6 class="font-semibold text-slate-900 dark:text-white">Liste Détaillée des Actifs</h6>
            <a href="{{ route('admin.actifs.export', request()->query()) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">download</span>
                Exporter CSV
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50">
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Code</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Type</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Marque/Modèle</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Série</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">État</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Localisation</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Affecté à</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Garantie</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($actifs as $actif)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $actif->code_inventaire }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-xs">{{ ucfirst($actif->type) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $actif->marque }} {{ $actif->modele }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400 font-mono">{{ $actif->numero_serie }}</td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $color = match($actif->etat) {
                                    'neuf' => 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20',
                                    'bon' => 'text-blue-600 bg-blue-50 dark:bg-blue-900/20',
                                    'moyen' => 'text-amber-600 bg-amber-50 dark:bg-amber-900/20',
                                    'mauvais' => 'text-rose-600 bg-rose-50 dark:bg-rose-900/20',
                                    'hors_service' => 'text-slate-600 bg-slate-100 dark:bg-slate-700',
                                    default => 'text-slate-600 bg-slate-100'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $color }}">
                                {{ str_replace('_', ' ', $actif->etat) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $actif->localisation->nom_complet ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $actif->utilisateurAffecte->full_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($actif->garantie_fin)
                                <span class="text-xs {{ $actif->garantieEstValide() ? 'text-emerald-600' : 'text-rose-600' }}">
                                    {{ $actif->garantie_fin->format('d/m/Y') }}
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400 italic">
                            Aucun actif trouvé correspondant à ces critères.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($actifs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
            {{ $actifs->links() }}
        </div>
        @endif
    </div>
</div>

@push('styles')
<style>
@media print {
    aside, header, form, .pagination, a[href*="export"] {
        display: none !important;
    }
    main {
        padding: 0 !important;
        margin: 0 !important;
    }
    body {
        background: white !important;
        color: black !important;
    }
    .bg-white, .dark\:bg-slate-800 {
        background: white !important;
        border: none !important;
        box-shadow: none !important;
    }
    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    th, td {
        border: 1px solid #ddd !important;
        padding: 8px !important;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart Defaults
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    Chart.defaults.font.family = 'Inter, sans-serif';

    // Assets by Type Chart
    const typeData = @json($typeData ?? []);
    if (Object.keys(typeData).length > 0) {
        new Chart(document.getElementById('typeChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(typeData).map(t => t.charAt(0).toUpperCase() + t.slice(1)),
                datasets: [{
                    data: Object.values(typeData),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20 }
                    }
                }
            }
        });
    }

    // Assets by State Chart
    const stateData = @json($stateData ?? []);
    if (Object.keys(stateData).length > 0) {
        new Chart(document.getElementById('stateChart'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(stateData).map(s => s.charAt(0).toUpperCase() + s.slice(1)),
                datasets: [{
                    data: Object.values(stateData),
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#64748b']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 20 }
                    }
                }
            }
        });
    }
</script>
@endpush
@endsection

