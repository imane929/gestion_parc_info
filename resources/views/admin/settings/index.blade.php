@extends('layouts.admin-new')

@section('title', 'Paramètres')
@section('page-title', 'Paramètres du système')

@section('content')
<div class="space-y-6">
    <!-- Settings Card -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Configuration</h2>
            <div class="flex gap-2">
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors" data-bs-toggle="modal" data-bs-target="#importModal">
                    <span class="material-symbols-outlined text-lg">upload</span>
                    Importer
                </button>
                <button type="button" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg text-sm font-medium transition-colors" onclick="window.location.href='{{ route('admin.settings.export') }}'">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Exporter
                </button>
            </div>
        </div>
        
        <div class="p-5">
            <!-- Settings Groups Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($groupes as $groupe)
                <a href="{{ route('admin.settings.groupe', $groupe) }}" class="block p-6 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-500 dark:hover:border-blue-500 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                    <div class="text-center">
                        @php
                            $icon = [
                                'systeme' => 'settings',
                                'email' => 'mail',
                                'tickets' => 'confirmation_number',
                                'actifs' => 'desktop_windows',
                                'licences' => 'key',
                                'interface' => 'palette',
                                'securite' => 'shield',
                                'rapports' => 'bar_chart',
                                'notifications' => 'notifications',
                            ][$groupe] ?? 'settings';
                            $color = [
                                'systeme' => 'text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900/30',
                                'email' => 'text-purple-600 dark:text-purple-400 bg-purple-100 dark:bg-purple-900/30',
                                'tickets' => 'text-orange-600 dark:text-orange-400 bg-orange-100 dark:bg-orange-900/30',
                                'actifs' => 'text-cyan-600 dark:text-cyan-400 bg-cyan-100 dark:bg-cyan-900/30',
                                'licences' => 'text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900/30',
                                'interface' => 'text-pink-600 dark:text-pink-400 bg-pink-100 dark:bg-pink-900/30',
                                'securite' => 'text-green-600 dark:text-green-400 bg-green-100 dark:bg-green-900/30',
                                'rapports' => 'text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-900/30',
                                'notifications' => 'text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/30',
                            ][$groupe] ?? 'text-slate-600 dark:text-slate-400 bg-slate-100 dark:bg-slate-800';
                        @endphp
                        <div class="w-14 h-14 rounded-2xl {{ $color }} flex items-center justify-center mx-auto mb-3">
                            <span class="material-symbols-outlined text-2xl">{{ $icon }}</span>
                        </div>
                        <h5 class="text-base font-semibold text-slate-900 dark:text-white mb-1">{{ ucfirst($groupe) }}</h5>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $parametres->where('groupe', $groupe)->count() }} paramètres
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div id="importModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeImportModal()"></div>
        <div class="inline-block align-bottom bg-white dark:bg-slate-800 rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form method="POST" action="{{ route('admin.settings.import') }}" enctype="multipart/form-data">
                @csrf
                <div class="px-4 py-4 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Importer les paramètres</h3>
                    <button type="button" onclick="closeImportModal()" class="p-1 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                        <span class="material-symbols-outlined text-slate-500">close</span>
                    </button>
                </div>
                <div class="p-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Fichier JSON</label>
                        <input type="file" name="fichier" class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" accept=".json" required>
                        <p class="mt-1 text-xs text-slate-500">Téléchargez un fichier JSON exporté du système</p>
                    </div>
                </div>
                <div class="px-4 py-3 bg-slate-50 dark:bg-slate-700/50 flex justify-end gap-2">
                    <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-white dark:bg-slate-600 border border-slate-300 dark:border-slate-500 text-slate-700 dark:text-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-600 transition-colors">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">Importer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openImportModal() {
        document.getElementById('importModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
    
    function closeImportModal() {
        document.getElementById('importModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('[data-bs-toggle="modal"][data-bs-target="#importModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            openImportModal();
        });
    });
</script>
@endpush
@endsection
