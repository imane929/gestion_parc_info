@extends('layouts.admin-new')

@section('title', 'Locations')
@section('page-title', 'Locations')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">Locations</h2>
            <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Manage your asset locations.</p>
        </div>
        @can('create localisations')
        <a href="{{ route('admin.localisations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">New Location</span>
        </a>
        @endcan
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white dark:bg-slate-800 rounded-xl p-3 lg:p-4 border border-slate-200 dark:border-slate-700">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 min-w-[140px]">
                <input type="text" name="search" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search..." value="{{ request('search') }}">
            </div>
            <div class="flex gap-2 flex-wrap sm:flex-nowrap">
                <div class="w-28 lg:w-44">
                    <select name="site" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Sites</option>
                        @foreach($sites as $site)
                            <option value="{{ $site }}" {{ request('site') == $site ? 'selected' : '' }}>{{ $site }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-3 lg:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-base lg:text-lg">search</span>
                </button>
                <a href="{{ route('admin.localisations.index') }}" class="px-3 lg:px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-base lg:text-lg">refresh</span>
                </a>
            </div>
        </div>
    </form>

    <!-- Desktop Table View -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden hidden lg:block">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-slate-200 dark:border-slate-700">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Site</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Building</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Floor</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Office</th>
                        <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Assets</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($localisations as $localisation)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                        <td class="py-3 px-4 font-semibold text-slate-900 dark:text-white">{{ $localisation->site }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $localisation->batiment ?? '-' }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $localisation->etage ?? '-' }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $localisation->bureau ?? '-' }}</td>
                        <td class="py-3 px-4 text-center"><span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $localisation->actifs_count }}</span></td>
                        <td class="py-3 px-4">
                            <div class="flex gap-1">
                                <a href="{{ route('admin.localisations.show', $localisation) }}" class="p-2 rounded-lg hover:bg-blue-50 text-slate-500 hover:text-blue-600"><span class="material-symbols-outlined text-lg">visibility</span></a>
                                @can('edit localisations')<a href="{{ route('admin.localisations.edit', $localisation) }}" class="p-2 rounded-lg hover:bg-yellow-50 text-slate-500 hover:text-yellow-600"><span class="material-symbols-outlined text-lg">edit</span></a>@endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-12 text-center text-slate-500">No locations found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
            {{ $localisations->withQueryString()->links() }}
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3">
        @forelse($localisations as $localisation)
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
            <div class="flex justify-between items-start">
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $localisation->site }}</span>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        @if($localisation->batiment)Building: {{ $localisation->batiment }}@endif
                        @if($localisation->etage) • Floor: {{ $localisation->etage }}@endif
                        @if($localisation->bureau) • Office: {{ $localisation->bureau }}@endif
                    </p>
                </div>
                <span class="px-2 py-1 rounded-full text-[10px] font-medium bg-blue-100 text-blue-700">{{ $localisation->actifs_count }} assets</span>
            </div>
            <div class="flex gap-2 mt-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('admin.localisations.show', $localisation) }}" class="flex-1 py-2 text-center text-xs font-medium text-blue-600 bg-blue-50 rounded-lg">View</a>
                @can('edit localisations')<a href="{{ route('admin.localisations.edit', $localisation) }}" class="flex-1 py-2 text-center text-xs font-medium text-yellow-600 bg-yellow-50 rounded-lg">Edit</a>@endcan
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-500">No locations found</div>
        @endforelse
    </div>
</div>
@endsection

