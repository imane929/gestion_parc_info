@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-brand-600">Global Search</p>
            <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">Results for "{{ $term }}"</h1>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Assets</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($assets as $asset)
                        <a href="{{ route('admin.actifs.show', $asset) }}" class="block rounded-2xl border border-slate-200 px-4 py-4 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $asset->code_inventaire }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $asset->marque }} {{ $asset->modele }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">No asset matches.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Tickets</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($tickets as $ticket)
                        <a href="{{ route('admin.tickets.show', $ticket) }}" class="block rounded-2xl border border-slate-200 px-4 py-4 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $ticket->numero }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $ticket->sujet }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">No ticket matches.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Users</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($users as $resultUser)
                        <a href="{{ route('admin.utilisateurs.edit', $resultUser) }}" class="block rounded-2xl border border-slate-200 px-4 py-4 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $resultUser->full_name }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $resultUser->email }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">No user matches.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-3xl border border-white/70 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-950">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Software</h2>
                <div class="mt-5 space-y-3">
                    @forelse ($software as $app)
                        <a href="{{ route('admin.logiciels.edit', $app) }}" class="block rounded-2xl border border-slate-200 px-4 py-4 transition hover:bg-slate-50 dark:border-slate-800 dark:hover:bg-slate-900">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $app->nom }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $app->version }} - {{ $app->editeur }}</p>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">No software matches.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
