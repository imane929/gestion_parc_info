@extends('layouts.admin-new')

@section('title', 'Providers')
@section('page-title', 'Service Providers')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">Providers</h2>
            <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Manage service providers.</p>
        </div>
        @can('create prestataires')
        <a href="{{ route('admin.prestataires.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">New Provider</span>
        </a>
        @endcan
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white dark:bg-slate-800 rounded-xl p-3 lg:p-4 border border-slate-200 dark:border-slate-700">
        <div class="flex flex-col gap-3">
            <input type="text" name="search" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500" placeholder="Search..." value="{{ request('search') }}">
            <div class="flex flex-wrap gap-2">
                <select name="has_contract" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">All</option>
                    <option value="active" {{ request('has_contract') == 'active' ? 'selected' : '' }}>With Contracts</option>
                    <option value="none" {{ request('has_contract') == 'none' ? 'selected' : '' }}>No Contracts</option>
                </select>
                <div class="flex gap-2 ml-auto">
                    <button type="submit" class="px-3 lg:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium"><span class="material-symbols-outlined text-base">search</span></button>
                    <a href="{{ route('admin.prestataires.index') }}" class="px-3 lg:px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium"><span class="material-symbols-outlined text-base">refresh</span></a>
                </div>
            </div>
        </div>
    </form>

    <!-- Desktop Table View -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden hidden lg:block">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Name</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Contact</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Contracts</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($prestataires as $prestataire)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                        <td class="py-3 px-4 font-semibold text-slate-900 dark:text-white">{{ $prestataire->nom }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300 text-xs">
                            <div>{{ $prestataire->telephone ?? '-' }}</div>
                            <div class="truncate max-w-[150px]">{{ $prestataire->email ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4 text-center">
                            @if($prestataire->contrats_actifs_count > 0)
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ $prestataire->contrats_actifs_count }}</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">0</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-1">
                                <a href="{{ route('admin.prestataires.show', $prestataire) }}" class="p-2 rounded-lg hover:bg-blue-50 text-slate-500 hover:text-blue-600"><span class="material-symbols-outlined text-lg">visibility</span></a>
                                @can('edit prestataires')<a href="{{ route('admin.prestataires.edit', $prestataire) }}" class="p-2 rounded-lg hover:bg-yellow-50 text-slate-500 hover:text-yellow-600"><span class="material-symbols-outlined text-lg">edit</span></a>@endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-12 text-center text-slate-500">No providers found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
            {{ $prestataires->withQueryString()->links() }}
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3">
        @forelse($prestataires as $prestataire)
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $prestataire->nom }}</span>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">{{ $prestataire->telephone ?? '-' }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate max-w-[180px]">{{ $prestataire->email ?? '-' }}</p>
                </div>
                @if($prestataire->contrats_actifs_count > 0)
                    <span class="px-2 py-1 rounded-full text-[10px] font-medium bg-green-100 text-green-700">{{ $prestataire->contrats_actifs_count }} contracts</span>
                @endif
            </div>
            <div class="flex gap-2 mt-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('admin.prestataires.show', $prestataire) }}" class="flex-1 py-2 text-center text-xs font-medium text-blue-600 bg-blue-50 rounded-lg">View</a>
                @can('edit prestataires')<a href="{{ route('admin.prestataires.edit', $prestataire) }}" class="flex-1 py-2 text-center text-xs font-medium text-yellow-600 bg-yellow-50 rounded-lg">Edit</a>@endcan
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-500">No providers found</div>
        @endforelse
    </div>
</div>
@endsection

