@extends('layouts.app')

@php
$groupIcons = [
    'systeme' => 'settings',
    'email' => 'mail',
    'interface' => 'palette',
    'licences' => 'key',
    'notifications' => 'bell',
    'rapports' => 'chart-bar',
    'securite' => 'shield-alt',
    'tickets' => 'ticket-alt',
    'actifs' => 'desktop',
];
$icon = $groupIcons[$groupe] ?? 'cog';
$groupLabels = [
    'systeme' => 'Système',
    'email' => 'Email',
    'interface' => 'Interface',
    'licences' => 'Licences',
    'notifications' => 'Notifications',
    'rapports' => 'Rapports',
    'securite' => 'Sécurité',
    'tickets' => 'Tickets',
    'actifs' => 'Actifs',
];
$label = $groupLabels[$groupe] ?? ucfirst($groupe);
@endphp

@section('title', 'Paramètres - ' . $label)
@section('page-title', 'Paramètres - ' . $label)

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/60 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200/60 bg-slate-50/50">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">{{ $icon }}</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white">{{ $label }}</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Configurez les paramètres {{ strtolower($label) }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <span class="material-symbols-outlined text-lg">arrow_back</span>
                    Retour
                </a>
            </div>
        </div>
        
        <form method="POST" action="{{ route('admin.settings.update-multiple') }}" class="p-6">
            @csrf
            <input type="hidden" name="groupe" value="{{ $groupe }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($parametres as $parametre)
                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border border-slate-200/60 dark:border-slate-700/50">
                    <label class="block mb-2">
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $parametre->cle)) }}</span>
                        @if($parametre->description)
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $parametre->description }}</p>
                        @endif
                    </label>
                    
                    @php
                    $type = $parametre->type ?? 'string';
                    $valeur = $parametre->valeur ?? '';
                    @endphp
                    
                    @if($type === 'boolean')
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" 
                                   name="param_{{ $parametre->cle }}" 
                                   id="{{ $parametre->cle }}"
                                   value="true"
                                   {{ $valeur === 'true' || $valeur === '1' ? 'checked' : '' }}
                                   class="w-5 h-5 rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500 dark:bg-slate-700 dark:checked:bg-blue-600">
                            <span class="text-sm text-slate-600 dark:text-slate-400">Activé</span>
                        </label>
                    @elseif($type === 'text')
                        <textarea name="param_{{ $parametre->cle }}" 
                                  class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  rows="3">{{ $valeur }}</textarea>
                    @elseif($type === 'integer' || $type === 'decimal')
                        <input type="number" 
                               name="param_{{ $parametre->cle }}" 
                               class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ $valeur }}">
                    @else
                        <input type="{{ $type === 'email' ? 'email' : ($type === 'url' ? 'url' : 'text') }}" 
                               name="param_{{ $parametre->cle }}" 
                               class="w-full rounded-lg border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               value="{{ $valeur }}">
                    @endif
                </div>
                @endforeach
            </div>
            
            <div class="mt-6 pt-6 border-t border-slate-200/60 dark:border-slate-700/50 flex items-center gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-colors shadow-sm hover:shadow-md">
                    <span class="material-symbols-outlined">save</span>
                    Enregistrer
                </button>
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

