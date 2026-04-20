@extends('layouts.app')

@section('title', 'Technician Dashboard')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Technician Dashboard</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Assigned support and intervention queue</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Track your workload, update status, and keep maintenance notes current.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Assigned Tickets', 'value' => $kpis['assigned_tickets']],
                ['label' => 'Open Tickets', 'value' => $kpis['open_tickets']],
                ['label' => 'Resolved Tickets', 'value' => $kpis['resolved_tickets']],
                ['label' => 'Logged Interventions', 'value' => $kpis['logged_interventions']],
            ] as $card)
                <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <p class="mt-4 text-4xl font-black text-slate-900 dark:text-white">{{ number_format($card['value']) }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">My tickets</h2>
                    <a href="{{ route('admin.tickets.index') }}" class="text-sm font-semibold text-brand-600">Open ticket list</a>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Ticket</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Subject</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Priority</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($myTickets as $ticket)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">
                                        <a href="{{ route('admin.tickets.show', $ticket) }}">{{ $ticket->numero }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $ticket->sujet }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ ucfirst($ticket->priorite) }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Interventions</h2>
                    <a href="{{ route('admin.interventions.index') }}" class="text-sm font-semibold text-brand-600">All interventions</a>
                </div>
                <div class="mt-5 space-y-4">
                    @foreach ($myInterventions as $intervention)
                        <div class="rounded-2xl border border-slate-200 px-4 py-4 dark:border-slate-800">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $intervention->ticket?->numero }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $intervention->ticket?->sujet }}</p>
                                </div>
                                <span class="rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700 dark:bg-brand-950/70 dark:text-brand-300">{{ $intervention->temps_formate }}</span>
                            </div>
                            <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">{{ \Illuminate\Support\Str::limit($intervention->travaux, 120) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Maintenance history</h2>
                <a href="{{ route('admin.maintenance-history') }}" class="text-sm font-semibold text-brand-600">History page</a>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($maintenanceHistory as $maintenance)
                    <div class="rounded-2xl bg-slate-50 p-4 dark:bg-slate-900">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">{{ $maintenance->type }}</p>
                        <p class="mt-2 font-semibold text-slate-900 dark:text-white">{{ $maintenance->actif?->code_inventaire }}</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $maintenance->date_prevue?->format('d/m/Y') }}</p>
                        <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">{{ $maintenance->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
