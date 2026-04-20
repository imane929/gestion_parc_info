@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">User Dashboard</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Your assets and support requests</h1>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">A simple view for tracking assigned equipment and current ticket progress.</p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'My Assets', 'value' => $kpis['my_assets']],
                ['label' => 'Open Tickets', 'value' => $kpis['my_open_tickets']],
                ['label' => 'Resolved Tickets', 'value' => $kpis['my_resolved_tickets']],
                ['label' => 'Unread Notifications', 'value' => $kpis['unread_notifications']],
            ] as $card)
                <div class="rounded-3xl border border-white/70 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                    <p class="text-sm font-semibold text-slate-500 dark:text-slate-400">{{ $card['label'] }}</p>
                    <p class="mt-4 text-4xl font-black text-slate-900 dark:text-white">{{ number_format($card['value']) }}</p>
                </div>
            @endforeach
        </div>

        <div class="grid gap-6 xl:grid-cols-3">
            <div class="xl:col-span-1 rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">My assets</h2>
                    <a href="{{ route('admin.my-assets') }}" class="text-sm font-semibold text-brand-600">Full list</a>
                </div>
                <div class="mt-5 space-y-4">
                    @forelse ($myAssets as $asset)
                        <div class="rounded-2xl border border-slate-200 px-4 py-4 dark:border-slate-800">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $asset->marque }} {{ $asset->modele }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $asset->code_inventaire }}</p>
                            <p class="mt-2 text-sm text-slate-600 dark:text-slate-300">{{ $asset->localisation?->nom_complet ?? 'No location set' }}</p>
                        </div>
                    @empty
                        <p class="rounded-2xl bg-slate-50 px-4 py-6 text-sm text-slate-500 dark:bg-slate-900 dark:text-slate-400">No asset is currently assigned to you.</p>
                    @endforelse
                </div>
            </div>

            <div class="xl:col-span-2 rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">My tickets</h2>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.tickets.create') }}" class="rounded-2xl bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white">Create Ticket</a>
                        <a href="{{ route('admin.tickets.index') }}" class="rounded-2xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 dark:border-slate-700 dark:text-slate-200">View all</a>
                    </div>
                </div>
                <div class="mt-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Ticket</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Subject</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Asset</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th>
                                <th class="px-4 py-3 text-left font-semibold text-slate-500">Technician</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($myTickets as $ticket)
                                <tr>
                                    <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $ticket->numero }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $ticket->sujet }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $ticket->actif?->code_inventaire ?? 'General request' }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}</td>
                                    <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $ticket->assigneA?->full_name ?? 'Pending' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
