@extends('layouts.admin-new')

@section('title', 'Rapport des Tickets')
@section('page-title', 'Analyse des Tickets de Support')

@section('content')
<div class="space-y-6">
    <!-- Report Controls -->
    <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h5 class="font-semibold text-slate-900 dark:text-white">Analyse des Tickets</h5>
            <p class="text-sm text-slate-500 dark:text-slate-400">Généré le {{ now()->format('d/m/Y H:i') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <form method="GET" class="flex items-center gap-2">
                <input type="date" name="date_debut" class="px-3 py-1.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500" value="{{ request('date_debut', now()->subDays(30)->format('Y-m-d')) }}">
                <span class="text-slate-400">au</span>
                <input type="date" name="date_fin" class="px-3 py-1.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500" value="{{ request('date_fin', now()->format('Y-m-d')) }}">
                <button type="submit" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    Appliquer
                </button>
            </form>
            <button type="button" onclick="window.print()" class="px-4 py-1.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">print</span>
                Imprimer
            </button>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">confirmation_number</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Tickets</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Résolus</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $stats['resolus'] }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center text-amber-600 dark:text-amber-400">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">En Cours</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $stats['en_cours'] }}</h3>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-lg flex items-center justify-center text-rose-600 dark:text-rose-400">
                <span class="material-symbols-outlined text-2xl">error</span>
            </div>
            <div>
                <p class="text-sm text-slate-500 dark:text-slate-400">Ouverts</p>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $stats['ouverts'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Efficiency Metrics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-center">
            <h3 class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ round($stats['temps_moyen_resolution'] / 60, 1) }}h</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-medium">Temps moyen de résol.</p>
        </div>
        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-center">
            <h3 class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['total'] > 0 ? round(($stats['resolus'] / $stats['total']) * 100, 1) : 0 }}%</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-medium">Taux de résolution</p>
        </div>
        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-center">
            <h3 class="text-lg font-bold text-amber-600 dark:text-amber-400">{{ $highPriority }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-medium">Priorité Haute/Urgente</p>
        </div>
        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700 text-center">
            <h3 class="text-lg font-bold text-cyan-600 dark:text-cyan-400">{{ $newLast7 }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 uppercase font-medium">Nouveaux (7j)</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Par Statut</div>
            <div class="p-5 h-64"><canvas id="statusChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Par Priorité</div>
            <div class="p-5 h-64"><canvas id="priorityChart"></canvas></div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Tendance (30j)</div>
            <div class="p-5 h-64"><canvas id="trendChart"></canvas></div>
        </div>
    </div>

    <!-- Detailed Ticket List -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
            <h6 class="font-semibold text-slate-900 dark:text-white">Liste Détaillée des Tickets</h6>
            <a href="{{ route('admin.tickets.export', request()->query()) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-lg">download</span>
                Exporter CSV
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/50">
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Ticket #</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Sujet</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Statut</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Priorité</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Créé par</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Assigné à</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Création</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">Résol.</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->numero }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ Str::limit($ticket->sujet, 40) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $statusColor = match($ticket->statut) {
                                    'ouvert' => 'text-rose-600 bg-rose-50 dark:bg-rose-900/20',
                                    'en_cours' => 'text-blue-600 bg-blue-50 dark:bg-blue-900/20',
                                    'resolu' => 'text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20',
                                    'ferme' => 'text-slate-600 bg-slate-100 dark:bg-slate-700',
                                    default => 'text-slate-600 bg-slate-100'
                                };
                            @endphp
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $statusColor }}">
                                {{ str_replace('_', ' ', $ticket->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @php
                                $priorityColor = match($ticket->priorite) {
                                    'urgente' => 'text-red-700',
                                    'haute' => 'text-orange-700',
                                    'moyenne' => 'text-blue-700',
                                    'basse' => 'text-slate-600',
                                    default => 'text-slate-600'
                                };
                            @endphp
                            <span class="font-medium {{ $priorityColor }}">{{ ucfirst($ticket->priorite) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $ticket->createur->full_name ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-300">{{ $ticket->assigneA->full_name ?? 'Non assigné' }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">
                            {{ $ticket->statut == 'resolu' || $ticket->statut == 'ferme' ? $ticket->updated_at->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-6 py-10 text-center text-slate-500 italic">Aucun ticket trouvé.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tickets->hasPages())
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">{{ $tickets->links() }}</div>
        @endif
    </div>

    <!-- SLA Compliance -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 font-semibold text-slate-900 dark:text-white">Conformité SLA</div>
        <div class="p-5 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Temps de Réponse</span>
                        <span class="text-slate-900 dark:text-white font-bold">75%</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-3 flex overflow-hidden">
                        <div class="bg-emerald-500 h-full" style="width: 75%"></div>
                        <div class="bg-rose-500 h-full" style="width: 25%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-slate-600 dark:text-slate-400 font-medium">Temps de Résolution</span>
                        <span class="text-slate-900 dark:text-white font-bold">68%</span>
                    </div>
                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-3 flex overflow-hidden">
                        <div class="bg-emerald-500 h-full" style="width: 68%"></div>
                        <div class="bg-rose-500 h-full" style="width: 32%"></div>
                    </div>
                </div>
            </div>
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-xl border border-blue-100 dark:border-blue-800 text-sm">
                <h6 class="font-bold text-blue-800 dark:text-blue-300 mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">info</span>
                    Objectifs SLA
                </h6>
                <ul class="space-y-2 text-blue-700 dark:text-blue-400">
                    <li>• <strong>Réponse:</strong> 4h pour priorité haute, 24h pour normale.</li>
                    <li>• <strong>Résolution:</strong> 24h pour urgente, 72h pour normale.</li>
                    <li class="mt-4 pt-2 border-t border-blue-200 dark:border-blue-800">
                        Période actuelle: {{ request('date_debut', now()->subDays(30)->format('d/m/Y')) }} - {{ request('date_fin', now()->format('d/m/Y')) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#94a3b8' : '#64748b';
    Chart.defaults.font.family = 'Inter, sans-serif';

    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Ouvert', 'En cours', 'Résolu', 'Fermé'],
            datasets: [{
                data: [{{ $statusData['ouvert'] ?? 0 }}, {{ $statusData['en_cours'] ?? 0 }}, {{ $statusData['resolu'] ?? 0 }}, {{ $statusData['ferme'] ?? 0 }}],
                backgroundColor: ['#ef4444', '#3b82f6', '#10b981', '#64748b']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } } }
    });
    
    new Chart(document.getElementById('priorityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Basse', 'Moyenne', 'Haute', 'Urgente'],
            datasets: [{
                data: [{{ $priorityData['basse'] ?? 0 }}, {{ $priorityData['moyenne'] ?? 0 }}, {{ $priorityData['haute'] ?? 0 }}, {{ $priorityData['urgente'] ?? 0 }}],
                backgroundColor: ['#94a3b8', '#3b82f6', '#f59e0b', '#dc2626']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, cutout: '70%', plugins: { legend: { position: 'bottom', labels: { usePointStyle: true } } } }
    });
    
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($trendLabels ?? []).map(d => d.substring(5)),
            datasets: [{
                label: 'Tickets créés',
                data: @json($trendCounts ?? []),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3,
                fill: true,
                pointRadius: 0,
                pointHoverRadius: 5
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false, 
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }
        }
    });
</script>
@endpush
@endsection

