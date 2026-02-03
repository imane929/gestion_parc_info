@extends('layouts.app')

@section('title', 'Créer un Ticket')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Créer un nouveau ticket</h1>
            <p class="text-gray-600 mt-2">Signalez un problème ou faites une demande concernant vos équipements</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Informations du ticket</h2>
            </div>
            
            <form action="{{ route('user.tickets.store') }}" method="POST" class="p-6">
                @csrf
                
                <!-- Equipment Selection -->
                <div class="mb-6">
                    <label for="equipement_id" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-desktop mr-2"></i> Équipement concerné *
                    </label>
                    <select name="equipement_id" id="equipement_id" required
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('equipement_id') border-red-500 @enderror">
                        <option value="">Sélectionnez un équipement</option>
                        @foreach($equipements as $equipement)
                            <option value="{{ $equipement->id }}" 
                                    {{ old('equipement_id') == $equipement->id ? 'selected' : '' }}>
                                {{ $equipement->nom }} ({{ $equipement->type }} - {{ $equipement->localisation }})
                            </option>
                        @endforeach
                    </select>
                    @error('equipement_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($equipements->isEmpty())
                        <p class="mt-2 text-sm text-yellow-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Aucun équipement n'est actuellement attribué à votre compte.
                        </p>
                    @endif
                </div>
                
                <!-- Ticket Title -->
                <div class="mb-6">
                    <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-heading mr-2"></i> Titre du problème *
                    </label>
                    <input type="text" name="titre" id="titre" required
                           value="{{ old('titre') }}"
                           placeholder="Ex: Écran ne s'allume pas"
                           class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('titre') border-red-500 @enderror">
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Priority -->
                <div class="mb-6">
                    <label for="priorite" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i> Priorité *
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="relative">
                            <input type="radio" name="priorite" id="priorite_faible" value="faible" 
                                   {{ old('priorite', 'moyenne') == 'faible' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <label for="priorite_faible" class="flex flex-col items-center justify-center p-4 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50">
                                <div class="w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-thermometer-empty"></i>
                                </div>
                                <span class="font-medium">Faible</span>
                                <span class="text-sm text-gray-600">Non urgent</span>
                            </label>
                        </div>
                        
                        <div class="relative">
                            <input type="radio" name="priorite" id="priorite_moyenne" value="moyenne" 
                                   {{ old('priorite', 'moyenne') == 'moyenne' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <label for="priorite_moyenne" class="flex flex-col items-center justify-center p-4 border border-gray-300 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:bg-gray-50">
                                <div class="w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-2">
                                    <i class="fas fa-thermometer-half"></i>
                                </div>
                                <span class="font-medium">Moyenne</span>
                               