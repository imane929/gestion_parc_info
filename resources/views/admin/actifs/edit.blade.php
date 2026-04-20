@extends('layouts.app')

@section('title', 'Modifier l\'actif')
@section('page-title', 'Modifier l\'actif')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 dark:bg-slate-900 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white">edit</span>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Modifier l'actif</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $actif->code_inventaire }}</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.actifs.update', $actif) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Code inventaire -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Code inventaire <span class="text-red-500">*</span></label>
                    <input type="text" name="code_inventaire" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('code_inventaire') border-red-500 @enderror" 
                           value="{{ old('code_inventaire', $actif->code_inventaire) }}" required>
                    @error('code_inventaire')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Type -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Type <span class="text-red-500">*</span></label>
                    <select name="type" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('type') border-red-500 @enderror" required>
                        <option value="">Sélectionner...</option>
                        <option value="pc" {{ old('type', $actif->type) == 'pc' ? 'selected' : '' }}>PC</option>
                        <option value="serveur" {{ old('type', $actif->type) == 'serveur' ? 'selected' : '' }}>Serveur</option>
                        <option value="imprimante" {{ old('type', $actif->type) == 'imprimante' ? 'selected' : '' }}>Imprimante</option>
                        <option value="reseau" {{ old('type', $actif->type) == 'reseau' ? 'selected' : '' }}>Équipement réseau</option>
                        <option value="peripherique" {{ old('type', $actif->type) == 'peripherique' ? 'selected' : '' }}>Périphérique</option>
                        <option value="mobile" {{ old('type', $actif->type) == 'mobile' ? 'selected' : '' }}>Appareil mobile</option>
                        <option value="autre" {{ old('type', $actif->type) == 'autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- État -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">État <span class="text-red-500">*</span></label>
                    <select name="etat" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('etat') border-red-500 @enderror" required>
                        <option value="">Sélectionner...</option>
                        <option value="neuf" {{ old('etat', $actif->etat) == 'neuf' ? 'selected' : '' }}>Neuf</option>
                        <option value="bon" {{ old('etat', $actif->etat) == 'bon' ? 'selected' : '' }}>Bon</option>
                        <option value="moyen" {{ old('etat', $actif->etat) == 'moyen' ? 'selected' : '' }}>Moyen</option>
                        <option value="mauvais" {{ old('etat', $actif->etat) == 'mauvais' ? 'selected' : '' }}>Mauvais</option>
                        <option value="hors_service" {{ old('etat', $actif->etat) == 'hors_service' ? 'selected' : '' }}>Hors service</option>
                    </select>
                    @error('etat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Marque -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Marque <span class="text-red-500">*</span></label>
                    <input type="text" name="marque" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('marque') border-red-500 @enderror" 
                           value="{{ old('marque', $actif->marque) }}" required>
                    @error('marque')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Modèle -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Modèle <span class="text-red-500">*</span></label>
                    <input type="text" name="modele" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('modele') border-red-500 @enderror" 
                           value="{{ old('modele', $actif->modele) }}" required>
                    @error('modele')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Numéro de série -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Numéro de série <span class="text-red-500">*</span></label>
                    <input type="text" name="numero_serie" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('numero_serie') border-red-500 @enderror" 
                           value="{{ old('numero_serie', $actif->numero_serie) }}" required>
                    @error('numero_serie')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Date d'achat -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Date d'achat</label>
                    <input type="date" name="date_achat" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('date_achat') border-red-500 @enderror" 
                           value="{{ old('date_achat', $actif->date_achat ? $actif->date_achat->format('Y-m-d') : '') }}">
                </div>
                
                <!-- Fin de garantie -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Date de fin de garantie</label>
                    <input type="date" name="garantie_fin" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('garantie_fin') border-red-500 @enderror" 
                           value="{{ old('garantie_fin', $actif->garantie_fin ? $actif->garantie_fin->format('Y-m-d') : '') }}">
                </div>
                
                <!-- Localisation -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Localisation</label>
                    <select name="localisation_id" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent select2 @error('localisation_id') border-red-500 @enderror">
                        <option value="">Sélectionner...</option>
                        @foreach($localisations as $localisation)
                            <option value="{{ $localisation->id }}" {{ old('localisation_id', $actif->localisation_id) == $localisation->id ? 'selected' : '' }}>
                                {{ $localisation->nom_complet }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Affectation -->
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Changer l'affectation</label>
                    <select name="utilisateur_affecte_id" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent select2">
                        <option value="">Non affecté</option>
                        @foreach($utilisateurs as $user)
                            <option value="{{ $user->id }}" {{ old('utilisateur_affecte_id', $actif->utilisateur_affecte_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->full_name ?? $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @if($actif->utilisateurAffecte)
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Currently assigned to: <strong>{{ $actif->utilisateurAffecte->full_name ?? $actif->utilisateurAffecte->name }}</strong></p>
                    @endif
                </div>
                
                <!-- Description -->
                <div class="col-span-full">
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Notes / Description</label>
                    <textarea name="description" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4">{{ old('description', $actif->description ?? '') }}</textarea>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-slate-700 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 rounded-xl transition shadow-sm">
                    <span class="material-symbols-outlined">save</span>
                    Mettre à jour
                </button>
                <a href="{{ route('admin.actifs.show', $actif) }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection