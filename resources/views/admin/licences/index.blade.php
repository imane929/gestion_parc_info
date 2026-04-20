@extends('layouts.admin-new')

@section('title', 'Licenses')
@section('page-title', 'Software Licenses')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">key</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Total Licenses</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\LicenceLogiciel::count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Active</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\LicenceLogiciel::valides()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">schedule</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Expiring Soon</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\LicenceLogiciel::query()->procheExpiration(30)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">cancel</span>
                </div>
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Expired</p>
                    <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ \App\Models\LicenceLogiciel::expirees()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Licenses Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">All Licenses</h2>
            @can('manage licenses')
            <a href="{{ route('admin.licences.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                <span class="material-symbols-outlined text-lg">add</span>
                <span>New License</span>
            </a>
            @endcan
        </div>
        
        <div class="p-5">
            <!-- Filters -->
            <form method="GET" class="flex flex-wrap gap-3 mb-5">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search licenses..." value="{{ request('search') }}">
                </div>
                <div class="w-44">
                    <select name="logiciel_id" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Software</option>
                        @foreach(\App\Models\Logiciel::all() as $logiciel)
                            <option value="{{ $logiciel->id }}" {{ request('logiciel_id') == $logiciel->id ? 'selected' : '' }}>
                                {{ $logiciel->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="w-40">
                    <select name="statut" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('statut') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expiring" {{ request('statut') == 'expiring' ? 'selected' : '' }}>Expiring Soon</option>
                        <option value="expired" {{ request('statut') == 'expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-lg align-middle">search</span>
                    </button>
                    <a href="{{ route('admin.licences.index') }}" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium transition-colors">
                        <span class="material-symbols-outlined text-lg align-middle">refresh</span>
                    </a>
                </div>
            </form>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-700">
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Software</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">License Key</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Purchase Date</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Expiration</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Seats</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Used</th>
                            <th class="text-center py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Available</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                        @forelse($licences as $licence)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="py-3 px-4">
                                <a href="{{ route('admin.logiciels.show', $licence->logiciel) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    {{ $licence->logiciel->nom }}
                                </a>
                            </td>
                            <td class="py-3 px-4">
                                <code class="px-2 py-1 bg-slate-100 dark:bg-slate-700 rounded text-xs font-mono text-slate-700 dark:text-slate-300">{{ $licence->cle_licence }}</code>
                            </td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-300">
                                {{ $licence->date_achat->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4 text-slate-600 dark:text-slate-300">
                                {{ $licence->date_expiration->format('d/m/Y') }}
                            </td>
                            <td class="py-3 px-4 text-center text-slate-700 dark:text-slate-300">
                                {{ $licence->nb_postes }}
                            </td>
                            <td class="py-3 px-4 text-center text-slate-700 dark:text-slate-300">
                                {{ $licence->installations_count }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($licence->postes_disponibles > 0)
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ $licence->postes_disponibles }}</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500 dark:bg-slate-700 dark:text-slate-400">0</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                @if($licence->estValide())
                                    @if($licence->estProcheExpiration(30))
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">Expiring</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Active</span>
                                    @endif
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">Expired</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('admin.logiciels.show', $licence->logiciel) }}" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="View Software">
                                        <span class="material-symbols-outlined text-lg">visibility</span>
                                    </a>
                                    @can('manage licenses')
                                    <button type="button" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/30 hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors" data-bs-toggle="modal" data-bs-target="#editLicenseModal{{ $licence->id }}" title="Edit">
                                        <span class="material-symbols-outlined text-lg">edit</span>
                                    </button>
                                    <form method="POST" action="{{ route('admin.logiciels.delete-licence', $licence) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-400 transition-colors delete-confirm" title="Delete">
                                            <span class="material-symbols-outlined text-lg">delete</span>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                        <span class="material-symbols-outlined text-3xl text-slate-400">key</span>
                                    </div>
                                    <p class="text-slate-500 dark:text-slate-400 mb-4">No licenses found</p>
                                    @can('manage licenses')
                                    <a href="{{ route('admin.licences.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined">add</span>
                                        Add License
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-5 flex justify-end">
                {{ $licences->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Edit License Modals -->
@foreach($licences as $licence)
<div class="modal fade" id="editLicenseModal{{ $licence->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.logiciels.update-licence', $licence) }}">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit License</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">License Key <span class="text-danger">*</span></label>
                        <input type="text" name="cle_licence" class="form-control" value="{{ $licence->cle_licence }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Purchase Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_achat" class="form-control" value="{{ $licence->date_achat->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Expiration Date <span class="text-danger">*</span></label>
                        <input type="date" name="date_expiration" class="form-control" value="{{ $licence->date_expiration->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Number of Seats <span class="text-danger">*</span></label>
                        <input type="number" name="nb_postes" class="form-control" value="{{ $licence->nb_postes }}" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ $licence->notes ?? '' }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update License</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
