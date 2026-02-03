@extends('layouts.app')

@section('title', 'Mes Équipements')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Mes Équipements</h1>
            <p class="text-gray-600 mt-2">Liste de tous les équipements qui vous sont attribués</p>
        </div>

        <!-- Equipment List -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Équipements Attribués</h2>
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        {{ $affectations->total() }} équipement(s)
                    </span>
                </div>
            </div>
            
            @if($affectations->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($affectations as $affectation)
                        @php($equipement = $affectation->equipement)
                        <div class="p-6 hover:bg-gray-50">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <!-- Equipment Info -->
                                <div class="flex items-start space-x-4">
                                    <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                                        <i class="fas fa-desktop text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg">{{ $equipement->nom }}</h3>
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                                                <i class="fas fa-tag mr-1"></i> {{ $equipement->type }}
                                            </span>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                                                <i class="fas fa-barcode mr-1"></i> {{ $equipement->numero_serie ?? 'N/A' }}
                                            </span>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                                                <i class="fas fa-map-marker-alt mr-1"></i> {{ $equipement->localisation }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 mt-3">{{ $equipement->notes ?? 'Aucune description' }}</p>
                                    </div>
                                </div>
                                
                                <!-- Status and Actions -->
                                <div class="flex flex-col items-end space-y-3">
                                    <!-- Equipment Status -->
                                    <span class="px-3 py-1 text-sm font-medium rounded-full 
                                        {{ $equipement->etat == 'bon' || $equipement->etat == 'neuf' ? 'bg-green-100 text-green-800' : 
                                           ($equipement->etat == 'moyen' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        <i class="fas fa-circle mr-1 text-xs"></i>
                                        {{ ucfirst($equipement->etat) }}
                                    </span>
                                    
                                    <!-- Assignment Date -->
                                    <div class="text-sm text-gray-600">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        Attribué le: {{ $affectation->date_affectation->format('d/m/Y') }}
                                    </div>
                                    
                                    <!-- Create Ticket Button -->
                                    <a href="{{ route('user.tickets.create', ['equipement_id' => $equipement->id]) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <i class="fas fa-plus mr-2"></i> Créer un ticket
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Equipment Details -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 pt-6 border-t border-gray-200">
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-600">Marque/Modèle</p>
                                    <p class="text-gray-900">{{ $equipement->marque }} {{ $equipement->modele }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-600">Date d'acquisition</p>
                                    <p class="text-gray-900">{{ $equipement->date_acquisition ? \Carbon\Carbon::parse($equipement->date_acquisition)->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-medium text-gray-600">Dernière mise à jour</p>
                                    <p class="text-gray-900">{{ $equipement->updated_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                @if($affectations->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $affectations->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-desktop text-5xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun équipement attribué</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez actuellement aucun équipement attribué.</p>
                    <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-arrow-left mr-2"></i> Retour au dashboard
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 rounded-xl p-6">
            <div class="flex items-start space-x-4">
                <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                    <i class="fas fa-question-circle text-xl"></i>
                </div>
                <div>
                    <h3 class="font-bold text-gray-900 mb-2">Besoin d'aide avec vos équipements ?</h3>
                    <p class="text-gray-600 mb-4">
                        Si vous rencontrez un problème avec l'un de vos équipements, vous pouvez créer un ticket de support.
                        Notre équipe technique vous répondra dans les plus brefs délais.
                    </p>
                    <a href="{{ route('user.tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i> Créer un ticket de support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection