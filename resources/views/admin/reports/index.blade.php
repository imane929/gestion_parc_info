@extends('layouts.admin-new')

@section('title', 'Rapports')
@section('page-title', 'Tableau de bord des rapports')

@section('content')
<div class="space-y-6">
    <!-- Report Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">desktop_windows</span>
                </div>
                <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Rapport des Actifs</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Générez des rapports détaillés sur tous les actifs informatiques, leur statut, leur emplacement et leurs affectations.</p>
                <a href="{{ route('admin.reports.actifs') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    Générer le Rapport
                </a>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">confirmation_number</span>
                </div>
                <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Rapport des Tickets</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Analysez les statistiques des tickets, les temps de résolution et les performances des techniciens.</p>
                <a href="{{ route('admin.reports.tickets') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    Générer le Rapport
                </a>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-cyan-100 dark:bg-cyan-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-cyan-600 dark:text-cyan-400">inventory_2</span>
                </div>
                <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Rapport d'Inventaire</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Vue d'ensemble complète de l'inventaire avec le nombre d'actifs par type, emplacement et âge.</p>
                <a href="{{ route('admin.reports.inventaire') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-cyan-600 hover:bg-cyan-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    Générer le Rapport
                </a>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-amber-600 dark:text-amber-400">build</span>
                </div>
                <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Rapport de Maintenance</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Suivez les activités de maintenance, les coûts et le respect du calendrier.</p>
                <a href="{{ route('admin.reports.maintenance') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    Générer le Rapport
                </a>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-red-600 dark:text-red-400">key</span>
                </div>
                <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Rapport des Licences</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Surveillez les licences logicielles, l'utilisation et les dates d'expiration.</p>
                <a href="{{ route('admin.reports.licences') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    Générer le Rapport
                </a>
            </div>
        </div>
        
        <div class="bg-white dark:bg-slate-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
            <div class="text-center">
                <div class="w-16 h-16 rounded-2xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-purple-600 dark:text-purple-400">description</span>
                </div>
                <h5 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Rapport des Contrats</h5>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Examinez les contrats de service, les prestataires et le respect des SLA.</p>
                <a href="{{ route('admin.reports.contrats') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg text-sm font-medium transition-colors">
                    <span class="material-symbols-outlined text-lg">bar_chart</span>
                    Générer le Rapport
                </a>
            </div>
        </div>
    </div>

    <!-- Custom Report Builder -->
    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700">
            <h6 class="text-lg font-semibold text-slate-900 dark:text-white">Générateur de Rapport Personnalisé</h6>
        </div>
        <div class="p-5">
            <form action="{{ route('admin.reports.personnalise') }}" method="GET" class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Type de Rapport</label>
                    <select name="type" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Sélectionner...</option>
                        <option value="actifs">Actifs</option>
                        <option value="tickets">Tickets</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="licences">Licences</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Période</label>
                    <select name="periode" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="30">Les 30 derniers jours</option>
                        <option value="60">Les 60 derniers jours</option>
                        <option value="90">Les 90 derniers jours</option>
                        <option value="180">Les 6 derniers mois</option>
                        <option value="365">L'année dernière</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Format</label>
                    <select name="format" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-700 border border-slate-200 dark:border-slate-600 rounded-lg text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="html">HTML (Vue)</option>
                        <option value="pdf">PDF</option>
                        <option value="csv">CSV</option>
                        <option value="xlsx">Excel</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-lg">trending_up</span>
                        Générer le Rapport Personnalisé
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
