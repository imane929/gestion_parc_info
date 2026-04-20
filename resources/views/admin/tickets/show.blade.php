@extends('layouts.admin-new')

@section('title', 'Ticket Details')

@section('content')
<!-- Header -->
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 text-on-surface-variant hover:text-on-surface mb-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                <span class="text-sm">Back to Tickets</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-on-surface">{{ $ticket->numero }}</h1>
                @php
                    $statusColors = [
                        'ouvert' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        'en_cours' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                        'en_attente' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                        'resolu' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                        'ferme' => 'bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400'
                    ];
                    $priorityColors = [
                        'basse' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                        'moyenne' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                        'haute' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                        'urgente' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                    ];
                @endphp
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$ticket->statut] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $priorityColors[$ticket->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                    {{ ucfirst($ticket->priorite) }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('edit tickets')
            <a href="{{ route('admin.tickets.edit', $ticket) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-surface-container-low hover:bg-surface-container text-on-surface rounded-xl text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">edit</span>
                Edit
            </a>
            @endcan
            @if($ticket->statut != 'resolu' && $ticket->statut != 'ferme')
            <form method="POST" action="{{ route('admin.tickets.resoudre', $ticket) }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    Resolve
                </button>
            </form>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <!-- Left Sidebar -->
    <div class="lg:col-span-4">
        <!-- Ticket Info Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/10 mb-6">
            <h3 class="text-lg font-semibold text-on-surface mb-4">Ticket Information</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">person</span>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider">Created By</p>
                            <p class="text-sm font-medium text-on-surface">{{ $ticket->createur->full_name ?? $ticket->createur->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-500">engineering</span>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider">Assigned To</p>
                            <p class="text-sm font-medium text-on-surface">
                                @if($ticket->assigneA)
                                    {{ $ticket->assigneA->full_name ?? $ticket->assigneA->name }}
                                @else
                                    <span class="text-on-surface-variant">Unassigned</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($ticket->actif)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-purple-500">devices</span>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider">Asset</p>
                            <a href="{{ route('admin.actifs.show', $ticket->actif) }}" class="text-sm font-medium text-primary hover:underline">
                                {{ $ticket->actif->code_inventaire }}
                            </a>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-amber-500">calendar_month</span>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider">Created</p>
                            <p class="text-sm font-medium text-on-surface">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-emerald-500">schedule</span>
                        </div>
                        <div>
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider">Last Updated</p>
                            <p class="text-sm font-medium text-on-surface">{{ $ticket->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(!$ticket->assigneA)
            <div class="mt-6 pt-6 border-t border-outline-variant/10">
                <button onclick="openAssignModal()" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-sm">person_add</span>
                    Assign Technician
                </button>
            </div>
            @endif
        </div>
        
        <!-- Description Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-6 shadow-sm border border-outline-variant/10">
            <h3 class="text-lg font-semibold text-on-surface mb-4">Description</h3>
            <p class="text-sm text-on-surface leading-relaxed">{{ $ticket->description }}</p>
        </div>
    </div>
    
    <!-- Right Content - Tabs -->
    <div class="lg:col-span-8">
        <div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
            <!-- Tabs -->
            <div class="flex border-b border-outline-variant/10 overflow-x-auto">
                <button onclick="showTicketTab('interventions')" id="ticket-tab-interventions" class="ticket-tab-btn active px-6 py-4 text-sm font-medium text-primary border-b-2 border-primary whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">build</span>
                    Interventions ({{ $ticket->interventions->count() }})
                </button>
                <button onclick="showTicketTab('comments')" id="ticket-tab-comments" class="ticket-tab-btn px-6 py-4 text-sm font-medium text-on-surface-variant border-b-2 border-transparent whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">comment</span>
                    Comments ({{ $ticket->commentaires->count() }})
                </button>
                <button onclick="showTicketTab('attachments')" id="ticket-tab-attachments" class="ticket-tab-btn px-6 py-4 text-sm font-medium text-on-surface-variant border-b-2 border-transparent whitespace-nowrap">
                    <span class="material-symbols-outlined text-sm align-middle mr-1">attach_file</span>
                    Attachments ({{ $ticket->piecesJointes->count() }})
                </button>
            </div>
            
            <!-- Tab Contents -->
            <div class="p-6">
                <!-- Interventions Tab -->
                <div id="ticket-content-interventions" class="ticket-tab-content">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-on-surface">Interventions</h3>
                        @can('create intervention')
                        <button onclick="openInterventionModal()" class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">
                            <span class="material-symbols-outlined text-sm">add</span>
                            Add Intervention
                        </button>
                        @endcan
                    </div>
                    
                    @forelse($ticket->interventions as $intervention)
                    <div class="flex gap-4 p-4 bg-surface-container-low rounded-xl mb-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <span class="text-primary text-sm font-bold">{{ substr($intervention->technicien->prenom ?? 'T', 0, 1) }}{{ substr($intervention->technicien->nom ?? '', 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="text-sm font-medium text-on-surface">{{ $intervention->technicien->full_name ?? $intervention->technicien->name }}</span>
                                    <span class="text-xs text-on-surface-variant ml-2">{{ \Carbon\Carbon::parse($intervention->date)->format('d/m/Y') }}</span>
                                </div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 rounded-lg text-xs font-medium">
                                    {{ $intervention->temps_formate }}
                                </span>
                            </div>
                            <p class="text-sm text-on-surface leading-relaxed">{{ $intervention->travaux }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12 bg-surface-container-low rounded-xl">
                        <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">build</span>
                        <p class="text-on-surface-variant">No interventions yet</p>
                    </div>
                    @endforelse
                </div>
                
                <!-- Comments Tab -->
                <div id="ticket-content-comments" class="ticket-tab-content hidden">
                    <div class="mb-6">
                        <form method="POST" action="{{ route('admin.tickets.add-comment', $ticket) }}">
                            @csrf
                            <label class="block text-sm font-medium text-on-surface mb-2">Add a Comment</label>
                            <textarea name="contenu" rows="3" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" placeholder="Write your comment..." required></textarea>
                            <button type="submit" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">
                                <span class="material-symbols-outlined text-sm">send</span>
                                Post Comment
                            </button>
                        </form>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($ticket->commentaires as $commentaire)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center flex-shrink-0">
                                <span class="text-secondary text-sm font-bold">{{ substr($commentaire->utilisateur->prenom ?? 'U', 0, 1) }}{{ substr($commentaire->utilisateur->nom ?? '', 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-sm font-medium text-on-surface">{{ $commentaire->utilisateur->full_name ?? $commentaire->utilisateur->name }}</span>
                                    <span class="text-xs text-on-surface-variant">{{ $commentaire->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="p-4 bg-surface-container-low rounded-xl">
                                    <p class="text-sm text-on-surface leading-relaxed">{{ $commentaire->contenu }}</p>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 bg-surface-container-low rounded-xl">
                            <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">comment</span>
                            <p class="text-on-surface-variant">No comments yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <!-- Attachments Tab -->
                <div id="ticket-content-attachments" class="ticket-tab-content hidden">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($ticket->piecesJointes as $piece)
                        <div class="bg-surface-container-low rounded-xl p-4">
                            @if($piece->estImage())
                                <img src="{{ Storage::url($piece->chemin) }}" alt="{{ $piece->nom_fichier }}" class="w-full h-32 object-cover rounded-lg mb-3">
                            @else
                                <div class="w-full h-32 bg-surface-container-high rounded-lg flex items-center justify-center mb-3">
                                    <span class="material-symbols-outlined text-4xl text-on-surface-variant">description</span>
                                </div>
                            @endif
                            <p class="text-sm font-medium text-on-surface truncate">{{ $piece->nom_fichier }}</p>
                            <p class="text-xs text-on-surface-variant mb-3">{{ $piece->taille_formatee }}</p>
                            <a href="{{ Storage::url($piece->chemin) }}" download class="inline-flex items-center gap-1 text-primary text-sm font-medium hover:underline">
                                <span class="material-symbols-outlined text-sm">download</span>
                                Download
                            </a>
                        </div>
                        @empty
                        <div class="col-span-full text-center py-12 bg-surface-container-low rounded-xl">
                            <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">attach_file</span>
                            <p class="text-on-surface-variant">No attachments</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign Modal -->
<div id="assignModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true" onclick="closeAssignModal()"></div>
        <div class="inline-block align-bottom bg-surface-container-lowest rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('admin.tickets.assigner', $ticket) }}">
                @csrf
                <div class="px-5 py-4 border-b border-outline-variant/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Assign Technician</h3>
                    <button type="button" onclick="closeAssignModal()" class="p-1 rounded-full hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Technician <span class="text-error">*</span></label>
                        <select name="technicien_id" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required>
                            <option value="">Select technician...</option>
                            @foreach(\App\Models\User::techniciens()->get() as $technicien)
                                <option value="{{ $technicien->id }}">{{ $technicien->full_name ?? $technicien->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="px-5 py-4 bg-surface-container-low flex justify-end gap-3">
                    <button type="button" onclick="closeAssignModal()" class="px-4 py-2 bg-surface-container-lowest text-on-surface rounded-xl text-sm font-medium hover:bg-surface-container transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Intervention Modal -->
<div id="interventionModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true" onclick="closeInterventionModal()"></div>
        <div class="inline-block align-bottom bg-surface-container-lowest rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <form method="POST" action="{{ route('admin.tickets.add-intervention', $ticket) }}" enctype="multipart/form-data">
                @csrf
                <div class="px-5 py-4 border-b border-outline-variant/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Add Intervention</h3>
                    <button type="button" onclick="closeInterventionModal()" class="p-1 rounded-full hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-on-surface mb-2">Date <span class="text-error">*</span></label>
                            <input type="date" name="date" value="{{ now()->format('Y-m-d') }}" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-on-surface mb-2">Time Spent (min) <span class="text-error">*</span></label>
                            <input type="number" name="temps_passe" min="1" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Work Performed <span class="text-error">*</span></label>
                        <textarea name="travaux" rows="4" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" placeholder="Describe the work performed..." required></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Attachments</label>
                        <input type="file" name="pieces_jointes[]" multiple class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                    </div>
                </div>
                <div class="px-5 py-4 bg-surface-container-low flex justify-end gap-3">
                    <button type="button" onclick="closeInterventionModal()" class="px-4 py-2 bg-surface-container-lowest text-on-surface rounded-xl text-sm font-medium hover:bg-surface-container transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-primary hover:bg-primary/90 text-white rounded-xl text-sm font-medium transition-colors">Add Intervention</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showTicketTab(tabName) {
        document.querySelectorAll('.ticket-tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById('ticket-content-' + tabName).classList.remove('hidden');
        
        document.querySelectorAll('.ticket-tab-btn').forEach(el => {
            el.classList.remove('active', 'text-primary', 'border-primary');
            el.classList.add('text-on-surface-variant', 'border-transparent');
        });
        
        const activeTab = document.getElementById('ticket-tab-' + tabName);
        activeTab.classList.add('active', 'text-primary', 'border-primary');
        activeTab.classList.remove('text-on-surface-variant', 'border-transparent');
    }
    
    function openAssignModal() {
        document.getElementById('assignModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeAssignModal() {
        document.getElementById('assignModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    function openInterventionModal() {
        document.getElementById('interventionModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeInterventionModal() {
        document.getElementById('interventionModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>

<style>
    .ticket-tab-btn.active {
        color: #0058be;
        border-color: #0058be;
    }
</style>
@endsection

