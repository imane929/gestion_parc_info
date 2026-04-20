@extends('layouts.admin-new')

@section('title', 'Role Details')
@section('page-title', $role->libelle)

@section('content')
<div class="space-y-4 lg:space-y-6">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- Role Info Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <h3 class="font-semibold text-slate-900 dark:text-white">Role Information</h3>
            </div>
            <div class="p-6">
                <div class="text-center mb-6">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700 mx-auto mb-4 flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-3xl">shield</span>
                    </div>
                    <h4 class="text-lg font-semibold text-slate-900 dark:text-white mb-1">{{ $role->libelle }}</h4>
                    <code class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-xs text-slate-600 dark:text-slate-400">{{ $role->code }}</code>
                </div>
                
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                            <span class="material-symbols-outlined text-blue-500">people</span>
                            Users with this role
                        </div>
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-xs font-medium rounded-full">{{ $role->utilisateurs->count() }}</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                        <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                            <span class="material-symbols-outlined text-green-500">key</span>
                            Total Permissions
                        </div>
                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium rounded-full">{{ $role->permissions->count() }}</span>
                    </div>
                </div>
                
                @if($role->description)
                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <strong class="text-sm text-slate-700 dark:text-slate-300">Description:</strong>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $role->description }}</p>
                </div>
                @endif
            </div>
            <div class="px-4 py-3 bg-slate-50 dark:bg-slate-700/50 border-t border-slate-200 dark:border-slate-700 flex gap-2">
                @can('edit roles')
                <a href="{{ route('admin.roles.edit', $role) }}" class="flex-1 px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">edit</span>
                    Edit
                </a>
                @endcan
                @can('delete roles')
                @if($role->code !== 'admin')
                <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-colors flex items-center justify-center gap-2 delete-confirm">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        Delete
                    </button>
                </form>
                @endif
                @endcan
            </div>
        </div>
        
        <!-- Permissions & Users -->
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <!-- Permissions Card -->
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white">Permissions</h3>
                </div>
                <div class="p-4 lg:p-6">
                    @forelse($permissionsGrouped as $group => $permissions)
                    <div class="mb-4 last:mb-0">
                        <h6 class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-3 uppercase tracking-wide">{{ ucfirst($group) }}</h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach($permissions as $permission)
                            <div class="p-3 bg-slate-50 dark:bg-slate-700/50 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-green-500 text-lg">check_circle</span>
                                    <div>
                                        <div class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $permission->libelle }}</div>
                                        <div class="text-xs text-slate-500">{{ $permission->code }}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 mx-auto mb-4 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl text-slate-400">block</span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400">No permissions assigned to this role</p>
                    </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Users with this role -->
            @if($role->utilisateurs->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-4 lg:px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-semibold text-slate-900 dark:text-white">Users with this role</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-700">
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">User</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Email</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($role->utilisateurs->take(10) as $user)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($user->photo_url)
                                            <img src="{{ $user->photo_url }}" class="w-8 h-8 rounded-full object-cover">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xs font-semibold">
                                                {{ $user->initials }}
                                            </div>
                                        @endif
                                        <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $user->full_name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusColors = [
                                            'actif' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                            'inactif' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-400',
                                            'suspendu' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$user->etat_compte] ?? 'bg-slate-100 text-slate-600' }}">
                                        {{ ucfirst($user->etat_compte) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('admin.utilisateurs.show', $user) }}" class="p-2 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($role->utilisateurs->count() > 10)
                <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700 text-center">
                    <a href="{{ route('admin.utilisateurs.index', ['role' => $role->code]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-medium rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                        View all {{ $role->utilisateurs->count() }} users
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </a>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

