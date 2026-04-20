@extends('layouts.admin-new')

@section('title', 'Demandes d\'Accès')

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-bold text-on-surface">Demandes d'Accès</h1>
    <p class="text-sm text-on-surface-variant">Examiner et gérer les demandes d'accès des utilisateurs</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-amber-500">schedule</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">En attente</p>
                <p class="text-2xl font-bold text-on-surface">{{ $demandes->where('statut', 'en_attente')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-500">check_circle</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Approuvées</p>
                <p class="text-2xl font-bold text-on-surface">{{ $demandes->where('statut', 'approuvee')->count() }}</p>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-error/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-error">cancel</span>
            </div>
            <div>
                <p class="text-xs text-on-surface-variant">Rejetées</p>
                <p class="text-2xl font-bold text-on-surface">{{ $demandes->where('statut', 'rejetee')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Requests List -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
    <div class="px-6 py-4 border-b border-outline-variant/10">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-on-surface">Toutes les Demandes</h2>
            <div class="flex gap-2">
                <select id="filterStatus" class="px-3 py-1.5 bg-surface-container-low rounded-lg border border-outline-variant/50 text-sm text-on-surface">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="approuvee">Approuvée</option>
                    <option value="rejetee">Rejetée</option>
                </select>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        @forelse($demandes as $demande)
        <div class="bg-surface-container-low rounded-xl p-5 mb-4 hover:bg-surface-container transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="text-primary font-bold text-lg">
                            {{ substr($demande->prenom, 0, 1) }}{{ substr($demande->nom, 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-on-surface">{{ $demande->prenom }} {{ $demande->nom }}</h3>
                        <p class="text-sm text-on-surface-variant">{{ $demande->email }}</p>
                        <div class="flex items-center gap-4 mt-2">
                            <span class="text-xs text-on-surface-variant">
                                <span class="material-symbols-outlined text-xs align-middle">business</span>
                                {{ $demande->departement }}
                            </span>
                            <span class="text-xs text-on-surface-variant">
                                <span class="material-symbols-outlined text-xs align-middle">calendar_month</span>
                                {{ $demande->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @if($demande->statut === 'en_attente')
                        <span class="px-3 py-1 bg-amber-500/10 text-amber-600 text-xs font-medium rounded-full">En attente</span>
                    @elseif($demande->statut === 'approuvee')
                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-600 text-xs font-medium rounded-full">Approuvée</span>
                    @else
                        <span class="px-3 py-1 bg-error/10 text-error text-xs font-medium rounded-full">Rejetée</span>
                    @endif
                </div>
            </div>
            
            <div class="mt-4 p-4 bg-surface-container-lowest rounded-lg">
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Motif</p>
                <p class="text-sm text-on-surface">{{ $demande->raison }}</p>
            </div>
            
            @if($demande->commentaire)
            <div class="mt-3 p-4 bg-surface-container-lowest rounded-lg border-l-4 border-on-surface-variant">
                <p class="text-xs font-medium text-on-surface-variant uppercase tracking-wider mb-2">Commentaire Admin</p>
                <p class="text-sm text-on-surface">{{ $demande->commentaire }}</p>
                @if($demande->traitePar)
                <p class="text-xs text-on-surface-variant mt-2">Par {{ $demande->traitePar->full_name }} le {{ $demande->traitée_at->format('d/m/Y H:i') }}</p>
                @endif
            </div>
            @endif
            
            @if($demande->statut === 'en_attente')
            <div class="mt-4 pt-4 border-t border-outline-variant/10 flex flex-wrap gap-3">
                <button onclick="openApproveModal({{ $demande->id }}, '{{ $demande->prenom }} {{ $demande->nom }}')" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-sm">check</span>
                    Approuver
                </button>
                <button onclick="openRejectModal({{ $demande->id }}, '{{ $demande->prenom }} {{ $demande->nom }}')" 
                        class="inline-flex items-center gap-2 px-4 py-2 bg-error hover:bg-error/90 text-white rounded-xl text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-sm">close</span>
                    Rejeter
                </button>
            </div>
            @endif
        </div>
        @empty
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-5xl text-on-surface-variant/50 mb-3">inbox</span>
            <p class="text-on-surface-variant">Aucune demande d'accès trouvée</p>
        </div>
        @endforelse
        
        <div class="mt-4">
            {{ $demandes->links() }}
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true" onclick="closeApproveModal()"></div>
        <div class="inline-block align-bottom bg-surface-container-lowest rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="approveForm" method="POST">
                @csrf
                <div class="px-5 py-4 border-b border-outline-variant/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Approuver la Demande d'Accès</h3>
                    <button type="button" onclick="closeApproveModal()" class="p-1 rounded-full hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>
                <div class="p-5 space-y-4">
                    <p class="text-sm text-on-surface-variant">Créer un compte pour : <strong id="approveUserName" class="text-on-surface"></strong></p>
                    
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Attribuer un Rôle</label>
                        <select name="role" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required>
                            <option value="utilisateur">Utilisateur (Accès standard)</option>
                            <option value="technicien">Technicien</option>
                            <option value="responsable_it">Responsable IT</option>
                            <option value="manager">Manager</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Mot de passe temporaire</label>
                        <input type="text" name="mot_de_passe" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required minlength="8" placeholder="Minimum 8 caractères">
                        <p class="text-xs text-on-surface-variant mt-1">L'utilisateur devrait changer ce mot de passe après la première connexion</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Confirmer le Mot de passe</label>
                        <input type="text" name="mot_de_passe_confirmation" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" required minlength="8" placeholder="Confirmer le mot de passe">
                    </div>
                </div>
                <div class="px-5 py-4 bg-surface-container-low flex justify-end gap-3">
                    <button type="button" onclick="closeApproveModal()" class="px-4 py-2 bg-surface-container-lowest text-on-surface rounded-xl text-sm font-medium hover:bg-surface-container transition-colors">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-sm font-medium transition-colors">Approuver et Créer l'Utilisateur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-black/50" aria-hidden="true" onclick="closeRejectModal()"></div>
        <div class="inline-block align-bottom bg-surface-container-lowest rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="px-5 py-4 border-b border-outline-variant/10 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-on-surface">Rejeter la Demande d'Accès</h3>
                    <button type="button" onclick="closeRejectModal()" class="p-1 rounded-full hover:bg-surface-container transition-colors">
                        <span class="material-symbols-outlined text-on-surface-variant">close</span>
                    </button>
                </div>
                <div class="p-5 space-y-4">
                    <p class="text-sm text-on-surface-variant">Rejeter la demande pour : <strong id="rejectUserName" class="text-on-surface"></strong></p>
                    
                    <div>
                        <label class="block text-sm font-medium text-on-surface mb-2">Motif (optionnel)</label>
                        <textarea name="commentaire" rows="3" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors" placeholder="Expliquez pourquoi cette demande est rejetée..."></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 bg-surface-container-low flex justify-end gap-3">
                    <button type="button" onclick="closeRejectModal()" class="px-4 py-2 bg-surface-container-lowest text-on-surface rounded-xl text-sm font-medium hover:bg-surface-container transition-colors">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-error hover:bg-error/90 text-white rounded-xl text-sm font-medium transition-colors">Rejeter la Demande</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openApproveModal(id, name) {
        document.getElementById('approveUserName').textContent = name;
        document.getElementById('approveForm').action = '/admin/demandes-acces/' + id + '/approuver';
        document.getElementById('approveModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    function openRejectModal(id, name) {
        document.getElementById('rejectUserName').textContent = name;
        document.getElementById('rejectForm').action = '/admin/demandes-acces/' + id + '/rejeter';
        document.getElementById('rejectModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endsection
