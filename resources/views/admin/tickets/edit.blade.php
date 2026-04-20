@extends('layouts.admin-new')

@section('title', 'Modifier le ticket')

@section('content')
<!-- Header -->
<div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-on-surface">Modifier le ticket: {{ $ticket->numero }}</h1>
    </div>
    <p class="text-sm text-on-surface-variant">Mettre à jour les informations du ticket</p>
</div>

<div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
    <form method="POST" action="{{ route('admin.tickets.update', $ticket) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="p-6 lg:p-8 space-y-6">
            <!-- Sujet -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Sujet <span class="text-error">*</span></label>
                <input type="text" name="sujet" value="{{ old('sujet', $ticket->sujet) }}" 
                       class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('sujet') border-error @enderror" 
                       required>
                @error('sujet')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Description <span class="text-error">*</span></label>
                <textarea name="description" rows="5" 
                          class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('description') border-error @enderror" 
                          required>{{ old('description', $ticket->description) }}</textarea>
                @error('description')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Grille pour Actif, Priorité, Statut -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Actif -->
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Actif affecté</label>
                    <select name="actif_informatique_id" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                        <option value="">None</option>
                        @foreach($actifs as $actif)
                            <option value="{{ $actif->id }}" {{ old('actif_informatique_id', $ticket->actif_informatique_id) == $actif->id ? 'selected' : '' }}>
                                {{ $actif->code_inventaire }} - {{ $actif->marque }} {{ $actif->modele }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Priority -->
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Priority <span class="text-error">*</span></label>
                    <select name="priorite" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('priorite') border-error @enderror" required>
                        <option value="basse" {{ old('priorite', $ticket->priorite) == 'basse' ? 'selected' : '' }}>Low</option>
                        <option value="moyenne" {{ old('priorite', $ticket->priorite) == 'moyenne' ? 'selected' : '' }}>Medium</option>
                        <option value="haute" {{ old('priorite', $ticket->priorite) == 'haute' ? 'selected' : '' }}>High</option>
                        <option value="urgente" {{ old('priorite', $ticket->priorite) == 'urgente' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priorite')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Status <span class="text-error">*</span></label>
                    <select name="statut" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('statut') border-error @enderror" required>
                        <option value="ouvert" {{ old('statut', $ticket->statut) == 'ouvert' ? 'selected' : '' }}>Open</option>
                        <option value="en_cours" {{ old('statut', $ticket->statut) == 'en_cours' ? 'selected' : '' }}>In Progress</option>
                        <option value="en_attente" {{ old('statut', $ticket->statut) == 'en_attente' ? 'selected' : '' }}>On Hold</option>
                        <option value="resolu" {{ old('statut', $ticket->statut) == 'resolu' ? 'selected' : '' }}>Resolved</option>
                        <option value="ferme" {{ old('statut', $ticket->statut) == 'ferme' ? 'selected' : '' }}>Closed</option>
                    </select>
                    @error('statut')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Assign To -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Assigned To</label>
                <select name="assigne_a" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                    <option value="">Unassigned</option>
                    @foreach($techniciens as $technicien)
                        <option value="{{ $technicien->id }}" {{ old('assigne_a', $ticket->assigne_a) == $technicien->id ? 'selected' : '' }}>
                            {{ $technicien->full_name ?? $technicien->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Attachments -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Add Attachments</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-outline-variant rounded-xl cursor-pointer hover:border-primary hover:bg-surface-container-low transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <span class="material-symbols-outlined text-2xl text-on-surface-variant mb-1">upload_file</span>
                            <p class="text-xs text-on-surface-variant">Click to upload files</p>
                        </div>
                        <input type="file" name="pieces_jointes[]" multiple class="hidden">
                    </label>
                </div>
            </div>
            
            <!-- Existing Attachments -->
            @if($ticket->piecesJointes->count() > 0)
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Current Attachments</label>
                <div class="space-y-2">
                    @foreach($ticket->piecesJointes as $piece)
                    <div class="flex items-center justify-between p-3 bg-surface-container-low rounded-xl">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-on-surface-variant">attach_file</span>
                            <span class="text-sm text-on-surface">{{ $piece->nom_fichier }}</span>
                            <span class="text-xs text-on-surface-variant">({{ $piece->taille_formatee }})</span>
                        </div>
                        <form method="POST" action="{{ route('pieces-jointes.destroy', $piece) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 rounded-lg hover:bg-error/10 text-on-surface-variant hover:text-error transition-colors">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <!-- Footer -->
        <div class="px-6 lg:px-8 py-4 bg-surface-container-low flex items-center justify-between">
            <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-2 px-4 py-2 text-on-surface-variant hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
                Cancel
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">save</span>
                Update Ticket
            </button>
        </div>
    </form>
</div>
@endsection

