@extends('layouts.admin-new')

@section('title', 'Tableau de Bord')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">Vue d'ensemble</h1>
            <p class="text-sm text-slate-500 dark:text-gray-400 mt-1">État actuel du parc informatique et du support pour <strong>{{ config('app.name', 'AssetFlow') }}</strong>.</p>
        </div>
        <div class="flex items-center gap-2">
            <div class="px-4 py-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-slate-100 dark:border-gray-700 text-sm font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-xl">event</span>
                {{ now()->locale('fr')->translatedFormat('d MMMM Y') }}
            </div>
        </div>
    </div>

    <!-- Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Assets -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center text-primary dark:text-blue-400">
                    <span class="material-symbols-outlined text-2xl">inventory_2</span>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">+2%</span>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $cardStats['total_actifs'] ?? 0 }}</div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Total Actifs</div>
        </div>

        <!-- Open Tickets -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-50 dark:bg-orange-900/20 rounded-xl flex items-center justify-center text-orange-600 dark:text-orange-400">
                    <span class="material-symbols-outlined text-2xl">confirmation_number</span>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase">Actuels</span>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $cardStats['tickets_ouverts'] ?? 0 }}</div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Tickets Ouverts</div>
        </div>

        <!-- Expiring Licenses -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 rounded-xl flex items-center justify-center text-red-600 dark:text-red-400">
                    <span class="material-symbols-outlined text-2xl">vpn_key</span>
                </div>
                <span class="text-xs font-bold text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">30 Jours</span>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $cardStats['licences_expirantes'] ?? 0 }}</div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Licences Expirantes</div>
        </div>

        <!-- Expiring Contracts -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-gray-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <span class="material-symbols-outlined text-2xl">history_edu</span>
                </div>
                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 px-2 py-1 rounded-full">60 Jours</span>
            </div>
            <div class="text-3xl font-extrabold text-slate-900 dark:text-white">{{ $cardStats['contrats_expirants'] ?? 0 }}</div>
            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Contrats Expirants</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Support Activity -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Activité Support</h3>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">6 Derniers Mois</span>
            </div>
            <div class="h-64">
                <canvas id="supportChart"></canvas>
            </div>
        </div>

        <!-- Assets Distribution -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-3xl shadow-sm border border-slate-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Répartition du Parc</h3>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Par Type</span>
            </div>
            <div class="h-64">
                <canvas id="assetsChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Lists Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Tickets -->
        <div class="lg:col-span-2">
            @include('partials.dashboard.recent-tickets')
        </div>

        <!-- Sidebar Actions/Stats -->
        <div class="space-y-8">
            @if($isAdmin ?? false)
            <div class="bg-gradient-to-br from-primary to-secondary p-8 rounded-3xl text-white shadow-xl shadow-blue-500/20">
                <h3 class="text-xl font-bold mb-2">Demandes d'accès</h3>
                <p class="text-blue-100 text-xs font-medium mb-6">Gérez les nouvelles demandes d'accès au système.</p>
                <div class="text-5xl font-extrabold mb-8">{{ $stats['demandes_acces_attente'] ?? 0 }}</div>
                <a href="{{ route('admin.demandes-acces.index') }}" class="flex items-center justify-center w-full py-4 bg-white text-primary rounded-2xl font-extrabold hover:bg-blue-50 transition-all shadow-sm">
                    Gérer les demandes
                </a>
            </div>
            @endif
            
            @if(($isAdmin ?? false) || ($isResponsableIT ?? false))
            @include('partials.dashboard.assets-by-location')
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const gridColor = isDark ? 'rgba(255,255,255,0.05)' : 'rgba(0,0,0,0.05)';

        const baseOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: textColor, padding: 20, font: { size: 12, weight: '600' } }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { color: textColor } },
                y: { grid: { color: gridColor }, ticks: { color: textColor } }
            }
        };

        // Support Activity Chart
        const ctxSupport = document.getElementById('supportChart')?.getContext('2d');
        if (ctxSupport) {
            new Chart(ctxSupport, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_keys($monthlyTickets ?? [])) !!},
                    datasets: [{
                        label: 'Tickets',
                        data: {!! json_encode(array_values($monthlyTickets ?? [])) !!},
                        borderColor: '#0058be',
                        backgroundColor: 'rgba(0, 88, 190, 0.05)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#0058be',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: baseOptions
            });
        }

        // Assets Distribution Chart
        const ctxAssets = document.getElementById('assetsChart')?.getContext('2d');
        if (ctxAssets) {
            new Chart(ctxAssets, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode(array_keys($assetsByType ?? [])) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($assetsByType ?? [])) !!},
                        backgroundColor: ['#0058be', '#6b38d4', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                        borderWidth: 0,
                        hoverOffset: 15
                    }]
                },
                options: {
                    ...baseOptions,
                    cutout: '75%',
                    scales: { x: { display: false }, y: { display: false } }
                }
            });
        }
    });
</script>
@endpush
