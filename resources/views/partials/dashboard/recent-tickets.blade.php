<div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Tickets Récents</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Dernières demandes de support</p>
        </div>
        <a href="{{ route('admin.tickets.index') }}" class="flex items-center gap-1 text-sm font-medium text-primary hover:text-primary-dark transition-colors">
            Voir tout
            <span class="material-symbols-outlined text-base">arrow_forward</span>
        </a>
    </div>
    <div class="space-y-3">
        @forelse($ticketsRecents as $ticket)
        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="block p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors group">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 
                    @if($ticket->priorite == 'urgente') bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400
                    @elseif($ticket->priorite == 'haute') bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400
                    @else bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                    @endif">
                    <span class="material-symbols-outlined text-lg">confirmation_number</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="font-semibold text-slate-900 dark:text-white">#T-{{ $ticket->id }}</span>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded-full
                            @if($ticket->statut == 'ouvert') bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400
                            @elseif($ticket->statut == 'en_cours') bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400
                            @else bg-slate-100 text-slate-600 dark:bg-slate-600 dark:text-slate-300
                            @endif">
                            {{ str_replace('_', ' ', $ticket->statut) }}
                        </span>
                    </div>
                    <h4 class="font-medium text-slate-700 dark:text-slate-200 truncate group-hover:text-primary transition-colors">{{ $ticket->sujet }}</h4>
                    <div class="flex items-center gap-4 mt-2 text-xs text-slate-500 dark:text-slate-400">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">person</span>
                            {{ $ticket->createur->full_name ?? 'N/A' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            {{ $ticket->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-slate-400 group-hover:text-primary transition-colors">chevron_right</span>
                </div>
            </div>
        </a>
        @empty
        <div class="flex flex-col items-center justify-center py-12 text-slate-400">
            <span class="material-symbols-outlined text-5xl mb-3">check_circle</span>
            <p class="text-sm font-medium">Aucun ticket récent</p>
        </div>
        @endforelse
    </div>
</div>
