@extends('layouts.admin-new')

@section('title', 'Software')
@section('page-title', 'Software')

@section('content')
<div class="space-y-4 lg:space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-xl lg:text-2xl font-bold text-slate-900 dark:text-white">Software</h2>
            <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Manage software inventory and licenses.</p>
        </div>
        @can('create logiciels')
        <a href="{{ route('admin.logiciels.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors shadow-lg shadow-blue-600/20">
            <span class="material-symbols-outlined text-lg">add</span>
            <span class="hidden sm:inline">Add Software</span>
        </a>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg lg:text-xl">category</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Total</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\Logiciel::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg lg:text-xl">key</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Licenses</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\LicenceLogiciel::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 text-lg lg:text-xl">download</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Installs</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\InstallationLogiciel::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-4 lg:p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-lg lg:text-xl">warning</span>
                </div>
                <div>
                    <p class="text-xs lg:text-sm text-slate-500 dark:text-slate-400">Expired</p>
                    <p class="text-lg lg:text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\LicenceLogiciel::where('date_expiration', '<', now())->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Software Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-4 lg:px-5 py-3 lg:py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="text-base lg:text-lg font-semibold text-slate-900 dark:text-white">All Software</h2>
            @can('create logiciels')
            <a href="{{ route('admin.logiciels.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-lg">add</span>
                <span class="hidden sm:inline">New Software</span>
            </a>
            @endcan
        </div>
        
        <div class="p-3 lg:p-5">
            <!-- Filters -->
            <form method="GET" class="flex flex-wrap gap-2 lg:gap-3 mb-4 lg:mb-5">
                <div class="flex-1 min-w-[140px] lg:min-w-[200px]">
                    <input type="text" name="search" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="w-28 lg:w-40">
                    <select name="type" class="w-full px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-xs lg:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Types</option>
                        <option value="os" {{ request('type') == 'os' ? 'selected' : '' }}>OS</option>
                        <option value="bureau" {{ request('type') == 'bureau' ? 'selected' : '' }}>Office</option>
                        <option value="serveur" {{ request('type') == 'serveur' ? 'selected' : '' }}>Server</option>
                        <option value="web" {{ request('type') == 'web' ? 'selected' : '' }}>Web</option>
                        <option value="mobile" {{ request('type') == 'mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="autre" {{ request('type') == 'autre' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
                <div class="flex gap-1 lg:gap-2">
                    <button type="submit" class="px-3 lg:px-4 py-2 lg:py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs lg:text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-base lg:text-lg align-middle">search</span>
                    </button>
                    <a href="{{ route('admin.logiciels.index') }}" class="px-3 lg:px-4 py-2 lg:py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-xs lg:text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-base lg:text-lg align-middle">refresh</span>
                    </a>
                </div>
            </form>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Name</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Publisher</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Type</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Licenses</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Installs</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($logiciels as $logiciel)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="py-3 px-4">
                                <span class="font-semibold text-slate-900 dark:text-white">{{ $logiciel->nom }}</span>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $logiciel->version }}</p>
                            </td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-300">
                                {{ $logiciel->editeur }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                    {{ ucfirst($logiciel->type) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">{{ $logiciel->licences_count }}</span>
                            </td>
                            <td class="py-3 px-4 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ $logiciel->installations_count }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.logiciels.show', $logiciel) }}" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="View">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    @can('edit logiciels')
                                    <a href="{{ route('admin.logiciels.edit', $logiciel) }}" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-3xl text-slate-400">category</span>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 mb-4">No software found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="lg:hidden space-y-3">
                @forelse($logiciels as $logiciel)
                <div class="bg-slate-50 dark:bg-slate-700/30 rounded-lg p-4 border border-slate-200 dark:border-slate-600">
                    <div class="flex items-start justify-between mb-2">
                        <div>
                            <span class="font-semibold text-slate-900 dark:text-white text-sm">{{ $logiciel->nom }}</span>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $logiciel->version }} • {{ $logiciel->editeur }}</p>
                        </div>
                        <div class="flex gap-1">
                            <a href="{{ route('admin.logiciels.show', $logiciel) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                <span class="material-symbols-outlined text-base">visibility</span>
                            </a>
                            @can('edit logiciels')
                            <a href="{{ route('admin.logiciels.edit', $logiciel) }}" class="p-1.5 rounded-lg text-slate-500 hover:bg-yellow-50 hover:text-yellow-600 transition-colors">
                                <span class="material-symbols-outlined text-base">edit</span>
                            </a>
                            @endcan
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                            {{ ucfirst($logiciel->type) }}
                        </span>
                        <span class="text-slate-400">|</span>
                        <span class="text-slate-600 dark:text-slate-400">{{ $logiciel->licences_count }} licenses</span>
                        <span class="text-slate-400">|</span>
                        <span class="text-slate-600 dark:text-slate-400">{{ $logiciel->installations_count }} installs</span>
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl text-slate-400">category</span>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400">No software found</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-5 flex justify-end">
                {{ $logiciels->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

