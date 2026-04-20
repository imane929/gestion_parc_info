@extends('layouts.app')

@section('title', 'Nouvel utilisateur')
@section('page-title', 'Créer un nouvel utilisateur')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 bg-slate-50/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">person_add</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Nouvel utilisateur</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Créez un nouveau compte utilisateur</p>
                    </div>
                </div>
                <a href="{{ route('admin.utilisateurs.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Retour
                </a>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.utilisateurs.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Civilité -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Civilité</label>
                    <select name="civilite" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('civilite') border-red-500 @enderror">
                        <option value="">--</option>
                        <option value="M" {{ old('civilite') == 'M' ? 'selected' : '' }}>M.</option>
                        <option value="Mme" {{ old('civilite') == 'Mme' ? 'selected' : '' }}>Mme</option>
                        <option value="Mlle" {{ old('civilite') == 'Mlle' ? 'selected' : '' }}>Mlle</option>
                    </select>
                    @error('civilite')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Prénom -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Prénom <span class="text-red-500">*</span></label>
                    <input type="text" name="prenom" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('prenom') border-red-500 @enderror" 
                           value="{{ old('prenom') }}" required>
                    @error('prenom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Nom -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="nom" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nom') border-red-500 @enderror" 
                           value="{{ old('nom') }}" required>
                    @error('nom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                           value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Téléphone -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Téléphone</label>
                    <input type="text" name="telephone" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('telephone') border-red-500 @enderror" 
                           value="{{ old('telephone') }}">
                    @error('telephone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Statut du compte -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Statut du compte <span class="text-red-500">*</span></label>
                    <select name="etat_compte" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('etat_compte') border-red-500 @enderror" required>
                        <option value="actif" {{ old('etat_compte') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('etat_compte') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                        <option value="suspendu" {{ old('etat_compte') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                    </select>
                    @error('etat_compte')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mot de passe -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="mot_de_passe" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('mot_de_passe') border-red-500 @enderror" 
                           required>
                    @error('mot_de_passe')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirmer le mot de passe -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="mot_de_passe_confirmation" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
                
                <!-- Rôles -->
                <div class="md:col-span-2">
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Rôles <span class="text-red-500">*</span></label>
                    <select name="roles[]" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent select2 @error('roles') border-red-500 @enderror" multiple required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                                {{ $role->libelle }}
                            </option>
                        @endforeach
                    </select>
                    @error('roles')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-slate-700/50">
                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm hover:shadow-md">
                        <span class="material-symbols-outlined">save</span>
                        Créer l'utilisateur
                    </button>
                    <a href="{{ route('admin.utilisateurs.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        Annuler
                    </a>
                </div>
                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                    <span class="material-symbols-outlined text-lg align-middle">info</span>
                    Un email sera envoyé à l'utilisateur avec ses identifiants de connexion.
                </p>
            </div>
        </form>
    </div>
</div>
@endsection


