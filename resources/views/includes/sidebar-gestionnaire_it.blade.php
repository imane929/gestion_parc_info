@php
    $links = [
        ['route' => 'admin.dashboard.gestionnaire_it', 'pattern' => 'admin.dashboard.gestionnaire_it', 'icon' => 'space_dashboard', 'label' => 'Dashboard'],
        ['route' => 'admin.actifs.index', 'pattern' => 'admin.actifs.*', 'icon' => 'inventory_2', 'label' => 'Assets'],
        ['route' => 'admin.assignments', 'pattern' => 'admin.assignments', 'icon' => 'assignment_ind', 'label' => 'Assignments'],
        ['route' => 'admin.localisations.index', 'pattern' => 'admin.localisations.*', 'icon' => 'location_on', 'label' => 'Locations'],
        ['route' => 'admin.reports.index', 'pattern' => 'admin.reports.*', 'icon' => 'analytics', 'label' => 'Reports'],
        ['route' => 'admin.dashboard.analytics', 'pattern' => 'admin.dashboard.analytics', 'icon' => 'monitoring', 'label' => 'Analytics'],
    ];
@endphp

<div class="flex h-full flex-col px-4 py-6">
    <div class="flex items-center gap-3 px-2">
        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-brand-700 text-white shadow-lg">
            <span class="material-symbols-outlined">inventory</span>
        </div>
        <div>
            <p class="text-lg font-black tracking-tight text-slate-900 dark:text-white">AssetFlow</p>
            <p class="text-xs font-medium uppercase tracking-[0.25em] text-slate-400">Gestionnaire IT</p>
        </div>
    </div>

    <nav class="mt-8 space-y-2">
        @foreach ($links as $link)
            <a href="{{ route($link['route']) }}" class="{{ request()->routeIs($link['pattern']) ? 'bg-brand-50 text-brand-700 dark:bg-brand-950/70 dark:text-brand-300' : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-900' }} flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-semibold transition">
                <span class="material-symbols-outlined">{{ $link['icon'] }}</span>
                <span>{{ $link['label'] }}</span>
            </a>
        @endforeach
    </nav>
</div>
