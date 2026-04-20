@extends('layouts.app')

@section('title', 'Maintenance History')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Maintenance History</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Interventions and preventive maintenance log</h1>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Interventions</h2>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Date</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Ticket</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Asset</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($interventions as $intervention)
                                <tr>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $intervention->date?->format('d/m/Y') }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $intervention->ticket?->numero }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $intervention->ticket?->actif?->code_inventaire ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ \Illuminate\Support\Str::limit($intervention->travaux, 80) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-10 text-center text-slate-500">No interventions logged.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $interventions->links() }}</div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Preventive maintenance</h2>
                <div class="mt-5 space-y-4">
                    @forelse ($maintenances as $maintenance)
                        <div class="rounded-2xl border border-slate-200 px-4 py-4 dark:border-slate-800">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $maintenance->actif?->code_inventaire }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ ucfirst($maintenance->type) }}</p>
                                </div>
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600 dark:bg-slate-900 dark:text-slate-300">{{ ucfirst($maintenance->statut) }}</span>
                            </div>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">{{ $maintenance->description }}</p>
                            <p class="mt-2 text-xs text-slate-400">{{ $maintenance->date_prevue?->format('d/m/Y') }}</p>
                        </div>
                    @empty
                        <p class="rounded-2xl bg-slate-50 px-4 py-6 text-sm text-slate-500 dark:bg-slate-900 dark:text-slate-400">No preventive maintenance found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
