@extends('layouts.admin-new')

@section('title', 'Tickets')

@section('page-title', 'Tous les tickets')

@section('content')
<div class="space-y-6">
    @php
        $isUtilisateur = auth()->user()->hasRoleByCode('utilisateur');
    @endphp
    
    @if(!$isUtilisateur)
    <!-- Stats Cards (hidden for utilisateur) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        <div class="bg-surface-container-lowest rounded-xl p-4 lg:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary text-lg lg:text-xl">confirmation_number</span>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant">Total</p>
                    <p class="text-lg lg:text-2xl font-bold text-on-surface">{{ $stats['total'] ?? \App\Models\TicketMaintenance::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-surface-container-lowest rounded-xl p-4 lg:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-500 text-lg lg:text-xl">schedule</span>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant">Ouverts</p>
                    <p class="text-lg lg:text-2xl font-bold text-on-surface">{{ $stats['ouverts'] ?? \App\Models\TicketMaintenance::where('statut', 'ouvert')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-surface-container-lowest rounded-xl p-4 lg:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-orange-500/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-orange-500 text-lg lg:text-xl">autorenew</span>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant">En cours</p>
                    <p class="text-lg lg:text-2xl font-bold text-on-surface">{{ $stats['en_cours'] ?? \App\Models\TicketMaintenance::where('statut', 'en_cours')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-surface-container-lowest rounded-xl p-4 lg:p-5 shadow-sm border border-outline-variant/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-error/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-error text-lg lg:text-xl">priority_high</span>
                </div>
                <div>
                    <p class="text-xs text-on-surface-variant">Urgents</p>
                    <p class="text-lg lg:text-2xl font-bold text-on-surface">{{ $stats['urgents'] ?? \App\Models\TicketMaintenance::where('priorite', 'urgente')->whereNotIn('statut', ['resolu', 'ferme'])->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tickets Card -->
    <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-outline-variant/10 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="text-lg font-semibold text-on-surface">{{ $isUtilisateur ? 'Mes tickets' : 'Tous les tickets' }}</h2>
            <a href="{{ route('admin.tickets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">add</span>
                Nouveau ticket
            </a>
        </div>
        
        <div class="p-4 lg:p-6">
            <!-- Filters -->
            <form method="GET" class="flex flex-wrap gap-3 mb-5">
                <div class="flex-1 min-w-[140px] lg:min-w-[200px]">
                    <input type="text" name="search" placeholder="Rechercher des tickets..." value="{{ request('search') }}" 
                           class="w-full px-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors text-sm">
                </div>
                <div class="w-36 lg:w-44">
                    <select name="statut" class="w-full px-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors text-sm">
                        <option value="">Tous les statuts</option>
                        <option value="ouvert" {{ request('statut') == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="en_attente" {{ request('statut') == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="resolu" {{ request('statut') == 'resolu' ? 'selected' : '' }}>Résolu</option>
                        <option value="ferme" {{ request('statut') == 'ferme' ? 'selected' : '' }}>Fermé</option>
                    </select>
                </div>
                <div class="hidden sm:block w-36 lg:w-44">
                    <select name="priorite" class="w-full px-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors text-sm">
                        <option value="">Toutes les priorités</option>
                        <option value="basse" {{ request('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                        <option value="moyenne" {{ request('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ request('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                        <option value="urgente" {{ request('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-base">search</span>
                    </button>
                    <a href="{{ route('admin.tickets.index') }}" class="px-4 py-2.5 bg-surface-container-low hover:bg-surface-container text-on-surface-variant rounded-xl text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-base">refresh</span>
                    </a>
                </div>
            </form>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-outline-variant/10">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Ticket</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Sujet</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Statut</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Priorité</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Affecté à</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Créé le</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/10">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-surface-container-low transition-colors">
                            <td class="py-3 px-4">
                                <span class="font-semibold text-on-surface">{{ $ticket->numero }}</span>
                            </td>
                            <td class="py-3 px-4 text-on-surface-variant max-w-[200px] truncate">
                                {{ Str::limit($ticket->sujet, 40) }}
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $statusColors = [
                                        'ouvert' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                        'en_cours' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                        'en_attente' => 'bg-surface-container text-on-surface-variant dark:bg-surface-container-high dark:text-on-surface-variant',
                                        'resolu' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                                        'ferme' => 'bg-surface-container text-on-surface-variant/70 dark:bg-surface-container-high dark:text-on-surface-variant/70'
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$ticket->statut] ?? 'bg-surface-container text-on-surface-variant' }}">
                                    {{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @php
                                    $priorityColors = [
                                        'basse' => 'bg-surface-container text-on-surface-variant dark:bg-surface-container-high dark:text-on-surface-variant',
                                        'moyenne' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                        'haute' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'urgente' => 'bg-error/10 text-error dark:bg-error/20 dark:text-error'
                                    ];
                                @endphp
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $priorityColors[$ticket->priorite] ?? 'bg-surface-container text-on-surface-variant' }}">
                                    {{ ucfirst($ticket->priorite) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                @if($ticket->assigneA)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-primary/10 flex items-center justify-center text-primary text-[10px] font-semibold">
                                            {{ substr($ticket->assigneA->prenom ?? 'T', 0, 1) }}{{ substr($ticket->assigneA->nom ?? '', 0, 1) }}
                                        </div>
                                        <span class="text-sm text-on-surface">{{ $ticket->assigneA->full_name ?? $ticket->assigneA->name }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-on-surface-variant">Non affecté</span>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-sm text-on-surface-variant">
                                {{ $ticket->created_at->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 rounded-lg hover:bg-surface-container text-on-surface-variant hover:text-primary transition-colors" title="Voir">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    @can('edit tickets')
                                    <a href="{{ route('admin.tickets.edit', $ticket) }}" class="p-2 rounded-lg hover:bg-surface-container text-on-surface-variant hover:text-amber-500 transition-colors" title="Modifier">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    @endcan
                                    <button type="button" class="p-2 rounded-lg hover:bg-surface-container text-on-surface-variant hover:text-emerald-500 transition-colors assign-ticket" data-ticket-id="{{ $ticket->id }}" data-ticket-num="{{ $ticket->numero }}" title="Affecter">
                                        <span class="material-symbols-outlined text-lg">person_add</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-3xl text-on-surface-variant">confirmation_number</span>
                                    </div>
                                    <p class="text-on-surface-variant mb-4">Aucun ticket trouvé</p>
            <a href="{{ route('admin.tickets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined">add</span>
                                        Créer un ticket
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-3">
                @forelse($tickets as $ticket)
                <div class="bg-surface-container-low rounded-xl p-4 border border-outline-variant/10">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <span class="font-semibold text-on-surface text-sm">{{ $ticket->numero }}</span>
                            <div class="flex flex-wrap items-center gap-1 mt-1">
                                @php
                                    $statusColors = [
                                        'ouvert' => 'bg-blue-100 text-blue-700',
                                        'en_cours' => 'bg-orange-100 text-orange-700',
                                        'en_attente' => 'bg-surface-container text-on-surface-variant',
                                        'resolu' => 'bg-emerald-100 text-emerald-700',
                                        'ferme' => 'bg-surface-container text-on-surface-variant/70'
                                    ];
                                    $priorityColors = [
                                        'basse' => 'bg-surface-container text-on-surface-variant',
                                        'moyenne' => 'bg-cyan-100 text-cyan-700',
                                        'haute' => 'bg-yellow-100 text-yellow-700',
                                        'urgente' => 'bg-error/10 text-error'
                                    ];
                                @endphp
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $statusColors[$ticket->statut] ?? 'bg-surface-container text-on-surface-variant' }}">
                                    {{ str_replace('_', ' ', $ticket->statut) }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $priorityColors[$ticket->priorite] ?? 'bg-surface-container text-on-surface-variant' }}">
                                    {{ $ticket->priorite }}
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-1.5 rounded-lg hover:bg-surface-container-high text-on-surface-variant hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </a>
                            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="p-1.5 rounded-lg hover:bg-surface-container-high text-on-surface-variant hover:text-amber-500 transition-colors">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </a>
                        </div>
                    </div>
                    <div class="text-sm text-on-surface truncate">{{ $ticket->sujet }}</div>
                    <div class="flex items-center gap-2 mt-2 text-xs text-on-surface-variant">
                        @if($ticket->assigneA)
                            <span class="material-symbols-outlined text-xs align-middle">person</span>
                            {{ $ticket->assigneA->full_name ?? $ticket->assigneA->name }}
                        @else
                            <span>Non affecté</span>
                        @endif
                        <span>•</span>
                        <span>{{ $ticket->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-surface-container-low flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-on-surface-variant">confirmation_number</span>
                    </div>
                    <p class="text-on-surface-variant">Aucun ticket trouvé</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-5 flex justify-end">
                {{ $tickets->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Assignment Modal -->
<div id="assignModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true" onclick="closeAssignModal()"></div>
        <div class="inline-block align-bottom bg-surface-container-lowest rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="assignForm" method="POST">
                @csrf
                <div class="px-5 py-4 border-b border-outline-variant/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Affecter le ticket</h3>
                    <button type="button" onclick="closeAssignModal()" class="p-1 rounded-full hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Ticket</label>
                        <input type="text" id="ticketNum" class="w-full px-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface" readonly>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Technicien <span class="text-error">*</span></label>
                        <select name="technicien_id" class="w-full px-4 py-2.5 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required>
                            <option value="">Sélectionner un technicien...</option>
                            @foreach($techniciens ?? [] as $technicien)
                                <option value="{{ $technicien->id }}">{{ $technicien->full_name ?? $technicien->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="px-5 py-4 bg-surface-container-low flex justify-end gap-3">
                    <button type="button" onclick="closeAssignModal()" class="px-4 py-2 bg-surface-container-lowest text-on-surface rounded-xl text-sm font-medium hover:bg-surface-container transition-colors">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">Affecter</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const assignTicketUrlTemplate = @json(route('admin.tickets.assigner', ['ticket' => '__TICKET__']));

    function openAssignModal(ticketId, ticketNum) {
        document.getElementById('ticketNum').value = ticketNum;
        document.getElementById('assignForm').action = assignTicketUrlTemplate.replace('__TICKET__', ticketId);
        document.getElementById('assignModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.assign-ticket').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const ticketId = this.dataset.ticketId;
                const ticketNum = this.dataset.ticketNum;
                openAssignModal(ticketId, ticketNum);
            });
        });
        
        document.getElementById('assignForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const url = form.action;
            const data = new FormData(form);
            
            fetch(url, {
                method: 'POST',
                body: data,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
                .then(data => {
                closeAssignModal();
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Succès !',
                        text: 'Ticket affecté avec succès',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur',
                    text: 'Une erreur est survenue'
                });
            });
        });
    });
</script>
@endpush
@endsection

