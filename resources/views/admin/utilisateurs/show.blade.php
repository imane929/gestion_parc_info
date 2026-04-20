@extends('layouts.admin-new')

@section('title', 'Profil utilisateur')
@section('page-title', $utilisateur->full_name ?? $utilisateur->name)

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- Profile Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-6">
            <div class="text-center">
                <div class="mb-4">
                    @if($utilisateur->photo_url)
                        <img src="{{ $utilisateur->photo_url }}" 
                             alt="Avatar" 
                             class="w-24 h-24 rounded-full object-cover mx-auto">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 mx-auto flex items-center justify-center text-white text-3xl font-bold">
                            {{ $utilisateur->initials ?? substr($utilisateur->prenom ?? 'U', 0, 1) . substr($utilisateur->nom ?? '', 0, 1) }}
                        </div>
                    @endif
                </div>
                
                <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">{{ $utilisateur->full_name ?? $utilisateur->name }}</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">
                    @foreach($utilisateur->roles as $role)
                        <span class="inline-block px-2 py-0.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs rounded-full mr-1">{{ $role->libelle }}</span>
                    @endforeach
                </p>
                
                <div class="flex justify-center gap-2 mb-4">
                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs rounded-full">
                        <span class="material-symbols-outlined text-sm">mail</span>
                        {{ $utilisateur->email }}
                    </span>
                    <span class="inline-flex items-center gap-1 px-2 py-1 {{ $utilisateur->etat_compte == 'actif' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' }} text-xs rounded-full">
                        {{ ucfirst($utilisateur->etat_compte) }}
                    </span>
                </div>
                
                <hr class="border-slate-200 dark:border-slate-700">
                
                <div class="text-start mt-4 space-y-3">
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-blue-500">phone</span>
                        {{ $utilisateur->telephone ?? 'Non fourni' }}
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-blue-500">calendar_month</span>
                        Membre depuis {{ $utilisateur->created_at->format('d/m/Y') }}
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined text-blue-500">schedule</span>
                        Dernière connexion : {{ $utilisateur->derniere_connexion_at?->diffForHumans() ?? 'Jamais' }}
                    </div>
                </div>
                
                <div class="flex gap-2 mt-4">
                    @can('edit users')
                    <a href="{{ route('admin.utilisateurs.edit', $utilisateur) }}" class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">edit</span>
                        Modifier
                    </a>
                    @endcan
                    @can('change roles')
                    <a href="{{ route('admin.utilisateurs.assign-permissions', $utilisateur) }}" class="flex-1 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">shield</span>
                        Permissions
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        
        <!-- Content Cards -->
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <!-- Assigned Assets -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white">Actifs affectés</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Code</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Type</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Marque/Modèle</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">État</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($utilisateur->actifsAffectes as $actif)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-3 px-4 text-sm font-medium text-slate-900 dark:text-white">{{ $actif->code_inventaire }}</td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-300">{{ ucfirst($actif->type) }}</td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-300">{{ $actif->marque }} {{ $actif->modele }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $etatColors = [
                                            'neuf' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'bon' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'moyen' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'mauvais' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $etatColors[$actif->etat] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($actif->etat) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.actifs.show', $actif) }}" class="p-2 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-3xl text-slate-400">desktop_windows</span>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400">Aucun actif affecté</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Created Tickets -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white">Tickets créés</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Ticket</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sujet</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Statut</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Priorité</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Créé le</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($utilisateur->ticketsCrees as $ticket)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-3 px-4 text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->numero }}</td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-300 max-w-[200px] truncate">{{ Str::limit($ticket->sujet, 30) }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusColors = [
                                            'ouvert' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                            'en_cours' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                                            'en_attente' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                            'resolu' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'ferme' => 'bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400'
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$ticket->statut] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $priorityColors = [
                                            'basse' => 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                                            'moyenne' => 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400',
                                            'haute' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                            'urgente' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $priorityColors[$ticket->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($ticket->priorite) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-500 dark:text-slate-400">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-3xl text-slate-400">confirmation_number</span>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400">Aucun ticket créé</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Assigned Tickets (if technician) -->
            @if($utilisateur->estTechnicien())
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white">Tickets affectés</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Ticket</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sujet</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Statut</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Priorité</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Créé le</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($utilisateur->ticketsAssignes as $ticket)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-3 px-4 text-sm font-medium text-slate-900 dark:text-white">{{ $ticket->numero }}</td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-300 max-w-[200px] truncate">{{ Str::limit($ticket->sujet, 30) }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$ticket->statut] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->statut)) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $priorityColors[$ticket->priorite] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($ticket->priorite) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-500 dark:text-slate-400">{{ $ticket->created_at->format('d/m/Y') }}</td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                            <span class="material-symbols-outlined text-3xl text-slate-400">confirmation_number</span>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400">Aucun ticket affecté</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

