@extends('layouts.app')

@section('title', 'IT Manager Dashboard')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Gestionnaire IT</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Asset management center</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Focus on inventory coverage, assignments, locations, and reporting.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Total Assets', 'value' => $kpis['total_assets']],
                ['label' => 'Assigned Assets', 'value' => $kpis['assigned_assets']],
                ['label' => 'Unassigned Assets', 'value' => $kpis['unassigned_assets']],
                ['label' => 'Planned Maintenance', 'value' => $kpis['planned_maintenance']],
            ] as $card)
                <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <p class="mt-4 text-4xl font-black text-slate-900 dark:text-white">{{ number_format($card['value']) }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Assets by type</h2>
                <div class="mt-6 h-72"><canvas id="managerAssetsType"></canvas></div>
            </div>
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Assets by location</h2>
                <div class="mt-6 h-72"><canvas id="managerAssetsLocation"></canvas></div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Asset table</h2>
                    <a href="{{ route('admin.actifs.index') }}" class="text-sm font-semibold text-brand-600">Open full assets page</a>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Asset</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Type</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Location</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">User</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($assets as $asset)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $asset->code_inventaire }} - {{ $asset->marque }} {{ $asset->modele }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ ucfirst($asset->type) }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $asset->etat)) }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $asset->localisation?->nom_complet ?? 'Unassigned' }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $asset->utilisateurAffecte?->full_name ?? 'In stock' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Assignments</h2>
                        <a href="{{ route('admin.assignments') }}" class="text-sm font-semibold text-brand-600">History</a>
                    </div>
                    <div class="mt-5 space-y-3">
                        @foreach ($assignments->take(5) as $assignment)
                            <div class="rounded-2xl border border-slate-200 px-4 py-3 dark:border-slate-800">
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $assignment->actif?->code_inventaire }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $assignment->utilisateur?->full_name }}</p>
                                <p class="mt-1 text-xs text-slate-400">{{ $assignment->date_debut?->format('d/m/Y') }} to {{ $assignment->date_fin?->format('d/m/Y') ?? 'Present' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Locations</h2>
                        <a href="{{ route('admin.localisations.index') }}" class="text-sm font-semibold text-brand-600">Manage</a>
                    </div>
                    <div class="mt-5 space-y-3">
                        @foreach ($locations as $location)
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-900">
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $location->nom_complet }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $location->site }}</p>
                                </div>
                                <span class="text-sm font-bold text-brand-600">{{ $location->actifs_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('managerAssetsType'), {
            type: 'bar',
            data: {
                labels: @json(array_keys($assetsByType)),
                datasets: [{ data: @json(array_values($assetsByType)), backgroundColor: '#10b981', borderRadius: 12 }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('managerAssetsLocation'), {
            type: 'pie',
            data: {
                labels: @json(array_keys($assetsByLocation)),
                datasets: [{ data: @json(array_values($assetsByLocation)), backgroundColor: ['#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#14b8a6'] }]
            },
            options: { maintainAspectRatio: false }
        });
    </script>
@endpush
