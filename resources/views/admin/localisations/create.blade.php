@extends('layouts.app')

@section('title', 'Nouvelle localisation')
@section('page-title', 'Créer une localisation')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 dark:border-slate-700 dark:bg-slate-900 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center">
                    <span class="material-symbols-outlined text-white">location_on</span>
                </div>
                <div>
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Nouvelle localisation</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Ajoutez un nouveau lieu</p>
                </div>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.localisations.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Site <span class="text-red-500">*</span></label>
                    <input type="text" name="site" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('site') border-red-500 @enderror" 
                           value="{{ old('site') }}" required>
                    @error('site')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Ex: Siège social, Bureau Paris</p>
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Bâtiment</label>
                    <input type="text" name="batiment" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('batiment') border-red-500 @enderror" 
                           value="{{ old('batiment') }}">
                    @error('batiment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Ex: Batiment A, Tour 1</p>
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Étage</label>
                    <input type="text" name="etage" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('etage') border-red-500 @enderror" 
                           value="{{ old('etage') }}">
                    @error('etage')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Ex: 5ème étage, Mezzanine</p>
                </div>
                
                <div>
                    <label class="block mb-2 text-sm font-medium text-slate-700 dark:text-slate-300">Bureau</label>
                    <input type="text" name="bureau" class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bureau') border-red-500 @enderror" 
                           value="{{ old('bureau') }}">
                    @error('bureau')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Ex: Bureau 101, Salle 5B</p>
                </div>
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-slate-700 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-600 hover:to-blue-700 rounded-xl transition shadow-sm">
                    <span class="material-symbols-outlined">save</span>
                    Créer
                </button>
                <a href="{{ route('admin.localisations.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection