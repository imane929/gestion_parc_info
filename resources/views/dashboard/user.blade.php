@extends('layouts.app')

@section('title', 'Tableau de Bord Utilisateur')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600 mt-2">Votre tableau de bord utilisateur</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Équipements Attribués</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['equipementsCount'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                        <i class="fas fa-desktop text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total des Tickets</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['ticketsCount'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-lg">
                        <i class="fas fa-ticket-alt text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tickets Résolus</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['resolvedTickets'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tickets en Attente</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $stats['pendingTickets'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 text-yellow-600 p-3 rounded-lg">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- My Equipment -->
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">Mes Équipements</h2>
                        <a href="{{ route('user.equipements') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir tout →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($equipements && $equipements->count() > 0)
                        <div class="space-y-4">
                            @foreach($equipements->take(5) as $equipement)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-4">
                                        <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                                            <i class="fas fa-desktop"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ $equipement->nom }}</h3>
                                            <p class="text-sm text-gray-600">{{ $equipement->type }}</p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                                        {{ $equipement->etat == 'bon' || $equipement->etat == 'neuf' ? 'bg-green-100 text-green-800' : 
                                           ($equipement->etat == 'moyen' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($equipement->etat) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-desktop text-4xl"></i>
                            </div>
                            <p class="text-gray-600">Aucun équipement attribué pour le moment.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Recent Tickets -->
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-900">Mes Tickets Récents</h2>
                        <a href="{{ route('user.tickets') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Voir tout →
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($tickets && $tickets->count() > 0)
                        <div class="space-y-4">
                            @foreach($tickets as $ticket)
                                <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-medium text-gray-900">{{ Str::limit($ticket->titre, 30) }}</h3>
                                            <p class="text-sm text-gray-600">Équipement: {{ $ticket->equipement->nom ?? 'N/A' }}</p>
                                        </div>
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            {{ $ticket->priorite == 'urgente' ? 'bg-red-100 text-red-800' : 
                                               ($ticket->priorite == 'haute' ? 'bg-orange-100 text-orange-800' : 
                                               ($ticket->priorite == 'moyenne' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                            {{ ucfirst($ticket->priorite) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($ticket->description, 80) }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                                            {{ $ticket->statut == 'termine' ? 'bg-green-100 text-green-800' : 
                                               ($ticket->statut == 'en_cours' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($ticket->statut) }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ $ticket->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-ticket-alt text-4xl"></i>
                            </div>
                            <p class="text-gray-600">Aucun ticket créé pour le moment.</p>
                            <a href="{{ route('user.tickets.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <i class="fas fa-plus mr-2"></i> Créer un ticket
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('user.equipements') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-lg">
                        <i class="fas fa-laptop text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Mes Équipements</h3>
                        <p class="text-sm text-gray-600 mt-1">Consultez tous vos équipements attribués</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('user.tickets') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-lg">
                        <i class="fas fa-ticket-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Mes Tickets</h3>
                        <p class="text-sm text-gray-600 mt-1">Suivez l'avancement de vos demandes</p>
                    </div>
                </div>
            </a>
            
            <a href="{{ route('user.tickets.create') }}" class="bg-white rounded-xl shadow p-6 hover:shadow-lg transition-shadow duration-300">
                <div class="flex items-center space-x-4">
                    <div class="bg-green-100 text-green-600 p-3 rounded-lg">
                        <i class="fas fa-plus-circle text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900">Nouveau Ticket</h3>
                        <p class="text-sm text-gray-600 mt-1">Signalez un problème ou une demande</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection