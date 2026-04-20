@extends('layouts.app')

@section('title', 'Software & Licenses')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Software & Licenses</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Software inventory with expiration alerts</h1>
            </div>
            <div class="flex gap-3">
                <div class="rounded-2xl bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 dark:bg-rose-950/50 dark:text-rose-300">Expired: {{ $expiredCount }}</div>
                <div class="rounded-2xl bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-700 dark:bg-amber-950/50 dark:text-amber-300">Expiring soon: {{ $expiringCount }}</div>
            </div>
        </div>

        <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
            <form class="mb-6 grid gap-3 md:grid-cols-[1fr_220px_auto]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search software, version, or key..." class="rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                <select name="status" class="rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                    <option value="">All statuses</option>
                    <option value="expired" @selected(request('status') === 'expired')>Expired</option>
                    <option value="expiring" @selected(request('status') === 'expiring')>Expiring soon</option>
                </select>
                <button type="submit" class="rounded-2xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white">Filter</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Software</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Version</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">License Key</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Expiration</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Seats</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Alert</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($licenses as $license)
                            @php
                                $days = $license->jours_restants;
                                $alert = $days < 0 ? 'Expired' : ($days <= 30 ? 'Expiring soon' : 'Valid');
                            @endphp
                            <tr>
                                <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">{{ $license->logiciel?->nom }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $license->logiciel?->version }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ \Illuminate\Support\Str::limit($license->cle_licence, 20) }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $license->date_expiration?->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $license->nb_postes }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $days < 0 ? 'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300' : ($days <= 30 ? 'bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-300' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300') }}">
                                        {{ $alert }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-4 py-10 text-center text-slate-500">No licenses found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">{{ $licenses->links() }}</div>
        </div>
    </div>
@endsection
