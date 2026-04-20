@extends('layouts.app')

@section('title', 'Assignments')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Assignments</p>
                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Asset assignment history</h1>
            </div>
        </div>

        <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
            <form class="mb-6 grid gap-3 md:grid-cols-[1fr_220px_auto]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search asset or user..." class="rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                <select name="status" class="rounded-2xl border border-slate-300 bg-slate-50 px-4 py-3 text-sm dark:border-slate-700 dark:bg-slate-900">
                    <option value="">All statuses</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="closed" @selected(request('status') === 'closed')>Closed</option>
                </select>
                <button type="submit" class="rounded-2xl bg-brand-600 px-4 py-3 text-sm font-semibold text-white">Filter</button>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm dark:divide-slate-800">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Asset</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">User</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Start Date</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">End Date</th>
                            <th class="px-4 py-3 text-left font-semibold text-slate-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($assignments as $assignment)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $assignment->actif?->code_inventaire }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $assignment->actif?->marque }} {{ $assignment->actif?->modele }}</p>
                                </td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $assignment->utilisateur?->full_name }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $assignment->date_debut?->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $assignment->date_fin?->format('d/m/Y') ?? 'Present' }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $assignment->date_fin ? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300' : 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300' }}">
                                        {{ $assignment->date_fin ? 'Closed' : 'Active' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-10 text-center text-slate-500">No assignments found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-5">{{ $assignments->links() }}</div>
        </div>
    </div>
@endsection
