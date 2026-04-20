@extends('layouts.app')

@section('title', 'Analytics Dashboard')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Analytics Dashboard</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Performance, maintenance cost, and failure trends</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Live metrics driven by interventions, contracts, and ticket history.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">Maintenance Cost</p>
                <p class="mt-4 text-4xl font-black text-slate-900 dark:text-white">{{ number_format($maintenanceCost, 2) }} DH</p>
            </div>
            @foreach ($statusMetrics as $label => $value)
                <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Str::headline($label) }}</p>
                    <p class="mt-4 text-4xl font-black text-slate-900 dark:text-white">{{ number_format($value) }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Ticket trend</h2>
                <div class="mt-6 h-72"><canvas id="analyticsTrend"></canvas></div>
            </div>
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Maintenance cost by provider</h2>
                <div class="mt-6 h-72"><canvas id="analyticsCost"></canvas></div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Failure rate by asset</h2>
                    <span class="text-sm text-slate-500 dark:text-slate-400">Top ticket volume</span>
                </div>
                <div class="mt-6 space-y-3">
                    @foreach ($failureRate as $asset)
                        <div class="flex items-center justify-between rounded-2xl bg-slate-50 px-4 py-3 dark:bg-slate-900">
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">{{ $asset->code_inventaire }}</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $asset->marque }} {{ $asset->modele }}</p>
                            </div>
                            <span class="rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-600 dark:bg-rose-950/50 dark:text-rose-300">{{ $asset->tickets_count }} tickets</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Technician performance</h2>
                    <span class="text-sm text-slate-500 dark:text-slate-400">Resolved vs assigned</span>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Technician</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Assigned</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Resolved</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Interventions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($technicianPerformance as $technician)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $technician->full_name }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $technician->total_tickets }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $technician->resolved_tickets }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $technician->total_interventions }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('analyticsTrend'), {
            type: 'line',
            data: {
                labels: @json($ticketsTrend['labels']),
                datasets: [{ label: 'Tickets', data: @json($ticketsTrend['values']), borderColor: '#2563eb', backgroundColor: 'rgba(37, 99, 235, 0.12)', fill: true, tension: 0.3 }]
            },
            options: { maintainAspectRatio: false }
        });

        new Chart(document.getElementById('analyticsCost'), {
            type: 'bar',
            data: {
                labels: @json($costByProvider->pluck('label')),
                datasets: [{ label: 'Cost', data: @json($costByProvider->pluck('total')), backgroundColor: '#0f766e', borderRadius: 12 }]
            },
            options: { maintainAspectRatio: false, plugins: { legend: { display: false } } }
        });
    </script>
@endpush
