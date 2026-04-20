@extends('layouts.admin-new')

@section('title', 'Rapport personnalisé')
@section('page-title', 'Rapport personnalisé')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Rapport personnalisé</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Affiche les données pour le type de rapport sélectionné.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors">Retour aux rapports</a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6">
        <div class="mb-5">
            <p class="text-sm text-slate-500 dark:text-slate-400">Type de rapport :</p>
            <h3 class="text-xl font-semibold text-slate-900 dark:text-white">{{ ucfirst($type) }}</h3>
        </div>

        @if($type === 'actifs')
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Code</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Type</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Marque</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">État</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Localisation</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($data['actifs'] as $actif)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-white">{{ $actif->code_inventaire }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ ucfirst($actif->type) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $actif->marque }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ ucfirst($actif->etat) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $actif->localisation->nom_complet ?? 'Non localisé' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">Aucun actif trouvé pour ce rapport.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @elseif($type === 'tickets')
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-700/50">
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">#</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Sujet</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Priorité</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Statut</th>
                            <th class="px-4 py-3 text-xs font-semibold uppercase text-slate-500 dark:text-slate-400">Créé le</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        @forelse($data['tickets'] as $ticket)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 text-sm text-slate-900 dark:text-white">#{{ $ticket->id }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $ticket->sujet ?? $ticket->titre }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ ucfirst($ticket->priorite) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600 dark:text-slate-300">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-slate-500 dark:text-slate-400">Aucun ticket trouvé pour ce rapport.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 p-6 text-slate-700 dark:text-slate-200">
                <p class="text-base font-medium">Ce type de rapport est bien pris en charge, mais il n'y a pas encore de données HTML disponibles pour <strong>{{ $type }}</strong>.</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-3">Utilisez le format CSV ou revenez plus tard lorsque la liste de données sera générée.</p>
            </div>
        @endif
    </div>
</div>
@endsection
