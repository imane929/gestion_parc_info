@extends('layouts.app')

@section('title', 'Mes Tickets')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Mes Tickets</h1>
                    <p class="text-gray-600 mt-2">Suivez toutes vos demandes et problèmes signalés</p>
                </div>
                <a href="{{ route('user.tickets.create') }}" 
                   class="mt-4 md:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> Nouveau Ticket
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="ouvert">Ouvert</option>
                        <option value="en_cours">En cours</option>
                        <option value="termine">Terminé</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Toutes les priorités</option>
                        <option value="faible">Faible</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="haute">Haute</option>
                        <option value="urgente">Urgente</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Période</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Tout le temps</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="button" class="px-4 py-2 bg-gray-100 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-200">
                        <i class="fas fa-filter mr-2"></i> Filtrer
                    </button>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            @if($tickets->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID & Titre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Équipement
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priorité
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">#{{ $ticket->id }}</div>
                                        <div class="text-sm text-gray-600">{{ Str::limit($ticket->titre, 40) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $ticket->equipement->nom ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-600">{{ $ticket->equipement->type ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $ticket->priorite == 'urgente' ? 'bg-red-100 text-red-800' : 
                                               ($ticket->priorite == 'haute' ? 'bg-orange-100 text-orange-800' : 
                                               ($ticket->priorite == 'moyenne' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')) }}">
                                            {{ ucfirst($ticket->priorite) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $ticket->statut == 'termine' ? 'bg-green-100 text-green-800' : 
                                               ($ticket->statut == 'en_cours' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($ticket->statut) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $ticket->created_at->format('d/m/Y') }}
                                        <div class="text-xs text-gray-500">{{ $ticket->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i> Voir
                                        </a>
                                        @if($ticket->statut != 'termine')
                                            <a href="#" class="text-yellow-600 hover:text-yellow-900">
                                                <i class="fas fa-edit"></i> Modifier
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($tickets->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $tickets->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-ticket-alt text-5xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucun ticket trouvé</h3>
                    <p class="text-gray-600 mb-6">Vous n'avez pas encore créé de ticket de support.</p>
                    <a href="{{ route('user.tickets.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <i class="fas fa-plus mr-2"></i> Créer votre premier ticket
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Stats Summary -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-lg mr-4">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tickets en attente</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $tickets->where('statut', '!=', 'termine')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="bg-green-100 text-green-600 p-3 rounded-lg mr-4">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Tickets résolus</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $tickets->where('statut', 'termine')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="bg-purple-100 text-purple-600 p-3 rounded-lg mr-4">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Temps moyen de résolution</p>
                        <p class="text-2xl font-bold text-gray-900">2.5 jours</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection