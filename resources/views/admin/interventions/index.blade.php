@extends('layouts.admin-new')

@section('title', 'Interventions')
@section('page-title', 'Interventions')

@section('content')
<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Interventions</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400">Track and manage all interventions</p>
    </div>
    <div class="flex gap-2">
        @can('create interventions')
        <a href="{{ route('admin.interventions.create') }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">add</span>
            New Intervention
        </a>
        @endcan
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200" placeholder="Search..." value="{{ request('search') }}">
        </div>
        <select name="technicien_id" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200">
            <option value="">All Technicians</option>
            @foreach($techniciens as $technicien)
                <option value="{{ $technicien->id }}" {{ request('technicien_id') == $technicien->id ? 'selected' : '' }}>
                    {{ $technicien->full_name ?? $technicien->name }}
                </option>
            @endforeach
        </select>
        <input type="date" name="date_debut" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200" value="{{ request('date_debut') }}">
        <input type="date" name="date_fin" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-700 dark:text-slate-200" value="{{ request('date_fin') }}">
        <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">
            Filter
        </button>
        <a href="{{ route('admin.interventions.index') }}" class="px-4 py-2 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors">
            Reset
        </a>
    </form>
</div>

<!-- Interventions Table -->
<div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-slate-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase">Technician</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-slate-500 dark:text-slate-300 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($interventions as $intervention)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                    <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-200">#{{ $intervention->id }}</td>
                    <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-200 capitalize">{{ $intervention->type }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ $intervention->statut }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-slate-700 dark:text-slate-200">{{ $intervention->date_intervention ? $intervention->date_intervention->format('d/m/Y') : '-' }}</td>
                    <td class="px-4 py-3">
                        @if($intervention->technicien)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                            {{ $intervention->technicien->full_name ?? $intervention->technicien->name }}
                        </span>
                        @else
                        <span class="text-slate-400">N/A</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('admin.interventions.show', $intervention->id) }}" class="p-2 text-slate-500 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors" title="View">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                            @can('edit interventions')
                            <a href="{{ route('admin.interventions.edit', $intervention->id) }}" class="p-2 text-slate-500 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20 rounded-lg transition-colors" title="Edit">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-4xl text-slate-400">build</span>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">No interventions found</h3>
                        <p class="text-slate-500 dark:text-slate-400">Get started by creating your first intervention</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-4 py-3 border-t border-slate-200 dark:border-slate-700">
        {{ $interventions->links() }}
    </div>
</div>
@endsection

