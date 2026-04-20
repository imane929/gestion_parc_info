@extends('layouts.admin-new')

@section('title', 'Nouveau ticket')

@section('content')
<!-- Header -->
<div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('admin.tickets.index') }}" class="p-2 rounded-lg hover:bg-surface-container text-on-surface-variant transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-on-surface">Créer un nouveau ticket</h1>
    </div>
    <p class="text-sm text-on-surface-variant">Soumettre une demande d'assistance IT</p>
</div>

<div class="bg-surface-container-lowest rounded-2xl shadow-sm border border-outline-variant/10 overflow-hidden">
    <form method="POST" action="{{ route('admin.tickets.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="p-6 lg:p-8 space-y-6">
            <!-- Sujet -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Sujet <span class="text-error">*</span></label>
                <input type="text" name="sujet" value="{{ old('sujet') }}" 
                       class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('sujet') border-error @enderror" 
                       placeholder="Description brève du problème" required>
                @error('sujet')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Description <span class="text-error">*</span></label>
                <textarea name="description" rows="5" 
                          class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface placeholder-on-surface-variant/50 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('description') border-error @enderror" 
                          placeholder="Description détaillée du problème..." required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Grille pour Actif, Priorité, Assigné -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Actif -->
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Actif affecté</label>
                    <select name="actif_informatique_id" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                        <option value="">Sélectionner un actif (optionnel)</option>
                        @foreach($actifs as $actif)
                            <option value="{{ $actif->id }}" {{ old('actif_informatique_id') == $actif->id ? 'selected' : '' }}>
                                {{ $actif->code_inventaire }} - {{ $actif->marque }} {{ $actif->modele }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Priorité -->
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Priorité <span class="text-error">*</span></label>
                    <select name="priorite" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors @error('priorite') border-error @enderror" required>
                        <option value="">Sélectionner la priorité...</option>
                        <option value="basse" {{ old('priorite') == 'basse' ? 'selected' : '' }}>Basse</option>
                        <option value="moyenne" {{ old('priorite') == 'moyenne' ? 'selected' : '' }}>Moyenne</option>
                        <option value="haute" {{ old('priorite') == 'haute' ? 'selected' : '' }}>Haute</option>
                        <option value="urgente" {{ old('priorite') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                    </select>
                    @error('priorite')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Affecter à -->
                <div>
                    <label class="block text-sm font-medium text-on-surface mb-2">Affecter à</label>
                    <select name="assigne_a" class="w-full px-4 py-3 bg-surface-container-low rounded-xl border border-outline-variant/50 text-on-surface focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-colors">
                        <option value="">Non affecté</option>
                        @foreach($techniciens as $technicien)
                            <option value="{{ $technicien->id }}" {{ old('assigne_a') == $technicien->id ? 'selected' : '' }}>
                                {{ $technicien->full_name ?? $technicien->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Pièces jointes -->
            <div>
                <label class="block text-sm font-medium text-on-surface mb-2">Pièces jointes</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-outline-variant rounded-xl cursor-pointer hover:border-primary hover:bg-surface-container-low transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <span class="material-symbols-outlined text-3xl text-on-surface-variant mb-2">upload_file</span>
                            <p class="text-sm text-on-surface-variant">Cliquez pour télécharger ou glissez-déposez</p>
                            <p class="text-xs text-on-surface-variant mt-1">Max 10 Mo par fichier</p>
                        </div>
                        <input type="file" name="pieces_jointes[]" multiple class="hidden">
                    </label>
                </div>
                @error('pieces_jointes.*')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Footer -->
        <div class="px-6 lg:px-8 py-4 bg-surface-container-low flex items-center justify-between">
            <a href="{{ route('admin.tickets.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-on-surface-variant hover:text-on-surface transition-colors">
                <span class="material-symbols-outlined text-sm">close</span>
                Annuler
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-primary hover:bg-primary/90 text-white rounded-xl font-medium transition-colors">
                <span class="material-symbols-outlined text-sm">add</span>
                Créer le ticket
            </button>
        </div>
    </form>
</div>
@endsection

