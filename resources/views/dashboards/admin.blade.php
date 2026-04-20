@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-2 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Admin Dashboard</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Full system overview</h1>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Monitor assets, assignments, maintenance, users, and system operations from one place.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.utilisateurs.index') }}" class="rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white dark:bg-white dark:text-slate-900">Manage users</a>
                <a href="{{ route('admin.reports.index') }}" class="rounded-2xl border border-slate-300 px-4 py-3 text-sm font-semibold text-slate-700 dark:border-slate-700 dark:text-slate-200">Open reports</a>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Total Assets', 'value' => $kpis['total_assets'], 'icon' => 'inventory_2'],
                ['label' => 'Total Users', 'value' => $kpis['total_users'], 'icon' => 'group'],
                ['label' => 'Open Tickets', 'value' => $kpis['open_tickets'], 'icon' => 'support_agent'],
                ['label' => 'Resolved Tickets', 'value' => $kpis['resolved_tickets'], 'icon' => 'task_alt'],
            ] as $card)
                <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                        <span class="material-symbols-outlined rounded-2xl bg-brand-50 p-3 text-brand-600 dark:bg-brand-950/70 dark:text-brand-300">{{ $card['icon'] }}</span>
                    </div>
                    <p class="mt-6 text-4xl font-black tracking-tight text-slate-900 dark:text-white">{{ number_format($card['value']) }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Assets by type</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Distribution across the inventory.</p>
                    </div>
                </div>
                <div class="mt-6 h-72"><canvas id="assetsTypeChart"></canvas></div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Tickets by status</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Service desk workload at a glance.</p>
                    </div>
                </div>
                <div class="mt-6 h-72"><canvas id="ticketStatusChart"></canvas></div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent activity</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Latest user and system events.</p>
                    </div>
                </div>
                <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead class="bg-slate-50 dark:bg-slate-900">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">User</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Action</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">When</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($recentActivities as $activity)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $activity->utilisateur?->full_name ?? 'System' }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $activity->action ?? $activity->description }}</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $activity->created_at?->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-4 py-8 text-center text-slate-500">No recent activity found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Settings snapshot</h2>
                    <div class="mt-5 space-y-4">
                        @foreach ($settingsSummary as $label => $value)
                            <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-900">
                                <span class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Str::headline($label) }}</span>
                                <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $value }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Top locations</h2>
                    <div class="mt-5 space-y-3">
                        @foreach ($locations as $location)
                            <div class="flex items-center justify-between rounded-2xl border border-slate-200 px-4 py-3 dark:border-slate-800">
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $location->nom_complet }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $location->site }}</p>
                                </div>
                                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700 dark:bg-brand-950/70 dark:text-brand-300">{{ $location->actifs_count }} assets</span>
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
        const assetLabels = @json(array_keys($assetsByType));
        const assetValues = @json(array_values($assetsByType));
        const ticketLabels = @json(array_keys($ticketsByStatus));
        const ticketValues = @json(array_values($ticketsByStatus));

        new Chart(document.getElementById('assetsTypeChart'), {
            type: 'bar',
            data: {
                labels: assetLabels,
                datasets: [{ label: 'Assets', data: assetValues, backgroundColor: '#2563eb', borderRadius: 12 }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });

        new Chart(document.getElementById('ticketStatusChart'), {
            type: 'doughnut',
            data: {
                labels: ticketLabels,
                datasets: [{ data: ticketValues, backgroundColor: ['#2563eb', '#f59e0b', '#14b8a6', '#10b981', '#64748b'] }]
            },
            options: { maintainAspectRatio: false }
        });
    </script>
@endpush
