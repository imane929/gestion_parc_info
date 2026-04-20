@extends('layouts.admin-new')

@section('title', 'Modifier l\'utilisateur')
@section('page-title', 'Modifier l\'utilisateur: ' . ($utilisateur->full_name ?? $utilisateur->name))

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Modifier les informations de l'utilisateur</h2>
            </div>
            <div class="p-4 lg:p-6">
                <form method="POST" action="{{ route('admin.utilisateurs.update', $utilisateur) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Civilité -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Civilité</label>
                            <select name="civilite" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('civilite') border-red-500 @enderror">
                                <option value="">--</option>
                                <option value="M" {{ old('civilite', $utilisateur->civilite) == 'M' ? 'selected' : '' }}>M.</option>
                                <option value="Mme" {{ old('civilite', $utilisateur->civilite) == 'Mme' ? 'selected' : '' }}>Mme</option>
                                <option value="Mlle" {{ old('civilite', $utilisateur->civilite) == 'Mlle' ? 'selected' : '' }}>Mlle</option>
                            </select>
                            @error('civilite')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Prénom -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Prénom <span class="text-red-500">*</span></label>
                            <input type="text" name="prenom" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prenom') border-red-500 @enderror" 
                                   value="{{ old('prenom', $utilisateur->prenom) }}" required>
                            @error('prenom')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Nom -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror" 
                                   value="{{ old('nom', $utilisateur->nom) }}" required>
                            @error('nom')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                                   value="{{ old('email', $utilisateur->email) }}" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Téléphone -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Téléphone</label>
                            <input type="text" name="telephone" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone') border-red-500 @enderror" 
                                   value="{{ old('telephone', $utilisateur->telephone) }}">
                            @error('telephone')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Mot de passe (optionnel) -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Nouveau mot de passe (laisser vide pour garder l'actuel)</label>
                            <input type="password" name="mot_de_passe" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mot_de_passe') border-red-500 @enderror">
                            @error('mot_de_passe')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Confirmer le mot de passe -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Confirmer le nouveau mot de passe</label>
                            <input type="password" name="mot_de_passe_confirmation" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Statut du compte -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Statut du compte <span class="text-red-500">*</span></label>
                            <select name="etat_compte" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('etat_compte') border-red-500 @enderror" required>
                                <option value="actif" {{ old('etat_compte', $utilisateur->etat_compte) == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="inactif" {{ old('etat_compte', $utilisateur->etat_compte) == 'inactif' ? 'selected' : '' }}>Inactif</option>
                                <option value="suspendu" {{ old('etat_compte', $utilisateur->etat_compte) == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                            </select>
                            @error('etat_compte')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Rôles -->
                        @can('changeRole', $utilisateur)
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Rôles <span class="text-red-500">*</span></label>
                            <select name="roles[]" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('roles') border-red-500 @enderror" multiple required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" 
                                        {{ in_array($role->id, old('roles', $utilisateur->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $role->libelle }}
                                    </option>
                                @endforeach
                            </select>
                            @error('roles')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        @else
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Rôles</label>
                            <div class="p-3 border border-slate-200 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-700">
                                @foreach($utilisateur->roles as $role)
                                    <span class="inline-block px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs rounded mr-1 mb-1">{{ $role->libelle }}</span>
                                @endforeach
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Contactez un administrateur pour changer les rôles</p>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center gap-3 pt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">save</span>
                            Mettre à jour l'utilisateur
                        </button>
                        <a href="{{ route('admin.utilisateurs.show', $utilisateur) }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined">close</span>
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

