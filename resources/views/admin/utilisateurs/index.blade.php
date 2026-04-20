@extends('layouts.admin-new')

@section('title', 'Utilisateurs')
@section('page-title', 'Gestion des utilisateurs')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">Gestion des utilisateurs</h2>
            <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Configurer les rôles et l'accès au répertoire.</p>
        </div>
        @can('create users')
        <a href="{{ route('admin.utilisateurs.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-blue-600/20">
            <span class="material-symbols-outlined text-lg">person_add</span>
            <span class="hidden sm:inline">Ajouter un utilisateur</span>
        </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg lg:text-xl">group</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Total</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\User::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg lg:text-xl">check_circle</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Actifs</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\User::where('etat_compte', 'actif')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg lg:text-xl">engineering</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Techniciens</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\User::role('technicien')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg lg:text-xl">block</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Inactifs</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\User::where('etat_compte', 'inactif')->count() + \App\Models\User::where('etat_compte', 'suspendu')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <form method="GET" class="bg-white dark:bg-slate-800 rounded-xl p-3 lg:p-4 border border-slate-200 dark:border-slate-700">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 min-w-[140px]">
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg">search</span>
                    <input class="w-full pl-9 lg:pl-10 pr-4 py-2 lg:py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Rechercher..." type="text" name="search" value="{{ request('search') }}">
                </div>
            </div>
            <div class="flex flex-wrap sm:flex-nowrap gap-2">
                <select class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg pl-3 lg:pl-4 pr-8 lg:pr-10 py-2 text-xs lg:text-sm font-medium text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 cursor-pointer" name="role">
                    <option value="">Tous les rôles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->code }}" {{ request('role') == $role->code ? 'selected' : '' }}>{{ $role->libelle }}</option>
                    @endforeach
                </select>
                <select class="bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg pl-3 lg:pl-4 pr-8 lg:pr-10 py-2 text-xs lg:text-sm font-medium text-slate-700 dark:text-slate-200 focus:ring-2 focus:ring-blue-500 cursor-pointer" name="etat">
                    <option value="">Tout statut</option>
                    <option value="actif" {{ request('etat') == 'actif' ? 'selected' : '' }}>Actif</option>
                    <option value="inactif" {{ request('etat') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    <option value="suspendu" {{ request('etat') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                </select>
                <button class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors" type="submit">
                    <span class="material-symbols-outlined text-base lg:text-lg">filter_list</span>
                </button>
                <a href="{{ route('admin.utilisateurs.index') }}" class="p-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-base lg:text-lg">refresh</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Desktop Table View -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden hidden lg:block">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Profil utilisateur</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Rôle</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($utilisateurs as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $user->initials ?? substr($user->prenom, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user->full_name ?? $user->name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-200">{{ $user->email }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $user->telephone ?? '-' }}</p>
                        </td>
                        <td class="px-6 py-5">
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 uppercase tracking-tight">
                                    {{ $role->libelle }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                @if($user->etat_compte == 'actif')
                                    <span class="w-2 h-2 rounded-full bg-green-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></span>
                                    <span class="text-xs font-semibold text-green-600 dark:text-green-400">Active</span>
                                @elseif($user->etat_compte == 'inactif')
                                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                    <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Inactive</span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    <span class="text-xs font-semibold text-red-600 dark:text-red-400">Suspended</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <a href="{{ route('admin.utilisateurs.show', $user) }}" class="p-2 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Voir">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </a>
                                @can('edit users')
                                <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="p-2 text-slate-500 dark:text-slate-400 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 rounded-lg transition-colors" title="Modifier">
                                    <span class="material-symbols-outlined text-lg">edit</span>
                                </a>
                                @endcan
                                @can('delete users')
                                <form method="POST" action="{{ route('admin.utilisateurs.destroy', $user) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-colors delete-confirm" title="Supprimer">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-4">group_off</span>
                                <p class="text-slate-500 dark:text-slate-400 mb-4">Aucun utilisateur trouvé</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 flex items-center justify-between border-t border-slate-200 dark:border-slate-700">
            <p class="text-xs font-medium text-slate-500 dark:text-slate-400">
                Affichage de <span class="text-slate-900 dark:text-white font-semibold">{{ $utilisateurs->firstItem() ?? 0 }}-{{ $utilisateurs->lastItem() ?? 0 }}</span> sur <span class="text-slate-900 dark:text-white font-semibold">{{ $utilisateurs->total() }}</span>
            </p>
            <div class="flex items-center gap-2">
                {{ $utilisateurs->links() }}
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3">
        @forelse($utilisateurs as $user)
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ $user->initials ?? substr($user->prenom, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $user->full_name ?? $user->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                        </div>
                        <div class="flex gap-1">
                            <a href="{{ route('admin.utilisateurs.show', $user) }}" class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </a>
                            @can('edit users')
                            <a href="{{ route('admin.utilisateurs.edit', $user) }}" class="p-1.5 text-slate-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        @foreach($user->roles as $role)
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $role->libelle }}
                            </span>
                        @endforeach
                        @if($user->etat_compte == 'actif')
                            <span class="flex items-center gap-1 text-xs text-green-600 dark:text-green-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Actif
                            </span>
                        @elseif($user->etat_compte == 'inactif')
                            <span class="flex items-center gap-1 text-xs text-slate-500">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span> Inactif
                            </span>
                        @else
                            <span class="flex items-center gap-1 text-xs text-red-600 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Suspendu
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-4xl text-slate-300 dark:text-slate-600 mb-4">group_off</span>
            <p class="text-slate-500 dark:text-slate-400">Aucun utilisateur trouvé</p>
        </div>
        @endforelse
        
        <!-- Mobile Pagination -->
        @if($utilisateurs->hasPages())
        <div class="flex justify-center pt-2">
            {{ $utilisateurs->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

