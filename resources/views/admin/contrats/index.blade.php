@extends('layouts.admin-new')

@section('title', 'Contracts')
@section('page-title', 'Contracts')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg lg:text-xl">description</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Total</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['total'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg lg:text-xl">check_circle</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Active</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['actifs'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-lg lg:text-xl">schedule</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Expiring</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['expirant'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg lg:text-xl">cancel</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500">Expired</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ $stats['expires'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <h2 class="text-lg lg:text-xl font-semibold text-slate-900 dark:text-white">Maintenance Contracts</h2>
        @can('create contrats')
        <a href="{{ route('admin.contrats.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">New Contract</span>
        </a>
        @endcan
    </div>

    <!-- Filters -->
    <form method="GET" class="bg-white dark:bg-slate-800 rounded-xl p-3 lg:p-4 border border-slate-200 dark:border-slate-700">
        <div class="flex flex-col gap-3">
            <input type="text" name="search" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search..." value="{{ request('search') }}">
            <div class="flex flex-wrap gap-2">
                <select name="statut" class="px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                    <option value="">All Status</option>
                    <option value="actif" {{ request('statut') == 'actif' ? 'selected' : '' }}>Active</option>
                    <option value="expire" {{ request('statut') == 'expire' ? 'selected' : '' }}>Expired</option>
                </select>
                <div class="flex gap-2 ml-auto">
                    <button type="submit" class="px-3 lg:px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium"><span class="material-symbols-outlined text-base">search</span></button>
                    <a href="{{ route('admin.contrats.index') }}" class="px-3 lg:px-4 py-2 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium"><span class="material-symbols-outlined text-base">refresh</span></a>
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
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Contract #</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Provider</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Dates</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($contrats as $contrat)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50">
                        <td class="py-3 px-4 font-semibold text-slate-900 dark:text-white">{{ $contrat->numero }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300">{{ $contrat->prestataire->nom }}</td>
                        <td class="py-3 px-4 text-slate-600 dark:text-slate-300 text-xs">{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            @php $statusColors = ['actif' => 'bg-green-100 text-green-700', 'expire' => 'bg-red-100 text-red-700', 'futur' => 'bg-blue-100 text-blue-700']; @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$contrat->statut] ?? 'bg-slate-100' }}">{{ ucfirst($contrat->statut) }}</span>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex gap-1">
                                <a href="{{ route('admin.contrats.show', $contrat) }}" class="p-2 rounded-lg hover:bg-blue-50 text-slate-500 hover:text-blue-600"><span class="material-symbols-outlined text-lg">visibility</span></a>
                                @can('edit contrats')<a href="{{ route('admin.contrats.edit', $contrat) }}" class="p-2 rounded-lg hover:bg-yellow-50 text-slate-500 hover:text-yellow-600"><span class="material-symbols-outlined text-lg">edit</span></a>@endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-12 text-center text-slate-500">No contracts found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex justify-end">
            {{ $contrats->withQueryString()->links() }}
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3">
        @forelse($contrats as $contrat)
        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4">
            <div class="flex justify-between items-start mb-2">
                <div>
                    <span class="font-semibold text-slate-900 dark:text-white">{{ $contrat->numero }}</span>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $contrat->prestataire->nom }}</p>
                </div>
                @php $statusColors = ['actif' => 'bg-green-100 text-green-700', 'expire' => 'bg-red-100 text-red-700', 'futur' => 'bg-blue-100 text-blue-700']; @endphp
                <span class="px-2 py-1 rounded-full text-[10px] font-medium {{ $statusColors[$contrat->statut] ?? 'bg-slate-100' }}">{{ ucfirst($contrat->statut) }}</span>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($contrat->date_fin)->format('d/m/Y') }}</p>
            <div class="flex gap-2 mt-3 pt-3 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('admin.contrats.show', $contrat) }}" class="flex-1 py-2 text-center text-xs font-medium text-blue-600 bg-blue-50 rounded-lg">View</a>
                @can('edit contrats')<a href="{{ route('admin.contrats.edit', $contrat) }}" class="flex-1 py-2 text-center text-xs font-medium text-yellow-600 bg-yellow-50 rounded-lg">Edit</a>@endcan
            </div>
        </div>
        @empty
        <div class="text-center py-12 text-slate-500">No contracts found</div>
        @endforelse
    </div>
</div>
@endsection

